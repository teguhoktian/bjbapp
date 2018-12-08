<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Booking_kredit_goal;
use App\User_goal;
use DB;

class UserDashboardGoalController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:User 4DX');
    }

    public function index(Request $request)
    {

       	$goals = User_goal::select(['user_goals.id AS id', 'goal_details.name AS name'])
            ->leftJoin('quarter_goals', 'quarter_goal_id', '=', 'quarter_goals.id')
            ->leftJoin('goal_details', 'goal_detail_id', '=', 'goal_details.id')
            ->leftJoin('quarters', 'quarter_id', '=', 'quarters.id')
            ->leftJoin('goals', 'goal_id', '=', 'goals.id')
            ->where([
                ['user_goals.user_id', '=', \Auth::user()->id]
            ])->pluck('name', 'id');


        if(!empty($request->goal_id)){
        	$_goal = User_goal::select(['goals.name AS name'])
            ->leftJoin('quarter_goals', 'quarter_goal_id', '=', 'quarter_goals.id')
            ->leftJoin('goal_details', 'goal_detail_id', '=', 'goal_details.id')
            ->leftJoin('quarters', 'quarter_id', '=', 'quarters.id')
            ->leftJoin('goals', 'goal_id', '=', 'goals.id')
            ->where([
                ['user_goals.id', '=', $request->goal_id]
            ])
            ->first();

           	if($_goal && $_goal->name == 'Booking Kredit'){
           		return view('goalDashboard.userBookingKredit')->with([
		    		'menu' => '4dx_user',
		    		'submenu' => 'dashboardUser',
		            'page' => __('Dashboard 4DX'),
		            'goals' => $goals,
		            'request' => $request,
		            'charts' => $this->bookingKreditReport($request)
		        ]);
		        exit();
           	}
        }

    	return view('goalDashboard.index')->with([
    		'menu' => '4dx_user',
    		'submenu' => 'dashboardUser',
            'page' => __('Dashboard 4DX'),
            'goals' => $goals,
            'request' => $request,
        ]);
    }

    public function bookingKreditReport(Request $request)
    {
    	
        $dates = $request->start_date;
       	$start = strtotime($request->start_date);
       	$end = strtotime($request->end_date);

       	$nett_booking = 0;
       	$loan_close = 0;
       	$run_off = 0;
       	$booking_amount = 0;
       	$target = 0;

       	$int = round(($end-$start) / (60 * 60 * 24));

       	for ($i=0; $i <= $int; $i++) { 

       		$goal = Booking_kredit_goal::select([
                'booking_kredit_goals.id', 
                'user_goal_id', 
                'booking_amount', 
                'run_off', 
                'booking_date', 
                'quarters.name AS quarter', 
                'goal_details.name AS goal',
                'loan_close',
                DB::raw('(booking_amount - loan_close) AS nett_booking')
            ])
            ->leftJoin('user_goals', 'user_goal_id', '=', 'user_goals.id')
            ->leftJoin('quarter_goals', 'quarter_goal_id', '=', 'quarter_goals.id')
            ->leftJoin('goal_details', 'goal_detail_id', '=', 'goal_details.id')
            ->leftJoin('quarters', 'quarter_id', '=', 'quarters.id')
       		->whereBetween('booking_date',[$request->start_date, $request->end_date])
       		->orderBy('booking_kredit_goals.id', 'DESC')
       		->where([
       			['booking_kredit_goals.user_id', '=', \Auth::user()->id],
       			['booking_date', '=', $dates],
            ['user_goals.id', '=', $request->goal_id],
            ['first_approval_status', '=', 'Approval'],
            ['second_approval_status', '=', 'Approval'],
       		])
       		->first();

       		$targets = User_goal::select([
       			'user_goals.amount',
       			DB::raw('DATEDIFF(end_date, start_date)+1 AS day_target'),
       			DB::raw(
       				'((user_goals.amount / (DATEDIFF(end_date, start_date)+1))) AS daily_goal'
       			)
            ])
            ->leftJoin('quarter_goals', 'quarter_goal_id', '=', 'quarter_goals.id')
            ->leftJoin('quarters', 'quarter_id', '=', 'quarters.id')
       		->where([
       			['user_goals.id', '=', $request->goal_id],
       			['start_date', '<=', $request->start_date],
       			['end_date', '>=', $request->end_date],
       		])->get()->first();

       		//dd($targets);

       		$nett_booking += $goal?$goal->booking_amount - $goal->loan_close - $goal->run_off:0;
       		$loan_close += $goal?$goal->loan_close:0;
       		$run_off += $goal?$goal->run_off:0;
       		$booking_amount += $goal?$goal->booking_amount:0;

       		$target += $targets?$targets->daily_goal:0;

       		$bookingAmountDS[] = $goal?$goal->booking_amount:0;
       		$runOffDS[] = $goal?$goal->run_off:0;
       		$loanCloseDS[] = $goal?$goal->loan_close:0;
       		$nettBookingDS[] = $goal?$goal->booking_amount - $goal->loan_close - $goal->run_off:0;
       		$targetDS[] = $targets?round($targets->daily_goal,0):0;

       		$categories[] = date('d-m-Y', strtotime($dates));
       		$dates = date('Y-m-d', strtotime($dates . ' +1 day'));

       	}
        
       	if($target <> 0){
       		$achievment = round($nett_booking / $target, 4) *100;
       	}else{
       		$achievment = 0;
       	}
       	
       	
       	return $charts = [
       		'categories' => $categories,

       		'bookingAmountDS' => $bookingAmountDS,
       		'runOffDS' => $runOffDS,
       		'loanCloseDS' => $loanCloseDS,
       		'nettBookingDS' => $nettBookingDS,
       		'targetDS' => $targetDS,

       		'nett_booking' => $nett_booking,
       		'loan_close' => $loan_close,
       		'run_off' => $run_off,
       		'booking_amount' => $booking_amount,
       		'target' => $target,
       		'achievment' => $achievment,
       ];
    }
}
