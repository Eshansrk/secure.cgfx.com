@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Verify Profile')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
@endsection
@section ('page-level-css')
<!--Plugin style-->

    <link type="text/css" rel="stylesheet" href="/vendors/modal/css/component.css"/>
    <link type="text/css" rel="stylesheet" href="/vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css"/>
    <link rel="stylesheet" type="text/css" href="/vendors/animate/css/animate.min.css" />
    <!-- end of plugin styles -->
    <link type="text/css" rel="stylesheet" href="/css/pages/portlet.css"/>
    <link type="text/css" rel="stylesheet" href="/css/pages/advanced_components.css"/>
    <link type="text/css" rel="stylesheet" href="#" id="skin_change"/>

    <!--Plugin styles-->
    <link type="text/css" rel="stylesheet" href="/vendors/bootstrap-switch/css/bootstrap-switch.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/switchery/css/switchery.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/radio_css/css/radiobox.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/checkbox_css/css/checkbox.min.css" />
    <!--End of Plugin styles-->
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="/css/pages/radio_checkbox.css" />
    <link type="text/css" rel="stylesheet" href="#" id="skin_change"/>

    <link type="text/css" rel="stylesheet" href="/css/pages/buttons.css"/>
    <link type="text/css" rel="stylesheet" href="#" id="skin_change"/>
    <link rel="stylesheet" type="text/css" href="/assets/backEnd/css/notification.css">


@endsection

@section('content')
<div id="notification">
    <div class="noti-cross"><i class="fa fa-times" id="cross" onclick="closeNoti()" aria-hidden="true"></i></div>
    @if(session()->has('msg'))
    <div id="noti-body">
        {{session()->get('msg')}}
        {{session()->forget('msg')}}
    </div>
    @endif
</div>

<div id="content" class="bg-container">
	<header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="nav_top_align skin_txt">
                        <i class="fa fa-user" style="margin-left: 2%"></i>
                        Personal Details
                    </h4>
                </div>
            </div>
        </div>
    </header>
    
    <div class="outer">
    	<div class="inner bg-container">
    		<div class="row">
                <div class="col-md-12" style="margin: 0;padding: 0">
                    <div class="form-group col-md-6">
                        <label for="" class="inputlg" style="font-size: 18px">Email</label>
                        <input id="profile_email" class="form-control input-lg" disabled=""
                         value="{{$profile->email}}" type="text" style="height: 50px">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="" style="font-size: 18px">Partner Password:</label><br>
                    @if($profile->password_preference == 'client')
                       <input  class="radio-class" id="yes" type="radio" name="password_preference" value="yes" ><span style="margin: 0 5% 0 2%">Use Partner Password</span>

                        <input class="radio-class" id="no" type="radio" name="password_preference" value="no" checked><span style="margin: 0 5% 0 2%">Use Client Password</span>
                    @else
                    <input  class="radio-class" id="yes" type="radio" name="password_preference" value="yes" checked><span style="margin: 0 5% 0 2%">Use Partner Password</span>

                    <input class="radio-class" id="no" type="radio" name="password_preference" value="no"><span style="margin: 0 5% 0 2%">Use Client Password</span>
                    @endif
                      <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                          <!-- <div class="panel-heading">
                            <h4 class="panel-title">
                                    Header
                                </h4>
                          </div> -->
                          <div id="collapseOne" class="panel-collapse collapse">
                            <div class="panel-body">
                              <input type="password" class="form-control partner-pass" name="partner_password" style="width: 50%" placeholder="Set Password" minlength="6"><span class="pass-field"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                                        
                    </div>
                    <div class="clearfix"></div>

                                <div class="form-group col-md-6">
                                    <label for="" style="font-size: 18px">First Name:</label>
                                    <input type="text" class="form-control input-lg" disabled="" value="{{$profile->fname}}"  style="height: 50px">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="" style="font-size: 18px">Last Name:</label>
                                    <input type="text" class="form-control input-lg" disabled="" value="{{$profile->lname}}" style="height: 50px">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="" style="font-size: 18px">Company Name:</label>
                                    <input type="text" class="form-control input-lg" disabled="" value="{{$profile->company_name}}" style="height: 50px">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="" style="font-size: 18px">Phone:</label>
                                    <input type="text" class="form-control input-lg" disabled="" value="{{$profile->mobile}}"  style="height: 50px">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="" style="font-size: 18px">Secondary Phone:</label>
                                    <input class="form-control input-lg" disabled="" value="{{$profile->second_mobile}}" type="text" style="height: 50px">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="" style="font-size: 18px">Country of residence:</label>
                                    <input type="text" class="form-control input-lg" disabled="" value="{{$profile->country}}"  style="height: 50px">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="" style="font-size: 18px">Citizenship:</label>
                                    <input type="text" class="form-control input-lg" disabled="" value="{{$profile->citizenship}}" style="height: 50px">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="" style="font-size: 18px">Occupation:</label>
                                    <input type="text" id="profile_email" class="form-control input-lg" disabled="" value="{{$profile->source_of_income}}" style="height: 50px">
                                </div>
                                
                                <div class="radio disabled col-md-6">
                                    <label style="font-size: 16px">
                                        <input type="radio" name="o3" value="" disabled>
                                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                        Do you personally meet the clients?
                                    </label>
                                </div>
                                <!-- <div class="row"> -->
                                <div class="col-md-6">
                                    
                                <div class="">
                                    <label for="" style="font-size: 18px">Gender:</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" value="male" @if($profile->gender == 'male') checked @endif>
                                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                        Male
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" value="female" @if($profile->gender == 'female') checked @endif >
                                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                        Female
                                    </label>
                                </div>
                                    
                                </div>  
                                </div>
                                <!-- </div> -->
                                <div class="form-group col-md-6">
                                    <label for="" style="font-size: 18px">Address:</label>
                                      <textarea class="form-control" rows="5" id="comment" disabled="">{{$profile->address}}</textarea>
                                </div>
                                
                                
                                        
                                
                                <div class="form-group col-md-6">
                                    <label for="" style="font-size: 18px">Date Of Birth:</label>
                                    <input type="text" class="form-control input-lg" disabled="" value="{{$profile->birthday}}"  style="height: 50px">
                                </div>
                                <div class="clearfix"> </div>

                </div>
            </div>
                           


	    	<!-- <div class="row"> -->
	   			
	    		<!-- <div class="col-md-12"> -->
	    			<div class="document-upload" style="margin-top: 5%">
	    				<h3>Upload Document : <span>
                            @if($condition1)
                            @if(!$sub_condition1)
	    					<button type="button" class="btn btn-labeled btn-success" style="margin-left: 3%"><span class="btn-label"><i class="fa fa-check"></i></span>Approved</button>
                            @else
	    					<button type="button" class="btn btn-labeled btn-danger" style="margin-left: 3%"><span class="btn-label"><i class="fa fa-close"></i></span>Pending</button>
                            @endif
                            @elseif($condition2)
	    					<button type="button" class="btn btn-labeled btn-warning" style="margin-left: 3%"><span class="btn-label"><i class="fa fa-info"></i></span>Partially Approved</button></span></h3> 
                            @elseif($condition3) 
                            <button type="button" class="btn btn-labeled btn-danger" style="margin-left: 3%"><span class="btn-label"><i class="fa fa-close"></i></span>Not Approved</button>  
                            @else
                            <button type="button" class="btn btn-labeled btn-danger" style="margin-left: 3%"><span class="btn-label"><i class="fa fa-close"></i></span>Pending</button>	
                            @endif		
	    			</div>

	    		<!-- </div> -->
	    	<!-- </div> -->


            <form action="{{LaravelLocalization::localizeURL('/save-identity')}}" method="post" class="form-horizontal" style="margin-top: 5%" enctype='multipart/form-data'>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <p>Identity : </p>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="identity">Front Side</label>
                            <input type="file" class="form-control" name="id_front" accept='image/*'>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="identity">Back Side</label>
                            <input type="file" class="form-control" name="id_back" accept='image/*'>
                        </div>
                        <div class="col-md-1 m-t-33">
                        
                        <button type="submit" class="btn btn-success center-block">Upload</button>
                            
                        </div>
                        <div class="col-md-1">
                            @if($identity ==1)
                            <div class="tooltip-text">
                                <i class="fa fa-check-circle" aria-hidden="true"><span>Verified</span></i>
                            </div>
                            @elseif($identity ==2)
                            <div class="tooltip-text2">
                                <i class="fa fa-times" aria-hidden="true"><span>Not Verified</span></i>
                            </div>
                            @else
                            <div class="tooltip-text3">
                                <i class="fa fa-info-circle" aria-hidden="true"><span>Pending</span></i>
                            </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </form>
            <form action="/save-resident" method="post" class="form-horizontal" style="margin-top: 1%" enctype='multipart/form-data'>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <p>Resident : </p>
                        </div>
                        <div class="">
                            <div class="form-group col-md-3">
                                <label for="resident">File</label>
                                <input type="file" class="form-control" name="resident">
                            </div>
                        <div class="col-md-1 m-t-33">
                        <button type="submit" class="btn btn-success center-block">Upload</button>
                            
                        </div>
                            <div class="col-md-1">
                            @if($resident ==1)
                            <div class="tooltip-text">
                                <i class="fa fa-check-circle" aria-hidden="true"><span>Verified</span></i>
                            </div>
                            @elseif($resident ==2)
                            <div class="tooltip-text2">
                                <i class="fa fa-times" aria-hidden="true"><span>Not Verified</span></i>
                            </div>
                            @else
                            <div class="tooltip-text3">
                                <i class="fa fa-info-circle" aria-hidden="true"><span>Pending</span></i>
                            </div>
                            @endif
                         
                        </div>
                        </div>
                    </div>
                </div>
            </form>

           
                    
    	</div>
    </div>
</div>
@endsection


@section('page-level-js')


<script type="text/javascript" src="/js/pages/modals.js"></script>

<!--Plugin scripts-->
<script type="text/javascript" src="/vendors/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="/vendors/switchery/js/switchery.min.js"></script>
<!--End of plugin scripts-->
<!--Page level scripts-->
<script type="text/javascript" src="/js/pages/radio_checkbox.js"></script>
<!--End of Page level scripts-->
<!-- end page level scripts -->

<script type="text/javascript" src="/vendors/raphael/js/raphael-min.js"></script>
<script type="text/javascript" src="/vendors/Buttons/js/scrollto.js"></script>
<script type="text/javascript" src="/vendors/Buttons/js/buttons.js"></script>
<script type="text/javascript" src="/assets/backEnd/js/notification.js"></script>
@endsection