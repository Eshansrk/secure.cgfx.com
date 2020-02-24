<?php

namespace App\Http\Controllers\Backend\de;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\CMS_Liveaccount;
use App\Ticket;
use Carbon\Carbon;
use App\Models\Admin;
use App\Comment;
use Session;
use Auth;

class TicketController extends Controller
{
	public function __construct()
  {
    $this->middleware('adminAccess');
  }

	public function openTicket()
	{
    return view('backEnd.'.app()->getLocale().'.crm.ticket.open-ticket');
	}

	public function storeTicket(Request $request){
		
    	if ($request->subject_other) {

    		$sub = $request->subject_other;
    	}else $sub = $request->subject;
    	$user_email = session('login_email');
    	
  $intIds=DB::table('cms_liveaccount')->where('email',session('login_email'))->first();
    	$id = $intIds->intId;
        $country = $intIds->country;

    	Ticket::create([
    		'subject'	=> $sub,
    		'description'=> $request->description,
    		'user_id'=>$id,
            'ticket_status'=>1
    	]);

        // Notifications

    	DB::table('admins')
        ->where('id',$intIds->manager)
        ->orWhere([
          'country_access'=>'All',
          'manager'=>0
      ])
        ->orWhere([
          'country_access'=>$country,
          'manager'=>0
      ])
        ->increment('ticketOpened', 1);
    	return Redirect::back()->with('msg','Ticket erfolgreich erstellt');
    }

    public function myTickets()
    {
    	return view('backEnd.'.app()->getLocale().'.crm.ticket.my-tickets');
    }

    public function myTicketsDatatable()
    {
        $user = CMS_Liveaccount::where('email',session('login_email'))->first();
    	$tickets = Ticket::select('id','subject')->where('user_id',$user->intId)->where('ticket_status',1)->orderBy('id','desc');
    	$datatables = DataTables::of($tickets);

        return $datatables
        	->editColumn('created_at',function($post){
        		return Carbon::parse($post->created_at)->toDayDateTimeString();
        	})
        	
            ->addColumn('details',function($post){
                return "<a href='/ticket-details-".$post->id."' target='blank'><button type='button' class='btn btn-success btn-min-width btn-round'>Einzelheiten</button></a>";
            })
            
            ->raw(['details'])
           
            ->make(true);
    }

    public function ticketDetails(Request $request)
    {
    	$ticket_id = $request->id;
    	$tickets = Ticket::where('id',$ticket_id)->select('*')->first();
    	$comments = Comment::where('ticket_id',$ticket_id)->select('*')->get();
    	
    	return view('backEnd.'.app()->getLocale().'.crm.ticket.ticket-info',compact('tickets','comments'));
    }

	public function storeTicketReply(Request $request)
	{	$ticket_id = $request->ticket_id;
		$user_id = $request->user_id;
		$reply = $request->reply;
		Comment::create([
			'ticket_id' => $ticket_id,
			'comment' =>$reply,
			'commentator_id' => $user_id,
			'commentator' =>'user'
		]);
		return Redirect::back();
	}
}
