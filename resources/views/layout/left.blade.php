<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
   <ul class="nav side-menu">
      <li><a href="{{ url('/') }}/home"><i class="fa fa-home"></i> Dashboard</a></li>
    @if(Auth::user()->role_id==1)

      <li><a><i class="fa fa-calendar" aria-hidden="true"></i> View Events <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ url('/') }}/events">View Events</a></li>
        </ul>
      </li>
	
      <li><a><i class="fa fa-users"></i> View Trainers<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ url('/') }}/users">View Trainers</a></li>
        </ul>
      </li>

      <li><a><i class="fa fa-users"></i> View Centers<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ url('/') }}/users/center">View Centers</a></li>
        </ul>
      </li>

      <li><a><i class="fa fa-users"></i> Manage Moderators<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
		
          <li><a href="{{ url('/') }}/users/add">Add Moderator</a></li>
          <li><a href="{{ url('/') }}/users/moderator_list">Moderator list</a></li>
        </ul>
      </li>
		
        <li><a><i class="fa fa-bullhorn"></i>General Notifications<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{ url('/') }}/generalnotifications">Notifications List</a></li>
                <li><a href="{{ url('/') }}/sendgeneralnotification">Send Notification</a></li>
            </ul>
        </li>
        <li><a><i class="fa fa-share-square"></i>Social Media<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{ url('/') }}/socialmedia/listssocialmedia">View Social Media</a></li>
                <li><a href="{{ url('/') }}/socialmedia/addsocialmedia">Add New Social Media</a></li>
            </ul>
        </li>
		<li><a><i class="fa fa-comments-o"></i>View Feedback<span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="{{ url('/') }}/feedback/listsfeedback">View Feedback</a></li>
			</ul>
		</li>

        <li><a><i class="fa fa-history"></i> Audit Trail <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{ url('/') }}/audittrails">Activity List</a></li>
            </ul>
        </li>
		
    @endIf
	
	
  @if(Auth::user()->role_id==4)
      @php
            $assignedModerators = Session::get('moderatorTypes');
			
      @endphp
		
      @if(Auth::user()->moderator_id==1)
      <li><a><i class="fa fa-users"></i>Aasanas<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a>Category<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
          <li><a href="{{ url('/') }}/aasana/listcategory">View Category</a></li>
          <li><a href="{{url('/')}}/aasana/addcategory">Add New Category</a></li>
        </ul>
        </li>
		  <li><a>Sub Category<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{ url('/') }}/aasana/listsubcategory">View Sub Category</a></li>
            <li><a href="{{url('/')}}/aasana/addsubcategory">Add New Sub Category</a></li>
          </ul>
        </li>
         <li><a>Aasana<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{ url('/') }}/aasana/listsaasana">View Aasana</a></li>
            <li><a href="{{url('/')}}/aasana/addaasana">Add New Aasana</a></li>
          </ul>
        </li>
		
        <li><a>Import<span class="fa fa-chevron-down"></span></a>
         <ul class="nav child_menu">
           <li><a href="{{ url('/') }}/import-category-subcategory-aasana">Import Category Sub Category and Aasana</a></li>
           <li><a href="{{ url('/') }}/import-category-subcategory-aasana-images">Import Category and Sub Category Images</a></li>
         </ul>
       </li>
        </ul>
		<li><a><i class="fa fa-star"></i>Celebrity Testimonial<span class="fa fa-chevron-down"></span></a>
		  <ul class="nav child_menu">
           <li><a href="{{ url('/') }}/celebrity/listscelebrity">View Celebrity</a></li>
           <li><a href="{{ url('/') }}/celebrity/addcelebrity">Add New Celebrity</a></li>
         </ul>
       </li>		
      </li>
		
        @elseif(Auth::user()->moderator_id == 3)
            <li>
                <a><i class="fa fa-users"></i>Aayush Merchandise<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li>
                        <a>Merchandise Category<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('listaayushcategories') }}">View Category</a></li>
                            <li><a href="{{url('addaayushcategory')}}">Add Category</a></li>
                        </ul>
                    </li>
                    <li>
                        <a>Merchandise Products<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('aayushproductlist') }}">View Products</a></li>
                            <li><a href="{{url('addaayushproduct')}}">Add Product</a></li>
                        </ul>
                    </li>
                    <li>
                        <a>Import<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('import-category-product') }}">Import Category and Products</a></li>
                            <li><a href="{{ url('images-category-product') }}">Upload Category and Products Images</a></li>
                        </ul>
                    </li>
                    <!-- <li>
                        <a>Import Category and Products<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('import-category-product') }}">Import</a></li>
                        </ul>
                    </li> -->
                </ul>
            </li>
		
        @elseif(Auth::user()->moderator_id==5)
		
        <li {{ request()->is('quiz*') ? 'active' : '' }}><a><i class="fa fa-users"></i> Manage Quiz<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="{{ request()->is('quiz*')? 'display: block;' : '' }}">
              <li><a href="{{ url('/') }}/quiz">Quizes</a></li>
              <li><a href="{{ url('/') }}/quiz/create">Add</a></li>
              <li><a href="{{ url('/') }}/import-quiz">Import Quiz</a></li>
            </ul>
        </li>

	@elseif(Auth::user()->moderator_id==6)
		<li class="{{ request()->is('polls*') ? 'active' : '' }}"><a><i class="fa fa-users"></i> Manage Polls<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu" style="{{ request()->is('polls*')? 'display: block;' : '' }}">
          <li ><a href="{{ url('/') }}/polls">Polls</a></li>
          <li ><a href="{{ url('/') }}/polls/create">Add Poll</a></li>
          <li ><a href="{{ url('import-poll') }}">Import Polls</a></li>
        </ul>
      </li>
		
	  @else
		
	   <li class="{{ request()->is('users*') ? 'active' : '' }}"><a><i class="fa fa-users"></i> Manage Trainers<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu" style="{{ request()->is('users*')? 'display: block;' : '' }}">
          <li><a href="{{ url('/') }}/users/pendings">Pending Approval</a></li>
          <li><a href="{{ url('/') }}/users">Approved Trainers</a></li>
          <li><a href="{{ url('/') }}/users/rejected">Rejected Trainers</a></li>
        </ul>
      </li>
      
        
        <li class="{{ request()->is('centers*') ? 'active' : '' }}"><a><i class="fa fa-users"></i>Manage Centers<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="{{ request()->is('centers*')? 'display: block;' : '' }}">
                <li><a href="{{ url('centers/pendingcenters') }}">Pending Centers</a></li>
                <li><a href="{{ url('centers/approvedcenters') }}">Approved Centers</a></li>
                <li><a href="{{ url('centers/rejectedcenters') }}">Rejected Centers</a></li>
            </ul>
        </li>
        
      
	  <li class="{{ request()->is('events*') ? 'active' : '' }}"><a><i class="fa fa-calendar"></i> Manage Events<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu" style="{{ request()->is('events*')? 'display: block;' : '' }}">
		<li><a href="{{ url('/') }}/events/pending">Pending Events</a></li>
          <li ><a href="{{ url('/') }}/events">Approved Events</a></li>	
		  <li><a href="{{ url('/') }}/events/rejectedevents">Rejected Events</a></li>		  
          <li ><a href="{{ url('/') }}/events/create">Add Events</a></li>
		  </ul>
      </li>
  @endif

  <!--
  @if(in_array(2,$assignedModerators))
      <li><a><i class="fa fa-users"></i> Manage Trainers<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ url('/') }}/users/pendings">Pending Approval</a></li>
          <li><a href="{{ url('/') }}/users">Approved Trainers</a></li>
          <li><a href="{{ url('/') }}/users/rejected">Rejected Trainers</a></li>
        </ul>
      </li>
  @endif
  @if(in_array(3,$assignedModerators))
      <li><a><i class="fa fa-users"></i> Manage Merchandise<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ url('/') }}/users/pendings">Pending Approval</a></li>
          <li><a href="{{ url('/') }}/users">Approved Trainers</a></li>
          <li><a href="{{ url('/') }}/users/rejected">Rejected Trainers</a></li>
        </ul>
      </li>
  @endif
  @if(in_array(4,$assignedModerators))
      <li><a><i class="fa fa-users"></i> Manage Video Content<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ url('/') }}/users/pendings">Pending Approval</a></li>
          <li><a href="{{ url('/') }}/users">Approved Trainers</a></li>
          <li><a href="{{ url('/') }}/users/rejected">Rejected Trainers</a></li>
        </ul>
      </li>
  @endif
  @if(in_array(5,$assignedModerators))
      <li><a><i class="fa fa-users"></i> Manage Quiz<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ url('/') }}/users/pendings">Pending Approval</a></li>
          <li><a href="{{ url('/') }}/users">Approved Trainers</a></li>
          <li><a href="{{ url('/') }}/users/rejected">Rejected Trainers</a></li>
        </ul>
      </li>
  @endif -->

    @endIf
 </ul>
  </div>

</div>
