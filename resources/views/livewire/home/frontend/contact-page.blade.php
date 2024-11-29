<div>
    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset(config('settings.breadcrumb')) }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>contact with us</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=============================
        CONTACT PAGE START
    ==============================-->
    <section class="fp__contact mt_100 xs_mt_70 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__contact_info">
                        <span><i class="fal fa-phone-alt"></i></span>
                        <div class="text">
                            <h3>call</h3>
                            <p>{{ @$contact->phone_one }}</p>
                            <p>{{ @$contact->phone_two }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__contact_info">
                        <span><i class="fal fa-envelope"></i></span>
                        <div class="text">
                            <h3>mail</h3>
                            <p>{{ @$contact->mail_one }}</p>
                            <p>{{ @$contact->mail_two }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__contact_info">
                        <span><i class="fas fa-street-view"></i></span>
                        <div class="text">
                            <h3>location</h3>
                            <p>{!! @$contact->address !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fp__contact_form_area mt_100 xs_mt_70">
                <div class="row">
                    <div class="col-xl-12 wow fadeInUp" data-wow-duration="1s">
                        <form wire:submit.prevent="sendContactMessage" class="fp__contact_form">
                            @csrf
                            <h3>contact</h3>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="fp__contact_form_input">
                                        <span><i class="fal fa-user-alt"></i></span>
                                        <input wire:model="name" type="text" placeholder="Name" name="name">
                                    </div>
                                    @error('name') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="fp__contact_form_input">
                                        <span><i class="fal fa-envelope"></i></span>
                                        <input wire:model="email" type="email" placeholder="Email" name="email">
                                    </div>
                                    @error('email') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-xl-12 col-lg-12">
                                    <div class="fp__contact_form_input">
                                        <span><i class="fal fa-book"></i></span>
                                        <input wire:model="subject" type="text" placeholder="Subject" name="subject">
                                    </div>
                                    @error('subject') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-xl-12">
                                    <div class="fp__contact_form_input textarea">
                                        <span><i class="fal fa-book"></i></span>
                                        <textarea wire:model="message" rows="8" placeholder="Message" name="message"></textarea>
                                    </div>
                                    @error('message') <span class="error">{{ $message }}</span> @enderror
                                    <button type="submit" class="submit_btn">send message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt_100 xs_mt_70">
                    <div class="col-xl-12 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__contact_map">
                            <iframe
                                src="{{ @$contact->map_link }}"
                                style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        CONTACT PAGE END
    ==============================-->
</div>
