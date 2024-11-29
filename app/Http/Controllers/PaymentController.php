<?php

namespace App\Http\Controllers;

use App\Events\OrderPaymentUpdateEvent;
use App\Events\OrderPlacedNotificationEvent;
use App\Events\RTOrderPlacedNotificationEvent;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Nafezly\Payments\Classes\PaymobPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /** Paypal Payment  */
    function setPaypalConfig(): array
    {
        $config = [
            'mode'    => config('gatewaySettings.paypal_account_mode'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => config('gatewaySettings.paypal_api_key'),
                'client_secret'     => config('gatewaySettings.paypal_secret_key'),
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => config('gatewaySettings.paypal_api_key'),
                'client_secret'     => config('gatewaySettings.paypal_secret_key'),
                'app_id'            => config('gatewaySettings.paypal_app_id'),
            ],

            'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => config('gatewaySettings.paypal_currency'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
            'locale'         => 'en_US', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => true, // Validate SSL when creating api client.
        ];

        return $config;
    }

    function payWithPaypal()
    {
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        /** calculate payable amount */
        $grandTotal = session()->get('grand_total');
        $payableAmount = round($grandTotal * config('gatewaySettings.paypal_rate'));

        $response = $provider->createOrder([
            'intent' => "CAPTURE",
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel')
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('gatewaySettings.paypal_currency'),
                        'value' => $payableAmount
                    ]
                ]
            ]
        ]);

        if(isset($response['id']) && $response['id'] != NULL){
            foreach($response['links'] as $link){
                if($link['rel'] === 'approve'){
                    return redirect()->away($link['href']);
                }
            }
        }else {
            return redirect()->route('payment.cancel')->withErrors(['error' => $response['error']['message']]);
        }
    }

    function paypalSuccess(Request $request, OrderService $orderService)
    {
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);


        if(isset($response['status']) && $response['status'] === 'COMPLETED'){

            $orderId = session()->get('order_id');

            $capture = $response['purchase_units'][0]['payments']['captures'][0];
            $paymentInfo = [
                'transaction_id' => $capture['id'],
                'currency' => $capture['amount']['currency_code'],
                'status' => 'completed'
            ];

            OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'PayPal');
            OrderPlacedNotificationEvent::dispatch($orderId);  // Email Notification
            RTOrderPlacedNotificationEvent::dispatch(Order::find($orderId));  //Real Time Notification with Pusher

            /** Clear session data */
            $orderService->clearSession();

            return redirect()->route('payment.success');
        }else {
            $this->transactionFailUpdateStatus('PayPal');
            return redirect()->route('payment.cancel')->withErrors(['error' => $response['error']['message']]);
        }
    }

    function paypalCancel()
    {
        $this->transactionFailUpdateStatus('PayPal');
        return redirect()->route('payment.cancel');
    }

    function payWithStripe() {

        Stripe::setApiKey(config('gatewaySettings.stripe_secret_key'));

        /** calculate payable amount */
        $grandTotal = session()->get('grand_total');
        $payableAmount = round($grandTotal * config('gatewaySettings.stripe_rate')) * 100;

        $response = StripeSession::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => config('gatewaySettings.stripe_currency'),
                        'product_data' => [
                            'name' => 'Product'
                        ],
                        'unit_amount' => $payableAmount
                    ],
                    'quantity' => 1
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel')
        ]);

        return redirect()->away($response->url);
    }
    function stripeSuccess(Request $request, OrderService $orderService) {
        $sessionId = $request->session_id;
        Stripe::setApiKey(config('gatewaySettings.stripe_secret_key'));

        $response = StripeSession::retrieve($sessionId);

        if($response->payment_status === 'paid') {

            $orderId = session()->get('order_id');
            $paymentInfo = [
                'transaction_id' => $response->payment_intent,
                'currency' => $response->currency,
                'status' => 'completed'
            ];

            OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'Stripe');
            OrderPlacedNotificationEvent::dispatch($orderId); // Email Notification
            RTOrderPlacedNotificationEvent::dispatch(Order::find($orderId)); //Real Time Notification with Pusher


            /** Clear session data */
            $orderService->clearSession();

            return redirect()->route('payment.success');
        }else {
            $this->transactionFailUpdateStatus('Stripe');
            return redirect()->route('payment.cancel');
        }
    }

    function stripeCancel() {
        $this->transactionFailUpdateStatus('Stripe');
        return redirect()->route('payment.cancel');
    }


    public function payWithPaymob(Request $request){
        $grandTotal = session()->get('grand_total');
        $payableAmount = round($grandTotal * config('gatewaySettings.stripe_rate')) * 100;

        $payment = new PaymobPayment();
        $response = $payment
            ->setUserFirstName('ww')
            ->setUserLastName('ww')
            ->setUserEmail('ww@ww.com')
            ->setUserPhone('11111111111')
            ->setAmount($grandTotal)
            ->pay();

        return redirect($response['redirect_url']);


    }
    function CallBack(Request $request) {
        dd($request->all());
        $callbackUrl = route('verify-payment', [
            'gateway' => 'paymob'
        ]);

        return $callbackUrl;
    }
    public function PaymobSuccess(Request $request,  OrderService $orderService)
    {
        dd($request->all());
        $payment = new PaymobPayment();
        $response = $payment->verify($request);

        dd($response);

        if($response->success === true) {

            $orderId = session()->get('order_id');
            $paymentInfo = [
                'transaction_id' => $response->payment_id,
                'currency' => $response->currency,
                'status' => 'completed'
            ];

//            OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'Paymob');
//            OrderPlacedNotificationEvent::dispatch($orderId);
//            RTOrderPlacedNotificationEvent::dispatch(Order::find($orderId));


            /** Clear session data */
//            $orderService->clearSession();

//            return redirect()->route('payment.success');
//        }else {
//            $this->transactionFailUpdateStatus('Paymob');
//            return redirect()->route('payment.cancel');
        }


        //output
        //[
        //    'success'=>true,//or false
        //    'payment_id'=>"PID",
        //    'message'=>"Done Successfully",//message for client
        //    'process_data'=>""//payment response
        //]
    }
    function PaymobCancel() {
        $this->transactionFailUpdateStatus('Paymob');
        return redirect()->route('payment.cancel');
    }

    function transactionFailUpdateStatus($gatewayName) : void {
        $orderId = session()->get('order_id');
        $paymentInfo = [
            'transaction_id' => '',
            'currency' => '',
            'status' => 'Failed'
        ];

        OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, $gatewayName);
    }


    public function payWithPaymob2($integration_id, $iframe_id_or_wallet_number)
    {
        // step 1: login to paymob
        $response = Http::withHeaders([
            'content-type' => 'application/json'
        ])->post('https://accept.paymobsolutions.com/api/auth/tokens',[
            "api_key"=> env('PAYMOB_API_KEY')
        ]);
        $json=$response->json();


        $grand_total = session()->get('grand_total');
        $orderId = session()->get('order_id');

        // step 2: send order data
        $response_final=Http::withHeaders([
            'content-type' => 'application/json'
        ])->post('https://accept.paymobsolutions.com/api/ecommerce/orders',[
            "auth_token"=>$json['token'],
            "delivery_needed"=>"false",
            "amount_cents"=>$grand_total*100,
            "merchant_order_id" => $orderId,
        ]);

        $json_final=$response_final->json();
//        dd($json_final);
        $user = Auth::user();
        $name = $user->name;
        if ((count(explode(" ",$name)) == 1)) {
            $first_name = $name;$last_name=$name;
        } else {
            $first_name = explode(" ",$name)[0];
            $last_name = explode(" ",$name)[1];
        }
        //  step 3: send customer data
        $response_final_final=Http::withHeaders([
            'content-type' => 'application/json'
        ])->post('https://accept.paymobsolutions.com/api/acceptance/payment_keys',[
            "auth_token"=>$json['token'],
            "expiration"=> 36000,
            "amount_cents"=>$json_final['amount_cents'],
            "order_id"=>$json_final['id'],
            "billing_data"=>[
                "first_name"            => $first_name,
                "last_name"             => $last_name,
                "phone_number"          => $user->phone ?: "NA",
                "email"                 => $user->email,
                "apartment"             => "NA",
                "floor"                 => "NA",
                "street"                => $user->address,
                "building"              => "NA",
                "shipping_method"       => "NA",
                "postal_code"           => $user->postal_code ?: "NA",
                "city"                  => $user->city ?: "NA",
                "state"                 => $user->state ?: "NA",
                "country"               => "EG",
            ],
            "currency"=>"EGP",
            "integration_id"=>$integration_id
        ]);
        $response_final_final_json=$response_final_final->json();

        return redirect('https://accept.paymobsolutions.com/api/acceptance/iframes/'. $iframe_id_or_wallet_number .'?payment_token=' . $response_final_final_json['token']);

    }
    public function callback2(Request $request): RedirectResponse
    {
        $payment_details = json_encode($request->all());
        if ($request->success === "true")
        {
            return (new CheckoutController)->checkout_done($request->merchant_order_id, $payment_details);
        } else {
            flash(translate('Payment Failed'))->error();
            return redirect()->route('payment.cancel');
        }
    }



}
