<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PaymentController;
use App\Livewire\Admin\AboutPage\AboutPageIndex;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\AdminManagement\AdminManagementCreate;
use App\Livewire\Admin\AdminManagement\AdminManagementEdit;
use App\Livewire\Admin\AdminManagement\AdminManagementIndex;
use App\Livewire\Admin\AdminProfile;
use App\Livewire\Admin\AppDownloadSection\AppDownloadSectionCreate;
use App\Livewire\Admin\AppDownloadSection\AppDownloadSectionEdit;
use App\Livewire\Admin\AppDownloadSection\AppDownloadSectionIndex;
use App\Livewire\Admin\BannerSlider\BannerSliderCreate;
use App\Livewire\Admin\BannerSlider\BannerSliderEdit;
use App\Livewire\Admin\BannerSlider\BannerSliderIndex;
use App\Livewire\Admin\Blog\BlogCommentIndex;
use App\Livewire\Admin\Blog\BlogCreate;
use App\Livewire\Admin\Blog\BlogEdit;
use App\Livewire\Admin\Blog\BlogIndex;
use App\Livewire\Admin\BlogCategory\BlogCategoryCreate;
use App\Livewire\Admin\BlogCategory\BlogCategoryEdit;
use App\Livewire\Admin\BlogCategory\BlogCategoryIndex;
use App\Livewire\Admin\Chat\ChatIndex;
use App\Livewire\Admin\Chef\ChefCreate;
use App\Livewire\Admin\Chef\ChefEdit;
use App\Livewire\Admin\Chef\ChefIndex;
use App\Livewire\Admin\Contacts\ContactIndex;
use App\Livewire\Admin\Counter\CounterCreate;
use App\Livewire\Admin\Coupon\CouponCreate;
use App\Livewire\Admin\Coupon\CouponEdit;
use App\Livewire\Admin\Coupon\CouponIndex;
use App\Livewire\Admin\CustomPageBuilder\CustomPageBuilderCreate;
use App\Livewire\Admin\CustomPageBuilder\CustomPageBuilderEdit;
use App\Livewire\Admin\CustomPageBuilder\CustomPageBuilderIndex;
use App\Livewire\Admin\DailyOffer\DailyOfferCreate;
use App\Livewire\Admin\DailyOffer\DailyOfferEdit;
use App\Livewire\Admin\DailyOffer\DailyOfferIndex;
use App\Livewire\Admin\DeliveryArea\DeliveryAreaCreate;
use App\Livewire\Admin\DeliveryArea\DeliveryAreaEdit;
use App\Livewire\Admin\DeliveryArea\DeliveryAreaIndex;
use App\Livewire\Admin\FooterInfo\FooterInfoIndex;
use App\Livewire\Admin\MenuBuilder\MenuBuilderCreate;
use App\Livewire\Admin\NewsLetter\NewsLetterIndex;
use App\Livewire\Admin\Orders\DeclinedOrders;
use App\Livewire\Admin\Orders\DeliveredOrders;
use App\Livewire\Admin\Orders\InprocessOrders;
use App\Livewire\Admin\Orders\OrderIndex;
use App\Livewire\Admin\Orders\OrderShow;
use App\Livewire\Admin\Orders\PendingOrders;
use App\Livewire\Admin\PrivacyPolicy\PrivacyPolicyIndex;
use App\Livewire\Admin\ProductCategories\ProductCategoryCreate;
use App\Livewire\Admin\ProductCategories\ProductCategoryEdit;
use App\Livewire\Admin\ProductCategories\ProductCategoryIndex;
use App\Livewire\Admin\ProductReviews\ProductReviewsIndex;
use App\Livewire\Admin\Products\ProductCreate;
use App\Livewire\Admin\Products\ProductEdit;
use App\Livewire\Admin\Products\ProductGallerys;
use App\Livewire\Admin\Products\ProductIndex;
use App\Livewire\Admin\Products\ProductVariant;
use App\Livewire\Admin\Reservation\ReservationIndex;
use App\Livewire\Admin\ReservationTime\ReservationTimeCreate;
use App\Livewire\Admin\ReservationTime\ReservationTimeEdit;
use App\Livewire\Admin\ReservationTime\ReservationTimeIndex;
use App\Livewire\Admin\Settings\Section\AppearanceSetting;
use App\Livewire\Admin\Settings\Section\GeneralSetting;
use App\Livewire\Admin\Settings\Section\LogoSettings;
use App\Livewire\Admin\Settings\Section\MailSettings;
use App\Livewire\Admin\Settings\Section\PaymobSettings;
use App\Livewire\Admin\Settings\Section\PayPalSettings;
use App\Livewire\Admin\Settings\Section\PusherSettings;
use App\Livewire\Admin\Settings\Section\SeoSetting;
use App\Livewire\Admin\Settings\Section\StripeSettings;
use App\Livewire\Admin\Settings\SettingIndex;
use App\Livewire\Admin\Slider\SliderCreate;
use App\Livewire\Admin\Slider\SliderEdit;
use App\Livewire\Admin\Slider\SliderIndex;
use App\Livewire\Admin\SocialLink\SocialLinkCreate;
use App\Livewire\Admin\SocialLink\SocialLinkEdit;
use App\Livewire\Admin\SocialLink\SocialLinkIndex;
use App\Livewire\Admin\Testimonial\TestimonialCreate;
use App\Livewire\Admin\Testimonial\TestimonialEdit;
use App\Livewire\Admin\Testimonial\TestimonialIndex;
use App\Livewire\Admin\TramsAndCondition\TramsAndConditionIndex;
use App\Livewire\Admin\WhyChooseUs\WhyChooseUsCreate;
use App\Livewire\Admin\WhyChooseUs\WhyChooseUsEdit;
use App\Livewire\Admin\WhyChooseUs\WhyChooseUsIndex;
use App\Livewire\Home\DashBoard\Sections\AddressSection;
use App\Livewire\Home\DashBoard\Sections\ChangePassword;
use App\Livewire\Home\DashBoard\Sections\MessageSection;
use App\Livewire\Home\DashBoard\Sections\OrderDetailsSection;
use App\Livewire\Home\DashBoard\Sections\OrderSection;
use App\Livewire\Home\DashBoard\Sections\PersonalInfo;
use App\Livewire\Home\DashBoard\Sections\ReservationSection;
use App\Livewire\Home\DashBoard\Sections\ReviewSection;
use App\Livewire\Home\DashBoard\Sections\WishlistSection;
use App\Livewire\Home\DashBoard\UserDashBoard;
use App\Livewire\Home\Frontend\AboutPage;
use App\Livewire\Home\Frontend\BlogDetails;
use App\Livewire\Home\Frontend\Blogs;
use App\Livewire\Home\Frontend\CartView;
use App\Livewire\Home\Frontend\Checkout;
use App\Livewire\Home\Frontend\Chefs;
use App\Livewire\Home\Frontend\ContactPage;
use App\Livewire\Home\Frontend\CustomPage;
use App\Livewire\Home\Frontend\Payment;
use App\Livewire\Home\Frontend\PaymentCancel;
use App\Livewire\Home\Frontend\PaymentSuccess;
use App\Livewire\Home\Frontend\PrivacyPolicyPage;
use App\Livewire\Home\Frontend\ProductDetails;
use App\Livewire\Home\Frontend\ProductsPage;
use App\Livewire\Home\Frontend\TestimonialPage;
use App\Livewire\Home\Frontend\TramsAndConditionPage;
use App\Livewire\Home\Home;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Home::class)->name('home');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::middleware(['role:admin','auth'])->group(function (){
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin/profile', AdminProfile::class)->name('admin.profile');

    Route::get('/admin/slider/index', SliderIndex::class)->name('admin.slider.index');
    Route::get('/admin/slider/create', SliderCreate::class)->name('admin.slider.create');
    Route::get('/admin/slider/{id}/edit', SliderEdit::class)->name('admin.slider.edit');

    Route::get('/admin/why-choose-us/index', WhyChooseUsIndex::class)->name('admin.why-choose-us.index');
    Route::get('/admin/why-choose-us/create', WhyChooseUsCreate::class)->name('admin.why-choose-us.create');
    Route::get('/admin/why-choose-us/{id}/edit', WhyChooseUsEdit::class)->name('admin.why-choose-us.edit');

    Route::get('/admin/category/index', ProductCategoryIndex::class)->name('admin.category.index');
    Route::get('/admin/category/create', ProductCategoryCreate::class)->name('admin.category.create');
    Route::get('/admin/category/{id}/edit', ProductCategoryEdit::class)->name('admin.category.edit');

    Route::get('/admin/product/index', ProductIndex::class)->name('admin.product.index');
    Route::get('/admin/product/create', ProductCreate::class)->name('admin.product.create');
    Route::get('/admin/product/{id}/edit', ProductEdit::class)->name('admin.product.edit');

    Route::get('/admin/product/ImageGallery/{id}', ProductGallerys::class)->name('admin.product.ImageGallery');
    Route::get('/admin/product/variants/{id}', ProductVariant::class)->name('admin.product.variants');

    Route::get('/admin/product/variants/{id}', ProductVariant::class)->name('admin.product.variants');

    /** Setting Routes */
    Route::get('/admin/setting', SettingIndex::class)->name('admin.setting.index');
    Route::get('/admin/setting/general-setting', GeneralSetting::class)->name('admin.setting.general-setting');
    Route::get('/admin/setting/stripe-setting', StripeSettings::class)->name('admin.setting.stripe-setting');
    Route::get('/admin/setting/paymob-setting', PaymobSettings::class)->name('admin.setting.paymob-setting');
    Route::get('/admin/setting/paypal-setting', PayPalSettings::class)->name('admin.setting.paypal-setting');
    Route::get('/admin/setting/pusher-setting', PusherSettings::class)->name('admin.setting.pusher-setting');
    Route::get('/admin/setting/mail-setting', MailSettings::class)->name('admin.setting.mail-setting');
    Route::get('/admin/setting/logo-setting', LogoSettings::class)->name('admin.setting.logo-setting');
    Route::get('/admin/setting/appearance-setting', AppearanceSetting::class)->name('admin.setting.appearance-setting');
    Route::get('/admin/setting/seo-setting', SeoSetting::class)->name('admin.setting.seo-setting');

    /** Coupon Routes */
    Route::get('/admin/coupon', CouponIndex::class)->name('admin.coupon.index');
    Route::get('/admin/coupon/create', CouponCreate::class)->name('admin.coupon.create');
    Route::get('/admin/coupon/{id}/edit', CouponEdit::class)->name('admin.coupon.edit');
    /** Delivery Area Routes */
    Route::get('/admin/delivery-area', DeliveryAreaIndex::class)->name('admin.delivery-area.index');
    Route::get('/admin/delivery-area/create', DeliveryAreaCreate::class)->name('admin.delivery-area.create');
    Route::get('/admin/delivery-area/{id}/edit', DeliveryAreaEdit::class)->name('admin.delivery-area.edit');

    /** Order Routes */
    Route::get('/admin/orders/index', OrderIndex::class)->name('admin.orders.index');
    Route::get('/admin/orders/{id}/show', OrderShow::class)->name('admin.orders.show');
    Route::get('/admin/pending-orders', PendingOrders::class)->name('admin.pending-orders');
    Route::get('/admin/inprocess-orders', InprocessOrders::class)->name('admin.inprocess-orders');
    Route::get('/admin/delivered-orders', DeliveredOrders::class)->name('admin.delivered-orders');
    Route::get('/admin/declined-orders', DeclinedOrders::class)->name('admin.declined-orders');

    /** Daily Offer Routes */
    Route::get('/admin/daily-offer/index', DailyOfferIndex::class)->name('admin.daily-offer.index');
    Route::get('/admin/daily-offer/create', DailyOfferCreate::class)->name('admin.daily-offer.create');
    Route::get('/admin/daily-offer/{id}/edit', DailyOfferEdit::class)->name('admin.daily-offer.edit');

    /** Banner Slider Routes */
    Route::get('/admin/banner-slider/index', BannerSliderIndex::class)->name('admin.banner-slider.index');
    Route::get('/admin/banner-slider/create', BannerSliderCreate::class)->name('admin.banner-slider.create');
    Route::get('/admin/banner-slider/{id}/edit', BannerSliderEdit::class)->name('admin.banner-slider.edit');

    /** Blogs Category Routes */
    Route::get('/admin/blog-category/index', BlogCategoryIndex::class)->name('admin.blog-category.index');
    Route::get('/admin/blog-category/create', BlogCategoryCreate::class)->name('admin.blog-category.create');
    Route::get('/admin/blog-category/{id}/edit', BlogCategoryEdit::class)->name('admin.blog-category.edit');

    /** Blogs Routes */
    Route::get('/admin/blogs/index', BlogIndex::class)->name('admin.blogs.index');
    Route::get('/admin/blogs/create', BlogCreate::class)->name('admin.blogs.create');
    Route::get('/admin/blogs/{id}/edit', BlogEdit::class)->name('admin.blogs.edit');
    Route::get('/admin/blogs-comments/index', BlogCommentIndex::class)->name('admin.blogs-comments.index');

    /** Chats Routes */
    Route::get('/admin/chat', ChatIndex::class)->name('admin.chat.index');

    /** chefs Routes */
    Route::get('/admin/chefs/index', ChefIndex::class)->name('admin.chefs.index');
    Route::get('/admin/chefs/create', ChefCreate::class)->name('admin.chefs.create');
    Route::get('/admin/chefs/{id}/edit', ChefEdit::class)->name('admin.chefs.edit');

    /** App Download Routes */
    Route::get('/admin/app-download/index', AppDownloadSectionIndex::class)->name('admin.app-download.index');

    /** Product Reviews */
    Route::get('/admin/product-reviews/index', ProductReviewsIndex::class)->name('admin.product-reviews.index');

    /** About Us Routes */
    Route::get('/admin/about/index', AboutPageIndex::class)->name('admin.about.index');
    /** Privacy Policy  Routes */
    Route::get('/admin/privacy-policy/index', PrivacyPolicyIndex::class)->name('admin.privacy-policy.index');
    /** Terms and Conditions Routes */
    Route::get('/admin/terms-and-conditions/index', TramsAndConditionIndex::class)->name('admin.terms-and-conditions.index');
    /** Contact Us Routes */
    Route::get('/admin/contact/index', ContactIndex::class)->name('admin.contact.index');
    /** Testimonial Routes */
    Route::get('/admin/testimonial/index', TestimonialIndex::class)->name('admin.testimonial.index');
    Route::get('/admin/testimonial/create', TestimonialCreate::class)->name('admin.testimonial.create');
    Route::get('/admin/testimonial/{id}/edit', TestimonialEdit::class)->name('admin.testimonial.edit');
    /** Counter Routes */
    Route::get('/admin/counter/index', CounterCreate::class)->name('admin.counter.index');
    /** Reservation Time Routes */
    Route::get('/admin/reservation-time/index', ReservationTimeIndex::class)->name('admin.reservation-time.index');
    Route::get('/admin/reservation-time/create', ReservationTimeCreate::class)->name('admin.reservation-time.create');
    Route::get('/admin/reservation-time/{id}/edit', ReservationTimeEdit::class)->name('admin.reservation-time.edit');
    /** Reservation Routes */
    Route::get('/admin/reservation/index', ReservationIndex::class)->name('admin.reservation.index');
   /** Menu Builder Routes */
    Route::get('/admin/menu-builder/index', MenuBuilderCreate::class)->name('admin.menu-builder.index');
    /** NewsLetter Routes */
    Route::get('/admin/news-letter/index', NewsLetterIndex::class)->name('admin.news-letter.index');
    /** Social Links Routes */
    Route::get('/admin/social-link/index', SocialLinkIndex::class)->name('admin.social-link.index');
    Route::get('/admin/social-link/create', SocialLinkCreate::class)->name('admin.social-link.create');
    Route::get('/admin/social-link/{id}/edit', SocialLinkEdit::class)->name('admin.social-link.edit');
    /** Footer Info Routes */
    Route::get('/admin/footer-info/index', FooterInfoIndex::class)->name('admin.footer-info.index');
    /** Custom Page Builder Routes */
    Route::get('/admin/custom-page-builder/index', CustomPageBuilderIndex::class)->name('admin.custom-page-builder.index');
    Route::get('/admin/custom-page-builder/create', CustomPageBuilderCreate::class)->name('admin.custom-page-builder.create');
    Route::get('/admin/custom-page-builder/{id}/edit', CustomPageBuilderEdit::class)->name('admin.custom-page-builder.edit');
    /** Admin Management Routes */
    Route::get('/admin/admin-management/index', AdminManagementIndex::class)->name('admin.admin-management.index');
    Route::get('/admin/admin-management/create', AdminManagementCreate::class)->name('admin.admin-management.create');
    Route::get('/admin/admin-management/{id}/edit', AdminManagementEdit::class)->name('admin.admin-management.edit');


});
Route::middleware(['role:user','auth'])->group(function (){
//    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/dashboard', UserDashBoard::class)->name('dashboard');
    Route::get('/personal-info', PersonalInfo::class)->name('personal-info');
    Route::get('/address-section', AddressSection::class)->name('address-section');
    Route::get('/reservation-section', ReservationSection::class)->name('reservation-section');
    Route::get('/order-section', OrderSection::class)->name('order-section');
    Route::get('/order-details/{id}', OrderDetailsSection::class)->name('order-details');
    Route::get('/wish-list-section', WishlistSection::class)->name('wish-list-section');
    Route::get('/reviews-section', ReviewSection::class)->name('reviews-section');
    Route::get('/message-section', MessageSection::class)->name('message-section');
    Route::get('/chang-password', ChangePassword::class)->name('chang-password');

});
Route::group(['middleware' => 'auth'], function(){
    /** checkout Routes */
    Route::get('/checkout', Checkout::class)->name('checkout.index');
    /** Payment Routes */
    Route::get('payment', Payment::class)->name('payment.index');
    /** PayPal Routes */
    Route::get('paypal/payment', [PaymentController::class, 'payWithPaypal'])->name('paypal.payment');
    Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');
    /** Stripe Routes */
    Route::get('stripe/payment', [PaymentController::class, 'payWithStripe'])->name('stripe.payment');
    Route::get('stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');
    Route::get('stripe/cancel', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');
    /** Paymob Routes */
    Route::get('/paymob/payment', [PaymentController::class, 'payWithPaymob'])->name('paymob.payment');
    Route::post('/call-back',[PaymentController::class,'PaymobSuccess']);
    Route::get('/call-back',[PaymentController::class,'PaymobSuccess']);
    Route::get('/payments/verify/{payment?}',[PaymentController::class,'PaymobSuccess'])->name('verify-payment');

    Route::get('payment/success', PaymentSuccess::class)->name('payment.success');
    Route::get('payment/cancel', PaymentCancel::class)->name('payment.cancel');
});

Route::get('/product-detail/{slug}', ProductDetails::class)->name('product-detail');
Route::get('/cart', CartView::class)->name('cart');
/** Blogs Routes */
Route::get('/blogs', Blogs::class)->name('blogs');
Route::get('/blogs/details/{slug}', BlogDetails::class)->name('blogs.details');
Route::get('/about', AboutPage::class)->name('about');
Route::get('/privacy-policy', PrivacyPolicyPage::class)->name('privacy-policy');
Route::get('/terms-and-conditions', TramsAndConditionPage::class)->name('terms-and-conditions');
Route::get('/contact', ContactPage::class)->name('contact');
Route::get('/chefs', Chefs::class)->name('chefs');
Route::get('/testimonials', TestimonialPage::class)->name('testimonials');
/** Custom Page Routes */
Route::get('/page/{slug}', CustomPage::class);
/** Product page Route*/
Route::get('/products', ProductsPage::class)->name('product.index');
/** Newsletter Routes */
Route::post('/subscribe-newsletter', [FrontendController::class, 'subscribeNewsletter'])->name('subscribe-newsletter');


