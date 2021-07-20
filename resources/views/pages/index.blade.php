<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <link rel="icon" href="{{ asset('images/yoga_logo.png') }}" type="image/gif" sizes="16x16">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <script src="vendors/jquery/dist/jquery.min.js"></script>
	<link href="css/jquery-ui.css" rel="Stylesheet"></link>
	<script src="js/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

	<script src="{{ url('/') }}/js/sha256.js"></script>
  	<script src="{{ url('/') }}/js/crypto-js.js"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body>
    <main class="wrapper">
        <section class="header-section">
            <div class="container">
                <header>
                    <a href="/"><img src="{{ asset('images/ayush-logo.png') }}" alt="ayush-logo" class="img-fluid ayush-logo"></a>
                    <ul class="home_page_btn">
                       @if(isset(Auth::user()->name))
                        <li><a href="/home" class="login">{{  Auth::user()->name }}</a> </li>
                        @else
                        <li class=""><a href= "javascript:void(0)" class="home_page active_home ">Home</a></li>
                        <li><a href= "/registration-form" class="register" data-toggle="modal" data-target=".bd-example-modal-lg">Register</a></li>
                        <!--<li><a href= "/login" class="login">Login</a></li>-->

                        @endif
                        <li><a href="#"><img src="{{ asset('images/yoga_logo.png') }}" alt="yoga-logo" class="img-fluid yoga-logo"></a>
                        </li>
				   </ul>
                </header>
                <div class="container container-sm">
                    <div class="app row">
                        <ul class="app-info col-50">
                            <li>
                                <h1>
                                    <img src="{{ asset('images/yoga_locator_logo.png') }}" alt="yoga-locator" class="img-fluid">
                                    &nbsp; Namaste-Yoga
                                </h1>
                            </li>
                            <li>
                                <p>An initiative by Ministry of Ayush, Government of India to Promote Yoga to all beneficieries (public,trainers, centers) and events all around the globe.</p>
								<p>Ministry of Ayush presents “The Namaste Yoga App” a one stop health solution that enables people to access yoga related information, yoga events and Yoga classes at their fingertips. The app also a provides information on one’s physical activity in terms of step count and calories burnt.</p>
                            </li>
                            <li>
                                <div class="label">App available on</div>
                                <a href="https://play.google.com/store/apps/details?id=yogatracker.np.com.yogatracker" class="play-store" target="_blank">Play Store</a>
                                <a href="https://apps.apple.com/in/app/yogalocator-2019/id1468285743
" class="app-store" target="_blank">App Store</a>
                            </li>
                        </ul>
                        <figure class="app-img col-50">
                            <img src="{{ asset('images/banner_img.png') }}" alt="banner" class="img-fluid">
                        </figure>
                    </div>
                </div>
            </div>
        </section>
		
        <section class="about-section">
            <div class="container">
                <div class="row">
                    <div class="col-33">
                        <div class="square events">
                            <div class="number">
                            @if(isset($events))
                              {{$events}}
                            @endif
                            </div>
                            <p class="title">Yoga Events</p>
                        </div>
                        <div class="square trainers">
                            <div class="number">
                            @if(isset($trainer))
                              {{$trainer}}
                            @endif
                            </div>
                            <p class="title">Yoga Trainer's</p>
                        </div>
                        <div class="square centers">
                            <div class="number">
                            @if(isset($center))
                              {{$center}}
                            @endif
                            </div>
                            <p class="title">Yoga Centre's</p>
                        </div>
                    </div>
                    <div class="col-66 about-content">
                        <h2>About the Ministry</h2>
                        <p>"The Ministry of Ayush was formed on 9th November 2014 to ensure the optimal development and propagation of Ayush systems of health care. Earlier it was known as the Department of Indian System of Medicine and Homeopathy (ISM&H) which was created in March 1995 and renamed as Department of Ayurveda, Yoga and Naturopathy, Unani, Siddha and Homeopathy (Ayush) in November 2003, with focused attention for development of Education and Research in Ayurveda, Yoga and Naturopathy, Unani, Siddha and Homeopathy."</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="bottom-art"><img src="{{ asset('images/bottom-art.svg') }}" alt="bottom-art" class="img-fluid"></section>
        <section class="features-section">
            <div class="container">
                <div class="row">
                    <div class="col-33">
                        <h2>App Features</h2>
                        <ul>
                            <li><img src="{{ asset('images/search.svg') }}" alt="" class="img-fluid"> Searching of Trainers, Events and Centre's in your city</li>
                            <li><img src="{{ asset('images/user.svg') }}" alt="" class="img-fluid"> Registration of Yoga Trainers and Centre's around the world</li>
                            <li><img src="{{ asset('images/star.svg') }}" alt="" class="img-fluid"> Submit a feedback for Events</li>
                            <li><img src="{{ asset('images/event.svg') }}" alt="" class="img-fluid"> Registering Events for promotional purposes</li>
                            <li><img src="{{ asset('images/navigation.svg') }}" alt="" class="img-fluid"> Navigation information to reach Yoga Centre's, Trainers and Events.</li>
                        </ul>
                    </div>
                    <div class="col-66 about-content"></div>
                </div>
            </div>
            <img src="{{ asset('images/features_bg.png') }}" alt="featured" class="img-fluid featured-img">
        </section>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-33">
                        &copy; {{date('Y')}} Ministry of Ayush.<br />Government of India, All rights reserved.
                    </div>
                    <div class="col-33">
                        This Portal is designed, developed and hosted by the Ministry of Ayush, Government of India.
                    </div>
                    <div class="col-33">Visitor count: {{$visitor_count}}</div>
                </div>
            </div>
        </footer>
    </main>
</body>

</html>

<script>
$('.home_page_btn a').click(function(e) {
    $('.home_page_btn a').removeClass('active_home');
    $(this).addClass('active_home');
});
</script>