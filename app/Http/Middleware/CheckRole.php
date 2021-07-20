<?php

namespace App\Http\Middleware;

use Illuminate\Http\Response;
use Closure;
use Auth;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $moderator_id = Auth::user()->moderator_id;
        $role = strtolower(Auth::user()->role->role);
		//echo $moderator_id;die;
        $user_id = Auth::user()->id;

      $modules = array(
            0 => [
				'events','events/eventIndexAjax','events/edit/{id}','/events/update/{id}','events/changestatustoggle','users','userIndexAjax','users/changestatus','users/center','userCenterIndexAjax','users/moderator_list','users/moderatorIndexAjax','users/resetModeratorPassword','users/changemodratorstatus','users/add','audittrails','auditIndexAjax','generalnotifications','notificationIndexAjax','sendgeneralnotification','socialmedia/listssocialmedia','socialmedia/socialmediaIndexAjax','socialmedia/addsocialmedia','socialmedia/savesocialmedia','socialmedia/viewsocialmedia/{id}','socialmedia/editsocialmedia/{id}','socialmedia/deletesocialmedia/{id}','socialmedia/updatesocialmedia/{id}','socialmedia/changestatussocialmedia','feedback/listsfeedback','feedback/feedbackIndexAjax','feedback/viewfeedback/{id}'
		  ],
		  1 => [
			'aasana/listcategory','aasana/categoryIndexAjax','aasana/changestatus','aasana/addcategory','aasana/savecategoy','aasana/deletecategory/{id}','aasana/viewcategory/{id}','aasana/editcategory/{id}','aasana/updatecategory/{id}',
			'aasana/addsubcategory','aasana/savesubcategoy','aasana/listsubcategory','aasana/subcategoryIndexAjax','aasana/changestatussubcategory','aasana/deletesubcategory/{id}','aasana/viewsubcategory/{id}','aasana/editsubcategory/{id}','aasana/updatesubcategory/{id}',
			'aasana/addaasana','aasana/getsubcategorybycategory','aasana/saveaasana','aasana/listsaasana','aasana/aasanaIndexAjax','aasana/changestatusaasana','aasana/deleteaasana/{id}','aasana/viewaasana/{id}','aasana/editaasana/{id}','aasana/geteditsubcategorybycategory','aasana/updateaasana/{id}','importAsana','import-category-subcategory-aasana','importAsanimages','import-category-subcategory-aasana-images',
			'celebrity/addcelebrity','celebrity/savecelebrity','celebrity/listscelebrity','celebrity/celebrityIndexAjax','celebrity/changestatuscelebrity','celebrity/viewcelebrity/{id}','celebrity/editcelebrity/{id}','celebrity/updatecelebrity/{id}'
		  ],
		  3 => [
		  'listaayushcategories','categoriesIndexAjax','addaayushcategory','editaayushcategory/{cid}','updateaayushcategorystatus','aayushproductlist','productsIndexAjax','addaayushproduct','editaayushproduct/{pid}','updateaayushproductstatus','aayushproduct/{pid}','importaayushproducts','import-category-product','importCategoryProduct','images-category-product','imagesUpload'
		  ],
		5 => [
			'quiz','quiz/quizIndexAjax','quiz/create','quiz/add/{quiz_id}','quiz/storeQuestions','quiz/edit/{id}','quiz/view/{id}','quiz/update/{id}','quiz/changestatus','quiz/destroy','quiz/viewresult/{id}','quiz/viewQuizDetailsByUser','quiz/getResultbyQuiz','import-quiz','importQuiz'
		],
		6 => [
			'polls','polls/pollsIndexAjax','polls/create','polls/edit/{id}','polls/view/{id}','polls/update/{id}','polls/changestatus','polls/destroy','polls/viewresult/{id}','import-poll','importPoll'
		],		
        7 => [
			'users',
			'userIndexAjax',
			'users/pendings',
			'users/changeycbstatus',
			'userPendingIndexAjax',
			'users/rejected',
			'userRejectedIndexAjax',
			'centers/pendingcenters',
			'pendingCentersAjax',
			'users/changesCenterStatus',
			'centers/approvedcenters',
			'approvedCentersAjax',
			'centers/rejectedcenters',
			'rejectedCentersAjax',
			'events',
			'events/eventIndexAjax',
			'events/edit/{id}',
			'events/pending',
			'events/pendingEventIndexAjax',
			'events/changestatusevents',
			'events/rejectedevents',
			'events/rejectedEventsAjax',
			'events/changestatustoggle',
			'events/create',
			'events/add'
			
		]
            );
        $page = $request->route()->uri;
		//echo $page;
		//dd($modules[$moderator_id]);
		if(!in_array($page,$modules[$moderator_id])){
            return new Response(view('unauthorized')->with('role', 'Admin'));
        } 
        /* if(!array_key_exists($page,$modules[$moderator_id])){
            return new Response(view('unauthorized')->with('role', 'Admin'));
        } */
        return $next($request);
    }

}
?>