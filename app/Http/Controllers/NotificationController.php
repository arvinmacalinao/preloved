<?php

namespace App\Http\Controllers;

use View;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\NotificationType;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Notifications' ];
		View::share('data', $data);

        $this->middleware(function ($request, $next) {  
            if(!Auth::user()) {
                abort(404);
            }

            // app('App\Http\Controllers\RecordLogController')->recordLog();
            
            return $next($request);
        });
	}

    public function index(Request $request)
    {
        $msg            =   $request->session()->pull('session_msg', '');
        $search         =   $request->get('search') == NULL ? '' : $request->get('search');
        $startDate      =   $request->get('date_start') == NULL ? '' : $request->get('date_start');
        $endDate        =   $request->get('date_end') == NULL ? '' : $request->get('date_end');
        $qtype          =   $request->get('not_type_id') == NULL ? '' : $request->get('not_type_id');

        $types          =   NotificationType::get();

        $rows           =   Notification::where('admin_id', Auth::id())->search($search)->dateRange($startDate, $endDate)->orderBy('read_at', 'asc')->paginate(20);
    
        return view('notification.index', compact('rows', 'search', 'msg', 'endDate', 'startDate', 'types', 'qtype',));
    }

    public function unsold(Request $request)
    {
        $msg            =   $request->session()->pull('session_msg', '');
        $search         =   $request->get('search') == NULL ? '' : $request->get('search');
        $startDate      =   $request->get('date_start') == NULL ? '' : $request->get('date_start');
        $endDate        =   $request->get('date_end') == NULL ? '' : $request->get('date_end');

        $rows           =   Notification::where('admin_id', Auth::id())->where('not_type_id', 1)->search($search)->dateRange($startDate, $endDate)->orderBy('read_at', 'asc')->paginate(20);
    
        return view('notification.unsold', compact('rows', 'search', 'msg', 'endDate', 'startDate'));
    }

    public function sold(Request $request)
    {
        $msg            =   $request->session()->pull('session_msg', '');
        $search         =   $request->get('search') == NULL ? '' : $request->get('search');
        $startDate      =   $request->get('date_start') == NULL ? '' : $request->get('date_start');
        $endDate        =   $request->get('date_end') == NULL ? '' : $request->get('date_end');

        $rows           =   Notification::where('admin_id', Auth::id())->where('not_type_id', 2)->search($search)->dateRange($startDate, $endDate)->orderBy('read_at', 'asc')->paginate(20);
    
        return view('notification.sold', compact('rows', 'search', 'msg', 'endDate', 'startDate'));
    }

    public function markSingleAsRead(Notification $notification)
    {
        // Check if the notification is unread before marking it as read
        if (!$notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        return redirect()->back()->with('success', 'Notification marked as read');
    }

    public function markAsRead(Request $request)
    {   
        $notificationIds = $request->input('notification_id');

        // Loop through each notification ID and mark it as read
        foreach ($notificationIds as $notificationId) {
            $notification = Notification::find($notificationId);
            if ($notification) {
                $notification->update(['read_at' => now()]);
            }
        }
        $request->session()->put('session_msg', 'Notifications marked as read');
        return redirect()->back();
    }
}
