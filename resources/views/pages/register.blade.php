<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name') }}</title>

        <link rel="icon" href="{{ asset('images/yoga_logo.png') }}" type="image/gif" sizes="16x16">
        <script src="/vendors/jquery/dist/jquery.min.js"></script>
        <link href="{{ url('/') }}/css/register/popiens.css" rel="stylesheet">
        <link href="{{ url('/') }}/css/register/autocomplete.css" rel="Stylesheet"></link>
        <script src="{{ url('/') }}/js/register/autocomplte.js" ></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="{{ url('/') }}/css/register/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="{{ url('/') }}/js/register/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ url('/') }}/css/register/bootstrap-float-label.min.css"/>
        <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" />
        <script src="{{ url('/') }}/js/sha256.js"></script>
        <script src="{{ url('/') }}/js/crypto-js.js"></script>
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">


    </head>

    <body>
		@extends('layout/modal')
        <main class="wrapper">
            <section class="header-section trainer_bg">
                <div class="container">
                    <header>
                        <a href="/"><img src="{{ asset('images/ayush-logo.png') }}" alt="ayush-logo" class="img-fluid ayush-logo"></a>
                        <ul class="home_page_btn">

                            @if(isset(Auth::user()->name))
                            <li><a href="/home" class="login">{{  Auth::user()->name }}</a> </li>
                            @else
                            <li class=""><a href= "/" class="home_page  ">Home</a></li>
                            <li ><a href= "/registration-form" class="register active_home" data-toggle="modal" data-target=".bd-example-modal-lg">Register</a></li>
                            @endif
                            <li><a href="#"><img src="{{ asset('images/yoga_logo.png') }}" alt="yoga-logo" class="img-fluid yoga-logo"></a>
                            </li>
                        </ul>
                    </header>
                    <!-- Large modal -->
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button> -->

                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 trainer_form">


                                    <div class="trainer_header clearfix">
                                        <div class="col-md-12">
                                            <h2 class="register_header">Register</h2>
                                        </div>
                                    </div>
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-home-trainer"  href="#nav-trainer" role="tab" aria-controls="nav-trainer" aria-selected="true">Trainer</a>
                                            <a class="nav-item nav-link" id="nav-profile-center"    href="#nav-center" role="tab" aria-controls="nav-center" aria-selected="false">Centre</a>
                                            <a class="nav-item nav-link"   href="#nav-otp" role="tab" aria-controls="nav-center" aria-selected="false"></a>
                                        </div>
                                    </nav>

                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active in" id="nav-trainer" role="tabpanel" aria-labelledby="nav-trainer-tab">
                                            <form class="main_form" autocomplete="off">

                                                <div class="row">
                                                    <div class="col-md-4">

                                                        <div class="form-outline">

                                                            <span class="form-group has-float-label ">
                                                                <input type="text" id="trainer_name" name="trainer_name" onKeyPress="return ValidateAlpha(event);" class="form-control" placeholder="&nbsp;"/>
                                                                <label class="form-control-placeholder trainer_name" for="trainer_name">Trainer Name</label>
                                                                <div class="trainer_class__validation hide errormsg">Please enter trainer name</div>

                                                            </span>





                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-outline">
                                                            <span class="form-group has-float-label">
                                                                <input type="email" id="trainer_email" class="form-control"  placeholder="&nbsp;" />
                                                                <label class="form-control-placeholder" for="trainer_email">Email Id</label>
                                                                <div class="email_class__validation hide errormsg">Please enter valid email address</div>
                                                            </span>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-outline">
                                                            <span class="form-group has-float-label">
                                                                <input type="text" id="trainer_mobile"    placeholder="&nbsp;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"   class="form-control" minlength="10" maxlength="10"/>
                                                                <label class="form-control-placeholder" for="trainer_mobile">Mobile Number</label>
                                                                <div class="mobile hide errormsg">Please enter mobile number</div>

                                                            </span>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-outline">
                                                            <span class="form-group has-float-label">
                                                                <input type="password" id="trainer_password"  maxlength="15" minlength="8"  class="form-control" placeholder="&nbsp;" />
                                                                <label class="form-control-placeholder" for="trainer_password">Password</label>
                                                                <a href="javascript:void(0)"> <span toggle="#password-field"  class="fa fa-fw fa-eye field_icon form-icns toggle-password"></span></a>
                                                                <div class="password_valid hide errormsg">Please enter password</div>

                                                            </span>


                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-outline">

                                                            <span class="form-group has-float-label">
                                                                <input type="password" id="trainer_confirmpassword"  maxlength="15"  minlength="8" class="form-control" placeholder="&nbsp;"/>
                                                                <label class="form-control-placeholder" for="trainer_confirmpassword">Confirm Password</label>
                                                                <a href="javascript:void(0)"><span toggle="#password-field1" class="fa fa-fw fa-eye form-icns field_icon toggle-password1"></span></a>
                                                                <div class="Cpassword_valid hide errormsg">Please enter confirm password</div>
                                                            </span>






                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 certificate_no_div">
                                                        <div class="form-outline">
                                                            <span class="form-group has-float-label">
                                                                <input type="text" id="trainer_certificate_no" name="trainer_certificate_no" maxlength="15" minlength="3"  class="form-control" placeholder="&nbsp;" />
                                                                <label class="form-control-placeholder" for="trainer_certificate_no">Certificate Number</label>
                                                                <div class="certificate_valid hide errormsg">Please enter valid certificate number</div>

                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-outline">
                                                            <span class="form-group has-float-label">
                                                                <input type="text" id="trainer_location" name="trainer_location" class="form-control" readonly placeholder="&nbsp;"/>
                                                                <label class="form-control-placeholder" for="trainer_location">Get Location</label>
                                                                <div class="location_valid hide errormsg">Please select your location</div>
                                                                <i class="fa fa-map-marker green-icn form-icns" aria-hidden="true"></i>

                                                            </span>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-outline">
                                                            <span class="form-group has-float-label">

                                                                <textarea class="form-control" id="trainer_address" name="trainer_address" placeholder="&nbsp;"  rows="2"></textarea>
                                                                <label class="form-control-placeholder" for="trainer_address">Address</label>
                                                                <div class="address_valid hide errormsg">Please enter your address</div>

                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row city-aligment">
                                                    <div class="col-md-4 col-xs-12">
                                                        <div class="form-outline">
                                                            <label class="label">Choose City as:</label>

                                                            <div class="custom-inline-radio-btn">
                                                                <div class="custom-control custom-radio custom-control-inline">

                                                                    <input type="radio" id="curent_city" name="city_input" value="curent_city" class="custom-control-input">
                                                                    <label class="custom-control-label" for="curent_city">Current city</label>
                                                                </div>
                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" id="nerarby_city" name="city_input" value="nearby_city" class="custom-control-input">
                                                                    <label class="custom-control-label" for="nerarby_city">Nearby city</label>


                                                                </div>
                                                            </div>
                                                              <div class="city_valid hide errormsg">Please choose atleast one city type</div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <div class="form-outline">



                                                            <div class="searchbox">
                                                                <input  type="search" id="trainer_city_search" name="city_name" onKeyPress="return ValidateAlpha(event);"  placeholder="Search City" class="form-control"/>
                                                                <i class="fa fa-search green-icn form-icns"></i>
                                                                <div class="serch_valid hide errormsg">Please search city</div>
                                                            </div>
                                                        </div>
                                                        
                                                        <input type="hidden" id="search_city_hidden" name="city_id"/>
                                                          <input type="hidden" id="state_id" name="state_id"/>
                                                        <input type="hidden" id="distance" name="distance"/>
                                                        
                                                        <input type="hidden" id="latitude_hidden" name="city_latitude"/>
                                                        <input type="hidden" id="longitude_hidden" name="city_logitude"/>
                                                        
                                                        <input type="hidden" id="current_lat" value= "28.644800" />
                                                        <input type="hidden" id="current_lon" value= "77.216721" />
                                                        
                                                        <input type="hidden" id="form_type" name="form_type" value='1'/>
                                                        <input type="hidden" id="Choose_trainer" name="Choose_trainer" />
                                                    </div>

                                                    <div class="col-md-4 col-xs-12 choose_trainer_div form-outline">
                                                        <label class="label">Choose Trainer as:</label>
                                                        <div class="custom-inline-radio-btn">

                                                            <div class="custom-control custom-radio custom-control-inline">

                                                                <input type="radio" id="public_trainer" name="trainer" value="Public" class="custom-control-input">
                                                                <label class="custom-control-label" for="public_trainer">Public</label>

                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">

                                                                <input type="radio" id="private_trainer" name="trainer" value="Private" class="custom-control-input">
                                                                <label class="custom-control-label" for="private_trainer">Private</label>

                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">

                                                                <input type="radio" id="govt_trainer" name="trainer" value="Government"  class="custom-control-input">
                                                                <label class="custom-control-label" for="govt_trainer">Government</label>



                                                            </div>
                                                        </div>
                                                        <div class="trainer_type_valid hide errormsg">Please choose atleast one trainer</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-check">
                                                            <label class="custom-checkbox"> Yes I agree to the  <a href="{{ url('terms_and_conditions.html') }}" target="_blank">terms of use</a>
                                                                <input type="checkbox" name="terms_condition_check" value="1" id="terms_condition_check"  checked="checked">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <div class="tcheck hide errormsg">Please select terms of use.</div>



                                 <!-- <input class="form-check-input" type="checkbox" name="terms_condition_check" value="1" required id="terms_condition_check" checked> -->
                                                            <!-- <label class="form-check-label" for="terms_condition_check">Yes I agree to the </label> -->


                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary get_otp">Get OTP</button>
                                            </form>


                                        </div>
                                        <!-- <div class="tab-pane fade" id="nav-center" role="tabpanel" aria-labelledby="nav-center-tab">
                                         <h1>cener</h1>


                                        </div> -->






                                        <div class="tab-pane fade" id="nav-otp" role="tabpanel" aria-labelledby="nav-center-tab">



                                            <form class="otp_form">
                                                <div class="form-row">
                                                    <div class="col-md-4 mb-3">

                                                        <label>OTP Details:</label>
                                                        <input type="text" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"  id="otp" placeholder="Enter 6 digit otp" minlength="6" maxlength="6" >
                                                        <div class="otp_class__validation hide errormsg">Please enter OTP</div>

                                                        <a href="javascript:void(0)" class="resend invisible" >Resend OTP</a>


                                                    </div>
                                                    <div class="clearfix">
                                                        <div class="col-md-6 mb-3">
                                                            <button class="btn btn-primary register_btn"  type="button">Register</button>
                                                        </div>
                                                        <a  href = "javascript:void(0)" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="information_html_div clearfix">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- <div class="container container-sm">
                        <div class="app row">
                            <ul class="app-info col-50">
                                <li>
                                    <h1><img src="{{ asset('images/yoga_locator_logo.png') }}" alt="yoga-locator" class="img-fluid">
                                        &nbsp;Namaste-Yoga</h1>
                                </li>
                                <li>
                                    <p>An initiative by Ministry of Ayush, Government of India to Promote Yoga to all
                                        beneficieries (public,trainers, centers) and events all around the globe.</p>
                                </li>
                                <li>
                                    <div class="label">App available on</div>
                                    <a href="https://play.google.com/store/apps/details?id=yogatracker.np.com.yogatracker" class="play-store">Play Store</a>
                                    <a href="https://apps.apple.com/in/app/yogalocator-2019/id1468285743" class="app-store">App Store</a>
                                </li>
                            </ul>
                            <figure class="app-img col-50">
                                <img src="{{ asset('images/banner_img.png') }}" alt="banner" class="img-fluid">
                            </figure>
                        </div>
                    </div> -->
                </div>

            </section>
            <!-- <section class="about-section">
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
                            <h2>App Features</h2>
                            <p>"The Ministry of AYUSH was formed on 9th November 2014 to ensure the optimal development and
                                propagation of AYUSH systems of health care. Earlier it was known as the Department of
                                Indian
                                System of Medicine and Homeopathy (ISM&H) which was created in March 1995 and renamed as
                                Department of Ayurveda, Yoga and Naturopathy, Unani, Siddha and Homeopathy (AYUSH) in
                                November
                                2003, with focused attention for development of Education and Research in Ayurveda, Yoga and
                                Naturopathy, Unani, Siddha and Homeopathy."</p>
                        </div>
                    </div>
                </div>
            </section> -->
            <!-- <section class="bottom-art"><img src="{{ asset('images/bottom-art.svg') }}" alt="bottom-art" class="img-fluid"></section> -->
            <!-- <section class="features-section">
                <div class="container">
                    <div class="row">
                        <div class="col-33">
                            <h2>About</h2>
                            <ul>
                                <li><img src="{{ asset('images/search.svg') }}" alt="" class="img-fluid"> Searching of Trainers,
                                    Events and Centre’s in your city</li>
                                <li><img src="{{ asset('images/user.svg') }}" alt="" class="img-fluid"> Registration of Yoga
                                    Trainers and Centre’s around the world</li>
                                <li><img src="{{ asset('images/star.svg') }}" alt="" class="img-fluid"> Submit a feedback for Events
                                </li>
                                <li><img src="{{ asset('images/event.svg') }}" alt="" class="img-fluid"> Registering Events for
                                    promotional purposes</li>
                                <li><img src="{{ asset('images/navigation.svg') }}" alt="" class="img-fluid"> Navigation information
                                    to reach Yoga Centre’s, Trainers and Events.</li>
                            </ul>
                        </div>
                        <div class="col-66 about-content"></div>
                    </div>
                </div>
                <img src="{{ asset('images/features_bg.png') }}" alt="featured" class="img-fluid featured-img">
            </section> -->


            <div class="modal fade" id="map_modal" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Map</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="address_address">Address</label>
                                <!-- <input type="text" id="address-input" name="address_address" class="form-control map-input"> -->
                                <input type="hidden" name="address_latitude" id="txtLat" value="0" />
                                <input type="hidden" name="address_longitude"   id="txtLng"  value="0" />
                                <input type="hidden" name="address_longitude" id="city_type" />
                            </div>
                            <div class="map_html">
                                <div class="col-md-9 col-sm-9 col-xs-12" style="width:100%;height:300px; ">
                                    <div id="map_canvas" style="width: auto; height: 300px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <footer>
                <div class="container">
                    <div class="row">
                        <div class="col-33">
                            &copy; {{date('Y')}} Ministry of AYUSH.<br />Government of India, All rights reserved.
                        </div>
                        <div class="col-33">
                            This Portal is designed, developed and hosted by the Ministry of AYUSH, Government of India.
                        </div>
                        <div class="col-33">Visitor count: {{$visitor_count}}</div>
                    </div>
                </div>
            </footer> -->
        </main>
    </body>

</html>

<style>
    .modal_body_text {
        color: #73879C;
        font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
        font-size: 13px;
        font-weight: 400;
        line-height: 1.471;
    }
</style>

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
<script>

                                                            $(document).ready(function () {
                                                                $('.home_page_btn a').click(function (e) {
                                                                    $('.home_page_btn a').removeClass('active_home');
                                                                    $(this).addClass('active_home');
                                                                });

                                                                $('.edit').on('click', function () {
                                                                    $('.register_header').text('Register');
                                                                    $('.nav-tabs a[href="#nav-trainer"]').tab('show');
                                                                    $('#nav-trainer').addClass('show');
                                                                    $('#nav-home-trainer,#nav-profile-center').show();
                                                                })


                                                                $(document).on('click', '.toggle-password', function () {
                                                                    $(this).toggleClass("fa-eye fa-eye-slash");
                                                                    var input = $("#trainer_password");
                                                                    input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
                                                                });
                                                                $(document).on('click', '.toggle-password1', function () {
                                                                    $(this).toggleClass("fa-eye fa-eye-slash");
                                                                    var input = $("#trainer_confirmpassword");
                                                                    input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
                                                                });



                                                                var sitting_capacity = '<div class="form-outline"> <span class="form-group has-float-label">  <input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 &amp;&amp; event.charCode <= 57" id="sitting_capacity" maxlength="6" name="sitting_capacity"  class="form-control" placeholder="&nbsp;" required /><label class="form-control-placeholder" for="sitting_capacity">Seating Capacity</label><div class="capacity_valid hide errormsg">Please enter Seating Capacity </div></span></div>';









                                                                var trainer_capacity = '<div class="form-outline"><span class="form-group has-float-label"><input type="text" id="trainer_certificate_no" name="trainer_certificate_no" maxlength="15" minlength="3"  class="form-control" placeholder="&nbsp;" /><label class="form-control-placeholder" for="trainer_certificate_no">Certificate Number</label>  <div class="certificate_valid hide errormsg">Please enter valid certificate number</div></span></div>';

                                                                $('#nav-home-trainer').on('click', function () { // for trainer tab click
                                                                  $('.trainer_class__validation,.email_class__validation,.mobile,.password_valid ,.Cpassword_valid,.capacity_valid ,.location_valid,.address_valid,.city_valid,.serch_valid,.trainer_type_valid,.tcheck').addClass('hide');




                                                                  $('.main_form')[0].reset();
                                                                    $('#form_type').val('1')
                                                                    $('#nav-profile-center').removeClass('active');
                                                                    $('#nav-home-trainer').addClass('active');
                                                                    $('.certificate_no_div').html(trainer_capacity);
                                                                    $('.choose_trainer_div').show();
                                                                    $('.trainer_name').text('Trainer Name')
                                                                    $('#Choose_trainer').val('');
                                                                    $('.trainer_class__validation').text('Please enter trainer name');

                                                                    $('#trainer_name').attr("onkeypress","return ValidateAlpha(event);");
                                                                    initialize()




                                                                })


                                                                $('#nav-profile-center').on('click', function () {  // for center tab click
                                                                    $('.trainer_class__validation,.email_class__validation,.mobile,.password_valid ,.Cpassword_valid,.certificate_valid,.location_valid,.address_valid,.city_valid,.serch_valid,.trainer_type_valid,.tcheck').addClass('hide');
                                                                  $('.main_form')[0].reset();
                                                                    $('#form_type').val('2')
                                                                    $('#nav-home-trainer').removeClass('active');
                                                                    $('#nav-profile-center').addClass('active');
                                                                    $('.certificate_no_div').html(sitting_capacity);
                                                                    $('.choose_trainer_div').hide();
                                                                    $("input[name='trainer']").prop('checked', false);
                                                                    $('#Choose_trainer').val('');
                                                                    $('.trainer_name').text('Center Name')
                                                                    $('.trainer_class__validation').text('Please enter center name')
                                                                      $('#trainer_name').attr("onkeypress"," ");
                                                                      initialize()

                                                                })



                                                                $('input:radio[name=city_input]').on('click', function () {
                                                                    $('#city_type').val($(this).val());
// $('#city_checked').val()

                                                                })


                                                                $('#trainer_location').on('click', function () {
                                                                    $('#map_modal').modal('show');
                                                                })







                                                                $("input[name='trainer']").on('click', function () {
                                                                    $('#Choose_trainer').val($(this).val());

                                                                })





                                                                $(".get_otp,.resend").click(function () {
                                                                    var trainer_name = $("#trainer_name").val();
                                                                    var email = $("#trainer_email").val();
                                                                    var mobile = $("#trainer_mobile").val();
                                                                    var password = $("#trainer_password").val();
                                                                    var Cpassword = $("#trainer_confirmpassword").val();
                                                                    var certificate = $("#trainer_certificate_no").val();
                                                                    var locationval = $("#trainer_location").val();
                                                                    var city_search = $("#trainer_city_search").val();

                                                                    var adress = $("#trainer_address").val();
                                                                    var cond1;
                                                                    var cond2
                                                                    var cond3
                                                                    var cond4
                                                                    var cond5
                                                                    var cond6
                                                                    var cond7
                                                                    var cond8
                                                                    var cond9
                                                                    var cond10
                                                                    var cond11
                                                                    var cond12
                                                                    if (trainer_name == '') {
                                                                        $(".trainer_class__validation").removeClass('hide');
                                                                        cond1 = false;
                                                                    } else {
                                                                        $(".trainer_class__validation").addClass('hide');
                                                                        cond1 = true;
                                                                    }
                                                                    if (email == '') {
                                                                        $(".email_class__validation").removeClass('hide');
                                                                        $(".email_class__validation").text('Please enter  email address');
                                                                        cond2 = false;
                                                                    } else {
                                                                        let value = validateEmail(email);

                                                                        if (value == true) {
                                                                            $(".email_class__validation").addClass('hide');
                                                                            cond2 = true;

                                                                        } else {
                                                                            $(".email_class__validation").removeClass('hide');
                                                                            $(".email_class__validation").text('Please enter valid email address');
                                                                            cond2 = false;

                                                                        }

                                                                    }

                                                                    if (mobile == '') {
                                                                        $(".mobile").removeClass('hide');
                                                                        $(".mobile").text('Please enter mobile number');
                                                                        cond3 = false;

                                                                    } else {
                                                                        if (mobile.length < 10) {
                                                                            $(".mobile").removeClass('hide');
                                                                            $(".mobile").text('Mobile number length must be 10');
                                                                            cond3 = false;


                                                                        }else if(mobile.charAt(0)!=9 && mobile.charAt(0)!=8 && mobile.charAt(0)!=7 && mobile.charAt(0)!=6){
                                                                          $(".mobile").removeClass('hide');
                                                                          $(".mobile").text('Please enter valid mobile number');
                                                                          cond3 = false;

                                                                        }



                                                                        else {
                                                                            $(".mobile ").addClass('hide');
                                                                            cond3 = true;

                                                                        }




                                                                    }

                                                                    if (password == '') {
                                                                        $(".password_valid").removeClass('hide');
                                                                        $(".password_valid").text('Please enter password');

                                                                        cond4 = false;

                                                                    } else {
                                                                        let pval = CheckPassword(password)

                                                                        if (pval == true) {
                                                                            $(".password_valid").addClass('hide');
                                                                            cond4 = true;

                                                                        } else {
                                                                            $(".password_valid").removeClass('hide');
                                                                            $(".password_valid").text('Password must contain at least 8-15 characters,including UPPER/LOWERCASE,special symbols and numbers');
                                                                            cond4 = false;

                                                                        }

                                                                    }



                                                                    if (Cpassword == '') {

                                                                        $(".Cpassword_valid ").removeClass('hide');
                                                                        $(".Cpassword_valid ").text('Please enter confirm password');

                                                                        cond5 = false;
                                                                    } else if (password != Cpassword) {

                                                                        $(".Cpassword_valid ").removeClass('hide');
                                                                        $(".Cpassword_valid ").text('Password and confirm password must be same');
                                                                        cond5 = false;

                                                                    } else {

                                                                        let Cpval = CheckPassword(Cpassword);

                                                                        if (Cpval == true) {

                                                                            $(".Cpassword_valid").addClass('hide');
                                                                            cond5 = true;

                                                                        } else {

                                                                            $(".Cpassword_valid ").removeClass('hide');
                                                                            $(".Cpassword_valid").text('Confirm Password must contain at least 8-15 characters,including UPPER/LOWERCASE,special symbols and numbers');


                                                                        }
                                                                    }

                                                                    if ($('#form_type').val() == 1) {

                                                                        if (certificate == '') {

                                                                            $(".certificate_valid").removeClass('hide');
                                                                            cond6 = false;


                                                                        } else {

                                                                            let val = check_certificate(certificate);

                                                                            if (val == true) {
                                                                                $(".certificate_valid").addClass('hide');
                                                                                $(".certificate_valid").text('Please enter certificate number');
                                                                                cond6 = true;


                                                                            } else {
                                                                                $(".certificate_valid").text('Certificate must containat at least 3-15 characters,including characters and numbers');
                                                                                $(".certificate_valid").removeClass('hide');
                                                                                cond6 = false;

                                                                            }
                                                                        }


                                                                        if ($('#Choose_trainer').val() == '') {
                                                                            $(".trainer_type_valid ").removeClass('hide');
                                                                            cond7 = false;


                                                                        } else {
                                                                            $(".trainer_type_valid ").addClass('hide');
                                                                            cond7 = true;

                                                                        }

                                                                    } else {
                                                                        cond6 = true;
                                                                        cond7 = true;
                                                                        $(".trainer_type_valid ").addClass('hide');
                                                                        if ($('#sitting_capacity').val() == '') {
                                                                            $(".capacity_valid").removeClass('hide');
                                                                              $(".capacity_valid").text('Please enter Seating Capacity');
                                                                            cond6 = false;


                                                                        } else {
                                                                                    if ($('#sitting_capacity').val() < 10 || $('#sitting_capacity').val() > 99999) {
                                                                                      $(".capacity_valid").removeClass('hide');
                                                                                      $(".capacity_valid").text('Seating Capacity should be 10 or more then 10 and should be less then 99999 or equal to 99999');
                                                                                      cond6 = false;

                                                                                    }else{

                                                                                      $(".capacity_valid").addClass('hide');
                                                                                      cond6 = true;
                                                                                    }




                                                                        }







                                                                    }




                                                                    if (locationval == '') {
                                                                        $(".location_valid ").removeClass('hide');
                                                                        cond8 = false;

                                                                    } else {
                                                                        $(".location_valid ").addClass('hide');
                                                                        cond8 = true;

                                                                    }

                                                                    if (adress == '') {
                                                                        $(".address_valid  ").removeClass('hide');
                                                                        cond9 = false;

                                                                    } else {
                                                                        $(".address_valid").addClass('hide');
                                                                        cond9 = true;

                                                                    }


                                                                    if (city_search == '') {



                                                                        $(".serch_valid").removeClass('hide');
                                                                        cond10 = false;
                                                                        $('.serch_valid').text('Please search  city')


                                                                    } else {

                                                                      let city_idd = $("#search_city_hidden").val();

                                                                      if(city_idd){
                                                                        $(".serch_valid").addClass('hide');

                                                                          cond10 = true;
                                                                      }else{
                                                                        $(".serch_valid").removeClass('hide');
                                                                       cond10 = false;
                                                                       $('.serch_valid').text('Please search valid city')

                                                                      }





                                                                        // $(".serch_valid ").addClass('hide');
                                                                        // cond10 = true;

                                                                    }


                                                                    if ($('#city_type').val() == '') {
                                                                        $(".city_valid ").removeClass('hide');
                                                                        cond11 = false;

                                                                    } else {
                                                                        $(".city_valid").addClass('hide');
                                                                        cond11 = true;

                                                                    }

                                                                    if ($('#terms_condition_check').prop('checked') == false) {
                                                                        $(".tcheck").removeClass('hide');
                                                                        cond12 = false;
                                                                    } else {
                                                                        $(".tcheck").addClass('hide');
                                                                        cond12 = true;

                                                                    }







                                                                    if (cond1 == true && cond2 == true && cond3 == true && cond4 == true && cond5 == true && cond6 == true && cond7 == true && cond8 == true && cond9 == true && cond10 == true && cond11 == true && cond12 == true) {

                                                                        var form = $(".trainer_form")
                                                                        var lower_email = $('#trainer_email').val().toLowerCase();
                                                                        var email = lower_email;

                                                                        $.ajax({
                                                                            url: "/sentOtp",
                                                                            type: 'post',
                                                                            dataType: "json",
                                                                            data: {
                                                                                _token: CSRF_TOKEN,
                                                                                email: $('#trainer_email').val().toLowerCase(),
                                                                                name: $('#trainer_name').val()
                                                                            },
                                                                            success: function (data) {
																				$('#alertBox').modal('show');
                                                                                if (data.status == "NP001") {
                                                                                    $('.nav-tabs a[href="#nav-otp"]').tab('show');
                                                                                    $('#nav-trainer').removeClass('show');
                                                                                    $('#nav-home-trainer,#nav-profile-center').hide();
                                                                                    $('.resend').removeClass('invisible');


                                                                                    let trainer_name = $('#trainer_name').val();
                                                                                    let email = $('#trainer_email').val();
                                                                                    let mobile = $('#trainer_mobile').val();
                                                                                    let location = $('#trainer_location').val();
                                                                                    let address = $('#trainer_address').val();
                                                                                    let city = $('#trainer_city_search').val();

                                                                                    if ($('#form_type').val() == 1) {
                                                                                        let certticate_no = $('#trainer_certificate_no').val();
                                                                                        let trainer_as = $("input[name='trainer']:checked").val();
                                                                                        var html_tariner = '<div class="form-row"><div class="col-md-4 mb-3"><label class="text-muted">Trainer Name</label><p>' + trainer_name + '</p></div><div class="col-md-4 mb-3"><label class="text-muted" >Email id</label><p>' + email + '</p></div><div class="col-md-4 mb-3"><label class="text-muted">Mobile Number</label><p>' + mobile + '</p></div></div><div class="form-row"><div class="col-md-4 mb-3"><label class="text-muted">Certificate Number</label><p>' + certticate_no + '</p></div><div class="col-md-4 mb-3"><label class="text-muted">Get Location</label><p>' + location + '</p></div><div class="col-md-4 mb-3"><label class="text-muted">Trainer as</label><p>' + trainer_as + '</p></div></div><div class="form-row"><div class="col-md-4 mb-3"><label class="text-muted">Address</label><p>' + address + '</p></div><div class="col-md-4 mb-3"><label class="text-muted">City</label><p >' + city + '</p></div></div>';
                                                                                        $('.information_html_div').html(html_tariner)
                                                                                        $('.register_header').text('Enter OTP to register as trainer');
                                                                                    } else {
                                                                                        let sitting_capacity = $('#sitting_capacity').val();
                                                                                        var html_center = '<div class="form-row"><div class="col-md-4 mb-3"><label class="text-muted">Center Name</label><p>' + trainer_name + '</p></div><div class="col-md-4 mb-3"><label class="text-muted" >Email id</label><p>' + email + '</p></div><div class="col-md-4 mb-3"><label class="text-muted">Mobile Number</label><p>' + mobile + '</p></div></div><div class="form-row"><div class="col-md-4 mb-3"><label class="text-muted">Seating Capacity</label><p>' + sitting_capacity + '</p></div><div class="col-md-4 mb-3"><label class="text-muted">Get Location</label><p>' + location + '</p></div></div><div class="form-row"><div class="col-md-4 mb-3"><label class="text-muted">Address</label><p>' + address + '</p></div><div class="col-md-4 mb-3"><label class="text-muted">City</label><p >' + city + '</p></div></div>';
                                                                                        $('.information_html_div').html(html_center);
                                                                                        $('.register_header').text('Enter OTP to register as center');

                                                                                    }
                                                                                    var lat1 = $('#txtLat').val();
                                                                                    var lon1 = $('#txtLng').val();
                                                                                    var lat2 = $('#latitude_hidden').val();
                                                                                    var lon2 = $('#longitude_hidden').val();
                                                                                    var finnal_distabce = calcCrow(lat1 * 1, lon1 * 1, lat2 * 1, lon2 * 1).toFixed(1)
                                                                                    $('#distance').val(finnal_distabce);
                                                                                    $('.modal_body_text').html(data.message);
                                                                                } else {
                                                                                    $('.modal_body_text').html(data.message);
                                                                                }

                                                                            }
                                                                        });




                                                                    }


                                                                });




                                                                $(".register_btn").click(function () {
                                                                    //Fetch form to apply custom Bootstrap validation
                                                                    var tainerform = $(".main_form")[0]
                                                                    var formData = new FormData(tainerform);
                                                                    //var password = sha256($('#trainer_password').val());
                                                                    var password = $('#trainer_password').val();
                                                                    var lower_email = $('#trainer_email').val().toLowerCase();

                                                                    //var email = encrypt(lower_email);
                                                                    //var mobile = encrypt($('#trainer_mobile').val())

                                                                    var email = lower_email;
                                                                    var mobile = $('#trainer_mobile').val();

                                                                    var otp = $('#otp').val();
                                                                    formData.append('trainer_password', password);
                                                                    formData.append('trainer_email', email);
                                                                    formData.append('trainer_mobile', mobile);
                                                                    formData.append('otp', otp);
                                                                    formData.append('_token', CSRF_TOKEN);
                                                                    if (otp == '') {
                                                                        $(".otp_class__validation").removeClass('hide');
                                                                        cond12 = false;
                                                                    } else {
                                                                        $(".otp_class__validation").addClass('hide');
                                                                        $.ajax({
                                                                            url: '/registration',
                                                                            data: formData,
                                                                            processData: false,
                                                                            contentType: false,
                                                                            type: 'POST',
                                                                            success: function (data) {
																				$('#alertBox').modal('show');
                                                                                if (data.success == true) {
                                                                                    $('.modal_body_text').html(data.message);
                                                                                    window.setTimeout(function(){
                                                                                    	location.href = '/';
                                                                                    }, 4500);
                                                                                } else {
                                                                                    $('.modal_body_text').html(data.message);

                                                                                }

                                                                            }
                                                                        });
                                                                    }







                                                                });








                                                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                                                $("#trainer_city_search").autocomplete({
                                                                    source: function (request, response) {
                                                                        $.ajax({
                                                                            url: "/city",
                                                                            type: 'post',
                                                                            dataType: "json",
                                                                            data: {
                                                                                _token: CSRF_TOKEN,
                                                                                search: request.term
                                                                            },
                                                                            success: function (data) {
                                                                                response(data);
                                                                            }
                                                                        });
                                                                    },
                                                                    select: function (event, ui) {


                                                                        // Set selection
                                                                        $('#state_id').val(ui.item.state_id);
                                                                        $('#trainer_city_search').val(ui.item.label); // display the selected text
                                                                        $('#search_city_hidden').val(ui.item.value); // save selected id to input
                                                                        $('#latitude_hidden').val(ui.item.latitude);
                                                                        $('#longitude_hidden').val(ui.item.longitude);





                                                                        return false;
                                                                    }
                                                                });



                                                            })


// alert(calcCrow(59.3293371,13.4877472,59.3225525,13.4619422).toFixed(1));



                                                            //This function takes in latitude and longitude of two location and returns the distance between them as the crow flies (in km)
                                                            function calcCrow(lat1, lon1, lat2, lon2)
                                                            {
                                                                var R = 6371; // km
                                                                var dLat = toRad(lat2 - lat1);
                                                                var dLon = toRad(lon2 - lon1);
                                                                var lat1 = toRad(lat1);
                                                                var lat2 = toRad(lat2);

                                                                var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                                                                        Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);
                                                                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                                                                var d = R * c;
                                                                return d;
                                                            }

                                                            // Converts numeric degrees to radians
                                                            function toRad(Value)
                                                            {
                                                                return Value * Math.PI / 180;
                                                            }












                                                            function ValidateAlpha(evt)
                                                                {
                                                                    var keyCode = (evt.which) ? evt.which : evt.keyCode
                                                                    if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)

                                                                    return false;
                                                                        return true;
                                                                }




                                                            function validateEmail(email) {
                                                                var regex = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                                                                return regex.test(email);
                                                            }






                                                            function CheckPassword(inputtxt)
                                                            {
                                                                var decimal = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
                                                                if (inputtxt.match(decimal))
                                                                {
                                                                    return true;
                                                                } else
                                                                {
                                                                    return false;
                                                                }
                                                            }

                                                            function check_certificate(number) {
                                                                var new_value = /^(?=.*\d)(?=.*[a-zA-Z0-9]).{3,15}$/;
                                                                if (number) {

                                                                    if (number.match(new_value))
                                                                    {

                                                                        return true;
                                                                    } else
                                                                    {
                                                                        return false;
                                                                    }

                                                                }

                                                            }







                                                            // if ("geolocation" in navigator){ //check geolocation available
                                                            //      //try to get user current location using getCurrentPosition() method
                                                            //      navigator.geolocation.getCurrentPosition(function(position){
                                                            //        $('#current_lat').val(position.coords.latitude);
                                                            //        $('#current_lon').val(position.coords.longitude);
                                                            //        });
                                                            //    }else{
                                                            //      console.log("Browser doesn't support geolocation!");
                                                            //    }

                                                            function initialize() {



                                                                let ln =  $('#current_lat').val();
                                                                  let lon =   $('#current_lon').val();
                                                                // Creating map object
                                                                var map = new google.maps.Map(document.getElementById('map_canvas'), {
                                                                    zoom: 6,
                                                                    center: new google.maps.LatLng(ln * 1, lon * 1),
                                                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                                                });
                                                                // creates a draggable marker to the given coords
                                                                var vMarker = new google.maps.Marker({
                                                                    position: new google.maps.LatLng(ln * 1, lon * 1),
                                                                    draggable: true
                                                                });
                                                                // adds a listener to the marker
                                                                // gets the coords when drag event ends
                                                                // then updates the input with the new coords
                                                                google.maps.event.addListener(vMarker, 'dragend', function (evt) {


                                                                    $('#trainer_location').val(evt.latLng.lat().toFixed(6) + ',' + evt.latLng.lng().toFixed(6))
                                                                    $('#txtLat').val(evt.latLng.lat().toFixed(6));
                                                                    $('#txtLng').val(evt.latLng.lng().toFixed(6));



                                                                    map.panTo(evt.latLng);
                                                                });
                                                                // centers the map on markers coords
                                                                map.setCenter(vMarker.position);
                                                                // adds the marker on the map
                                                                vMarker.setMap(map);
                                                            }
// google location
                                                            var IV = '{{config("app.admin_enc_iv")}}';
                                                            function encrypt(str) {
                                                                var KEY = $('meta[name="csrf-token"]').attr('content');
                                                                KEY = KEY.substring(0, 16);
                                                                key = CryptoJS.enc.Utf8.parse(KEY);// Secret key
                                                                var iv = CryptoJS.enc.Utf8.parse(IV);//Vector iv
                                                                var encrypted = CryptoJS.AES.encrypt(str, key, {iv: iv, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.Pkcs7});
                                                                return encrypted.toString();
                                                            }




</script>