<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Use App\Rest;

Route::post('GetSubCategoryList', 'AasanController@getSubCategoryList');
Route::post('GetAasanaList', 'AasanController@getAasanaList');
Route::post('GetAllSocialLinks','SocialMedia@getAllSocialLinks');


/* Added by Tapeshwar */
Route::post('register', 'UserController@register');
/*Route::post('userList', 'UserController@getUserList');//disabled */
Route::post('deviceTokenUpdate', 'UserController@deviceTokenUpdate');

Route::post('aayushcategorylist', 'Aayushmerchandise@getAllCategories');
Route::post('productbycategory', 'Aayushmerchandise@getProductByCategory');
Route::post('productdetails', 'Aayushmerchandise@getProductDetails');
Route::get('getPoll', 'PollController@getPoll');
Route::get('getQuiz', 'QuizController@getQuiz');
Route::post('getTestimonials','CelebrityTestimonial@getTestimonials');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    
    Route::post('apilogout', 'UserController@apilogout');/* Added by Tapeshwar */
    
    Route::post('addEvent', 'EventController@addEvent');
    Route::post('changePassword', 'UserController@changePassword');
    Route::post('getMyEventList', 'EventController@getMyEventList');
    Route::post('editMyEvent', 'EventController@editMyEvent');
    Route::post('editMyProfile', 'UserController@editMyProfile');
    Route::post('suspendAccount', 'UserController@suspendAccount');
    Route::post('GetFeedbackQuestionList','FeedbackController@getFeedbackQuestionList');

	
	
	
	Route::post('validatePoll', 'PollController@validatePoll');
	
	
	Route::post('validateQuiz', 'QuizController@validateQuiz');
	
	Route::group(['middleware' => ['XSS']], function () {
	Route::post('SubmitFeedback','FeedbackController@submitFeedback');
	Route::post('submitPoll', 'PollController@submitPoll');
	Route::post('submitQuiz', 'QuizController@submitQuiz');
	});
});



?>