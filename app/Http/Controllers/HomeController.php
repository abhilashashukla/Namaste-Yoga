<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

use App\Event;
use App\User;

use App\Models\Aasana;
use App\Models\AasanaCategory;
use App\Models\AasanaSubCategory;
use App\Models\CelebrityTestimonial;
use App\Models\AayushCategory;
use App\Models\AayushProducts;

use App\Poll;
use App\Quiz;

use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\ModeratorType');
       // $this->middleware('App\Http\Middleware\checkRole');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
       
		if(Auth::user()->moderator_id==1)
        {
            $total_aasana_category=AasanaCategory::where('status','1')->count();
            $total_aasana_sub_category=AasanaSubCategory::where('status','1')->count();
            $total_aasana=Aasana::where('status','1')->count();
			$total_celebrity=CelebrityTestimonial::where('status','1')->count();
			
			
            return view('aasana_home', compact('total_aasana_category','total_aasana_sub_category','total_aasana','total_celebrity')); 
            
        } elseif(Auth::user()->moderator_id == 3) {
            
            $total_aayush_merchandise = AayushCategory::where('status', '1')->count();
            $total_aayush_products = AayushProducts::where('status', '1')->count();
            
            return view('aayushmerchandise.home', compact('total_aayush_merchandise', 'total_aayush_products' )); 
            
        }
		elseif(Auth::user()->moderator_id==5)
        {
            $total_quizes = Quiz::count();
            $total_activated_quizes = Quiz::where('status',1)->count();
			$total_responded_quizes = DB::table('quiz_responses')->count(DB::raw('DISTINCT user_id'));
            return view('quiz.home', compact('total_quizes','total_activated_quizes','total_responded_quizes')); 
        }
		elseif(Auth::user()->moderator_id==6)
        {
            $total_polls = Poll::count();
            $total_activated_polls = Poll::where('status',1)->count();
			$total_responded_poll = DB::table('audience_poll_responses')->count(DB::raw('DISTINCT user_id'));
            return view('polls.home', compact('total_polls','total_activated_polls','total_responded_poll')); 
        }
		elseif(Auth::user()->moderator_id==7){
			$event = Event::all()->count(); 
			$approvedEvent = Event::where('status','1')->count(); 
			$trainer = User::where('role_id',3)->count(); 
			$approvedTrainer = User::where([['role_id',3],['status','1']])->count(); 
			
			return view('yoga_home', compact('trainer','event','approvedEvent','approvedTrainer')); 
		}
		else
		{
			 $event = Event::all()->count(); 
			$trainer = User::where('role_id',3)->count(); 
			$center = User::where('role_id',2)->count(); 
			return view('home', compact('trainer','event','center')); 
        //return view(['home']);
			
		}
	}
}
