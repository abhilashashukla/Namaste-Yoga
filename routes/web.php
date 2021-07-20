<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['XSS']], function () {
Route::group(['middleware' => 'prevent-back-history'],function(){
Route::get('/logout', function () {
    Auth::logout();
    return view('login');
});

//Route::any('importExcel', 'Importexcel@index');//--------------------------------------------------------------

Route::get('/activate_account', 'UserController@activate_account');

Route::get('/users/sendmail', 'UserController@pushNotification');
Route::get('/deletetest', 'UserController@deletetest');
Route::any('/notifyUsersPollAboutToEnd', 'PollsController@PollsAboutToExpire');
Route::any('/notifyUsersQuizAboutToEnd', 'QuizController@QuizesAboutToExpire');
Route::any('/notifyEventUsersAboutToStartEvent', 'EventController@EventAboutToStart');
Route::group(['middleware' => 'App\Http\Middleware\AuthMiddleware'], function () {

    
    Route::get('/users', 'UserController@index')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/userIndexAjax', 'UserController@userIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);


    Route::get('/users/center', 'UserController@center')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/userCenterIndexAjax', 'UserController@userCenterIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);

    Route::get('/users/pendings', 'UserController@pendings')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/users/rejected', 'UserController@rejected')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/userPendingIndexAjax', 'UserController@userPendingIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/userRejectedIndexAjax', 'UserController@userRejectedIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
	
	/* users (centers) routing */
    Route::get('centers/pendingcenters', 'UserController@pendingCenters')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('pendingCentersAjax', 'UserController@pendingCentersAjax')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('users/changesCenterStatus', 'UserController@changesCenterStatus')->middleware(['App\Http\Middleware\CheckRole']);
	
    Route::get('centers/approvedcenters', 'UserController@approvedCenters')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('approvedCentersAjax', 'UserController@approvedCentersAjax')->middleware(['App\Http\Middleware\CheckRole']);
	
    Route::get('centers/rejectedcenters', 'UserController@rejectedCenters')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('rejectedCentersAjax', 'UserController@rejectedCentersAjax')->middleware(['App\Http\Middleware\CheckRole']);



    Route::get('/home', 'HomeController@index')->name('home');
    /* users routing */
    //Route::get('/users', 'UserController@index');
    Route::get('/users/edit/{id}', 'UserController@edit')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/users/add', 'UserController@add')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/users/add', 'UserController@add')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/users/moderator_list', 'UserController@moderator_list')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/users/moderatorIndexAjax', 'UserController@moderatorIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);

    Route::get('/users/changepass', 'UserController@changepass');
    Route::post('/users/changepass', 'UserController@changepass');
    Route::post('/users/update/{id}', 'UserController@update');
    Route::post('/users/create', 'UserController@create');
    Route::get('/users/destroy/{id}', 'UserController@destroy');
    Route::post('/users/changestatus', 'UserController@changestatus')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/users/changemodratorstatus', 'UserController@changemodratorstatus')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/users/changeycbstatus', 'UserController@changeycbstatus')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/users/resetModeratorPassword', 'UserController@resetModeratorPassword')->middleware(['App\Http\Middleware\CheckRole']);


    Route::get('/events', 'EventController@index')->middleware(['App\Http\Middleware\CheckRole']);
	Route::get('/events/pending', 'EventController@pendingEvents')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/events/eventIndexAjax', 'EventController@eventIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/events/pendingEventIndexAjax', 'EventController@pendingEventIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);

    Route::get('/audittrails', 'AuditController@index')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/auditIndexAjax', 'AuditController@auditIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/events/changestatusevents', 'EventController@changestatusEvents')->middleware(['App\Http\Middleware\CheckRole']);
	Route::get('events/create', 'EventController@create')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('events/add', 'EventController@add')->middleware(['App\Http\Middleware\CheckRole']);
	Route::get('/events/view/{id}', 'EventController@View');
	Route::get('events/edit/{id}', 'EventController@Edit')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('/events/update/{id}', 'EventController@Update')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('events/cities','EventController@GetCities');
	Route::post('events/deleteimages','EventController@DeleteImages');
	Route::get('events/rejectedevents', 'EventController@rejectedEvents')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('events/rejectedEventsAjax', 'EventController@rejectedEventsAjax')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('/events/changestatustoggle', 'EventController@changestatusEventsToggle')->middleware(['App\Http\Middleware\CheckRole']);
	
	

	Route::get('/polls', 'PollsController@index')->middleware(['App\Http\Middleware\CheckRole']);
	
	
	
	//Polls Module
	Route::resource('/polls', 'PollsController');
	Route::get('/polls', 'PollsController@index')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/polls/pollsIndexAjax', 'PollsController@pollsIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
	Route::get('/polls/create', 'PollsController@create')->middleware(['App\Http\Middleware\CheckRole']);
	Route::get('/polls/edit/{id}', 'PollsController@show')->middleware(['App\Http\Middleware\CheckRole']);
	Route::get('/polls/view/{id}', 'PollsController@view')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('/polls/update/{id}', 'PollsController@update')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/polls/changestatus', 'PollsController@changestatus')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/polls/destroy', 'PollsController@destroy')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/polls/viewresult/{id}', 'PollsController@viewResult')->middleware(['App\Http\Middleware\CheckRole']);
    
    //import polls
    Route::any('/import-poll', 'Import@importpollView')->middleware(['App\Http\Middleware\CheckRole']);
    Route::any('/importPoll', 'Import@importPoll')->middleware(['App\Http\Middleware\CheckRole']);
	
	//Quiz Module
	Route::resource('/quiz', 'QuizController');
	Route::get('/quiz', 'QuizController@index')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('/quiz/quizIndexAjax', 'QuizController@quizIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
	Route::get('/quiz/create', 'QuizController@create')->middleware(['App\Http\Middleware\CheckRole']);
	Route::get('/quiz/add/{quiz_id}', 'QuizController@AddQuestions')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('/quiz/storeQuestions', 'QuizController@storeQuestions')->middleware(['App\Http\Middleware\CheckRole']);
	Route::get('/quiz/edit/{id}', 'QuizController@show')->middleware(['App\Http\Middleware\CheckRole']);
	Route::get('/quiz/view/{id}', 'QuizController@view')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('/quiz/update/{id}', 'QuizController@update')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/quiz/changestatus', 'QuizController@changestatus')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/quiz/destroy', 'QuizController@destroy')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/quiz/viewresult/{id}', 'QuizController@viewResult')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('/quiz/viewQuizDetailsByUser', 'QuizController@viewQuizDetailsByUser')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('/quiz/getResultbyQuiz', 'QuizController@getResultbyQuiz')->middleware(['App\Http\Middleware\CheckRole']);

	//import quiz
	Route::any('/import-quiz', 'Import@importQuizView')->middleware(['App\Http\Middleware\CheckRole']);
	Route::any('/importQuiz', 'Import@importQuiz')->middleware(['App\Http\Middleware\CheckRole']);

	
	/* For general notifications */
	
    Route::get('/generalnotifications', 'Notifications@listGeneralNotifications')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('/notificationIndexAjax', 'Notifications@notificationIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
	
    Route::any('/sendgeneralnotification', 'Notifications@sendGeneralNotification')->middleware(['App\Http\Middleware\CheckRole']);

	/*---------------------------------------- Aasana Category Module-------------------------------------------------------- */
	Route::get('/aasana/addcategory','AasanaCategory@AddCategory')->middleware(['App\Http\Middleware\CheckRole']);
	Route::post('/aasana/savecategoy','AasanaCategory@SaveCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/aasana/listcategory','AasanaCategory@ListCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/aasana/categoryIndexAjax', 'AasanaCategory@CategoryIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/aasana/changestatus', 'AasanaCategory@ChangeCategoryStatus')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/aasana/deletecategory/{id}', 'AasanaCategory@DeleteCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/aasana/viewcategory/{id}', 'AasanaCategory@ViewCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/aasana/editcategory/{id}', 'AasanaCategory@EditCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/aasana/updatecategory/{id}', 'AasanaCategory@UpdateCategory')->middleware(['App\Http\Middleware\CheckRole']);

	 //----------------------------------Aasana Sub Category Routes List---------------------------------------------------------------//
    Route::get('/aasana/addsubcategory','AasanaSubCategoryController@AddSubCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/aasana/savesubcategoy','AasanaSubCategoryController@SaveSubCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/aasana/listsubcategory','AasanaSubCategoryController@ListSubCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/aasana/subcategoryIndexAjax', 'AasanaSubCategoryController@SubCategoryIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/aasana/changestatussubcategory', 'AasanaSubCategoryController@ChangeSubCategoryStatus')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/aasana/deletesubcategory/{id}', 'AasanaSubCategoryController@DeleteSubCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/aasana/viewsubcategory/{id}', 'AasanaSubCategoryController@ViewSubCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::get('/aasana/editsubcategory/{id}', 'AasanaSubCategoryController@EditSubCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/aasana/updatesubcategory/{id}', 'AasanaSubCategoryController@UpdateSubCategory')->middleware(['App\Http\Middleware\CheckRole']);


		// import asana,category,SubCategory
		// for save
		Route::any('/importAsana', 'Import@importAsana')->middleware(['App\Http\Middleware\CheckRole']);
		Route::any('/importAsanimages', 'Import@importAsanaImage')->middleware(['App\Http\Middleware\CheckRole']);
		// for view
		Route::any('/import-category-subcategory-aasana', 'Import@importAsanaView')->middleware(['App\Http\Middleware\CheckRole']);
		Route::any('/import-category-subcategory-aasana-images', 'Import@importAsanaImages')->middleware(['App\Http\Middleware\CheckRole']);
  //-----------------------Aasana  Routes List---------------------------------------------------------------//
    
     Route::get('/aasana/addaasana','Aasana@AddAasana')->middleware(['App\Http\Middleware\CheckRole']);
     Route::post('/aasana/getsubcategorybycategory','Aasana@getSubCategory')->middleware(['App\Http\Middleware\CheckRole']);
     Route::post('/aasana/saveaasana','Aasana@SaveAasana')->middleware(['App\Http\Middleware\CheckRole']);
     Route::get('/aasana/listsaasana','Aasana@ListAasana')->middleware(['App\Http\Middleware\CheckRole']);
     Route::post('/aasana/aasanaIndexAjax', 'Aasana@AasanaIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
     Route::post('/aasana/changestatusaasana', 'Aasana@ChangeAasanaStatus')->middleware(['App\Http\Middleware\CheckRole']);
     Route::get('/aasana/deleteaasana/{id}', 'Aasana@DeleteAasana')->middleware(['App\Http\Middleware\CheckRole']);
     Route::get('/aasana/viewaasana/{id}', 'Aasana@ViewAasana')->middleware(['App\Http\Middleware\CheckRole']);
     Route::get('/aasana/editaasana/{id}', 'Aasana@EditAasana')->middleware(['App\Http\Middleware\CheckRole']);
     Route::post('/aasana/geteditsubcategorybycategory','Aasana@getEditSubCategory')->middleware(['App\Http\Middleware\CheckRole']);
     Route::post('/aasana/updateaasana/{id}', 'Aasana@UpdateAasana')->middleware(['App\Http\Middleware\CheckRole']);
	 
	 //-----------------------------Social Media Routes List---------------------------------------------------------------//
    
      Route::get('/socialmedia/addsocialmedia','SocialMediaController@AddSocialMedia')->middleware(['App\Http\Middleware\CheckRole']);
      //Route::post('/aasana/getsubcategorybycategory','Aasana@getSubCategory');
      Route::post('/socialmedia/savesocialmedia','SocialMediaController@SaveSocialMedia')->middleware(['App\Http\Middleware\CheckRole']);
      Route::get('/socialmedia/listssocialmedia','SocialMediaController@ListSocialMedia')->middleware(['App\Http\Middleware\CheckRole']);
      Route::post('/socialmedia/socialmediaIndexAjax', 'SocialMediaController@SocialMediaIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
      Route::post('/socialmedia/changestatussocialmedia', 'SocialMediaController@ChangeSocialMediaStatus')->middleware(['App\Http\Middleware\CheckRole']);
      Route::get('/socialmedia/deletesocialmedia/{id}', 'SocialMediaController@DeleteSocialMedia')->middleware(['App\Http\Middleware\CheckRole']);
      Route::get('/socialmedia/viewsocialmedia/{id}', 'SocialMediaController@ViewSocialMedia')->middleware(['App\Http\Middleware\CheckRole']);
      Route::get('/socialmedia/editsocialmedia/{id}', 'SocialMediaController@EditSocialMedia')->middleware(['App\Http\Middleware\CheckRole']);
     // Route::post('/aasana/geteditsubcategorybycategory','Aasana@getEditSubCategory');
      Route::post('/socialmedia/updatesocialmedia/{id}', 'SocialMediaController@UpdateSocialMedia')->middleware(['App\Http\Middleware\CheckRole']);
	  
	//--------------------------------Feedback Routes List---------------------------------------------------------------//
    
    Route::get('/feedback/listsfeedback','Feedback@ListsFeedback')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('/feedback/feedbackIndexAjax', 'Feedback@FeedbackIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
	Route::get('/feedback/viewfeedback/{id}', 'Feedback@ViewFeedback')->middleware(['App\Http\Middleware\CheckRole']);
    
    /********* Aayush Merchandise module *********/
    Route::get('listaayushcategories','Aayushmerchandise@listCategories')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('categoriesIndexAjax','Aayushmerchandise@categoriesIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
    Route::any('addaayushcategory','Aayushmerchandise@addAayushCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::any('editaayushcategory/{cid}','Aayushmerchandise@editAayushCategory')->middleware(['App\Http\Middleware\CheckRole']);
    Route::any('updateaayushcategorystatus','Aayushmerchandise@updateAayushCategoryStatus')->middleware(['App\Http\Middleware\CheckRole']);
    
    Route::get('aayushproductlist','Aayushmerchandise@listProducts')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('productsIndexAjax','Aayushmerchandise@productsIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
    Route::any('addaayushproduct','Aayushmerchandise@addAayushProduct')->middleware(['App\Http\Middleware\CheckRole']);
    Route::any('editaayushproduct/{pid}','Aayushmerchandise@editAayushProduct')->middleware(['App\Http\Middleware\CheckRole']);
    Route::any('updateaayushproductstatus','Aayushmerchandise@updateAayushProductStatus')->middleware(['App\Http\Middleware\CheckRole']);
    
    Route::get('aayushproduct/{pid}','Aayushmerchandise@aayushProduct')->middleware(['App\Http\Middleware\CheckRole']);
    Route::post('importaayushproducts','Aayushmerchandise@importAayushProducts')->middleware(['App\Http\Middleware\CheckRole']);

    //import ayush merchandis product and category
    Route::any('/import-category-product', 'Import@AyushMerchandisUploadView')->middleware(['App\Http\Middleware\CheckRole']);
    Route::any('/importCategoryProduct', 'Import@AyushMerchandisUpload')->middleware(['App\Http\Middleware\CheckRole']);
    Route::any('/images-category-product', 'Import@ImagesCategoryProduct')->middleware(['App\Http\Middleware\CheckRole']);
    Route::any('/imagesUpload', 'Import@ImagesCategoryProductUplod')->middleware(['App\Http\Middleware\CheckRole']);
	
	
    //-----------------------------Celebrity Testimonial Routes List---------------------------------------------------------------//
    
      Route::get('/celebrity/addcelebrity','CelebrityTestimonialController@AddCelebrityTestimonial')->middleware(['App\Http\Middleware\CheckRole']);
      Route::post('/celebrity/savecelebrity','CelebrityTestimonialController@SaveCelebrityTestimonial')->middleware(['App\Http\Middleware\CheckRole']);
      Route::get('/celebrity/listscelebrity','CelebrityTestimonialController@ListCelebrityTestimonial')->middleware(['App\Http\Middleware\CheckRole']);
      Route::post('/celebrity/celebrityIndexAjax', 'CelebrityTestimonialController@CelebrityTestimonialIndexAjax')->middleware(['App\Http\Middleware\CheckRole']);
      Route::post('/celebrity/changestatuscelebrity', 'CelebrityTestimonialController@ChangeCelebrityTestimonialStatus')->middleware(['App\Http\Middleware\CheckRole']);
     // Route::get('/celebrity/deletesocialmedia/{id}', 'SocialMediaController@DeleteSocialMedia');
      Route::get('/celebrity/viewcelebrity/{id}', 'CelebrityTestimonialController@ViewCelebrityTestimonial')->middleware(['App\Http\Middleware\CheckRole']);
      Route::get('/celebrity/editcelebrity/{id}', 'CelebrityTestimonialController@EditCelebrityTestimonial')->middleware(['App\Http\Middleware\CheckRole']);
      Route::post('/celebrity/updatecelebrity/{id}', 'CelebrityTestimonialController@UpdateCelebrityTestimonial')->middleware(['App\Http\Middleware\CheckRole']);	 
	  Route::get('refresh_captcha', 'Notifications@refreshCaptcha')->name('refresh_captcha');
	  

});

/// register routes
Route::any('/city', 'Registration@city');
Route::any('/sentOtp', 'Registration@RegisterOtp');
Route::any('/registration', 'Registration@saveRegister');
Route::any('/registration-form', 'Registration@registerForm');

Route::any('/importSave', 'Import@import');
Route::any('/import-view', 'Import@importView');


Route::any('/forgotpassword', 'UserController@forgotpassword');
Route::any('/changepassword_second', 'UserController@changepassword_second');



Route::get('/', 'PagesController@index');

// Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function(){
//     Route::match(['get', 'post'], '/adminOnlyPage/', 'HomeController@admin');
// });

Auth::routes();

/* error routing */
Route::get('/error',function(){
   abort('custom');
});
});
});



