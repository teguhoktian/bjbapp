<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use DB;

use App\Booking_kredit_goal;

class AppGoalController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('role:PUK 4DX');
    }

    public function bookingKreditApproval()
    {
        //
        //return \Auth::user()->appAuth->approval_first_id;

        return view('approval.bookingKredit')->with(
            [
                'menu' => '4dx_puk', 
                'submenu' => 'bookingKreditApproval',
                'page' => __('Booking Kredit Goal Approval')
            ]);
    }

    public function bookingKreditApprovalData(Request $request)
    {
        //Ajax Request
        if($request->ajax()) {
            $goal = Booking_kredit_goal::select([
                'booking_kredit_goals.id', 
                'user_goal_id', 
                'booking_amount', 
                'booking_date', 
                'quarters.name AS quarter', 
                'goal_details.name AS goal',
                'loan_close',
                'first_approval_status',
                'second_approval_status',
                'users.name AS user_name',
                DB::raw('DATEDIFF(end_date, start_date) AS day_quarter'),
                DB::raw('((user_goals.amount / DATEDIFF(end_date, start_date))) AS daily_goal'),
                DB::raw('(booking_amount / ((user_goals.amount / DATEDIFF(end_date, start_date)))) * 100 AS percentage_daily_goal'),
                DB::raw('(booking_amount - loan_close) AS nett_booking')
            ])
            ->leftJoin('user_goals', 'user_goal_id', '=', 'user_goals.id')
            ->leftJoin('quarter_goals', 'quarter_goal_id', '=', 'quarter_goals.id')
            ->leftJoin('goal_details', 'goal_detail_id', '=', 'goal_details.id')
            ->leftJoin('quarters', 'quarter_id', '=', 'quarters.id')
            ->leftJoin('users', 'booking_kredit_goals.user_id', '=', 'users.id')
            ->where(function($query){
            	$query->where('first_approval_id', '=', \Auth::user()->id)
            	->where('first_approval_status', '=', 'Ongoing');
            })
            ->orWhere(function($query){
            	$query->where('second_approval_id', '=', \Auth::user()->id)
            	->where('first_approval_status', '=', "Approval")
            	->where('second_approval_status', '=', "Ongoing");
            });

            return Datatables::of($goal)
                    ->addColumn('action','approval.actionBookingKredit')
                    ->editColumn('booking_date', function ($goal) {
                        return $goal->booking_date ? with(new Carbon($goal->booking_date))->format('Y/m/d') : '';;
                    })
                    ->filterColumn('booking_date', function ($query, $keyword) {
                        $query->whereRaw("DATE_FORMAT(booking_date,'%m/%d/%Y') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('daily_goal', function ($goal) {
                        return number_format($goal->daily_goal,2);
                    })
                    ->editColumn('percentage_daily_goal', function ($goal) {
                        return number_format($goal->percentage_daily_goal,2);
                    })
                    ->editColumn('booking_amount', function ($goal) {
                        return number_format($goal->booking_amount,2);
                    })
                    ->editColumn('nett_booking', function ($goal) {
                        return number_format($goal->nett_booking,2);
                    })
                    ->make(true);
        }

        return abort('404');
    }

    public function bookingKreditApprovalAction($id, Request $request)
    {
    	//return $id ." ". $request->action;
    	$goal = Booking_kredit_goal::findOrFail($id);

        if($request->aproval == 'First Approval')
        {
        	if($request->action == 'Rejected'){
        		$goal->first_approval_status = 'Rejected';
        		$goal->first_approval_date = date('Y-m-d');
        		$goal->second_approval_status = 'Rejected';
        		$goal->second_approval_date = date('Y-m-d');
        	}else{
        		$goal->first_approval_status = 'Approval';
        		$goal->first_approval_date = date('Y-m-d');
        	}
        }else{
        	$goal->second_approval_status = $request->action;
        	$goal->second_approval_date = date('Y-m-d');
        }

        $goal->update();

        return redirect()->route('approval.bookingKredit')->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }
}
