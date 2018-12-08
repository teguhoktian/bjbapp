<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Booking_kredit_goal;
use App\User_goal;
use App\Goal_detail;
use App\Office;
use DB;

class PukDashboardGoalController extends Controller
{
    public function __construct()
  	{
  		$this->middleware('role:PUK 4DX');

  	}

    public function index(Request $request)
    {

    	$offices = Office::where(function($query){
    		$query->where('id', '=', \Auth::user()->office_id)
    		->orWhere('parent', '=', \Auth::user()->office_id);
    	})->pluck('name', 'code');

       	$goals = Goal_detail::pluck('name', 'id');

        if(!empty($request->goal_id)){
        	$_goal = User_goal::select(['goals.name AS name'])
            ->leftJoin('quarter_goals', 'quarter_goal_id', '=', 'quarter_goals.id')
            ->leftJoin('goal_details', 'goal_detail_id', '=', 'goal_details.id')
            ->leftJoin('quarters', 'quarter_id', '=', 'quarters.id')
            ->leftJoin('goals', 'goal_id', '=', 'goals.id')
            ->where([
                ['goal_details.id', '=', $request->goal_id]
            ])
            ->first();

           	if($_goal && $_goal->name == 'Booking Kredit'){
           		return view('goalDashboard.pukBookingKredit')->with([
		    		'menu' => '4dx_puk',
		    		'submenu' => 'dashboardPuk',
		            'page' => __('Dashboard 4DX PUK'),
		            'goals' => $goals,
		            'request' => $request,
		            'offices' => $offices,
		            'charts' => $this->bookingKreditReport($request)
		        ]);
		        exit();
           	}
        }

    	return view('goalDashboard.pukIndex')->with([
    		'menu' => '4dx_puk',
		    'submenu' => 'dashboardPuk',
		    'page' => __('Dashboard 4DX PUK'),
            'goals' => $goals,
            'offices' => $offices,
            'request' => $request,
        ]);
    }

    public function bookingKreditReport(Request $request)
    {

      $dates = $request->start_date;
      $start = strtotime($request->start_date);
      $end = strtotime($request->end_date);

      if($request->office_id == ''){
        $_office = \Auth::user()->office->children->pluck('code')->toArray();
        array_push($_office, \Auth::user()->office->code);
      }else{
        $_office = [$request->office_id];
      }

      $nett_booking = 0;
      $loan_close = 0;
      $run_off = 0;
      $booking_amount = 0;
      $target = 0;

      $int = round(($end-$start) / (60 * 60 * 24));

      for ($i=0; $i <= $int; $i++) {

        $goal = Booking_kredit_goal::select([
          DB::raw('SUM(booking_amount) AS booking_amount'), 
          DB::raw('SUM(run_off) AS run_off'), 
          DB::raw('SUM(booking_amount - loan_close - run_off) AS nett_booking'),
          DB::raw('SUM(loan_close) AS loan_close'),
          'booking_date',
        ])
        ->leftJoin('users', 'users.id', '=', 'booking_kredit_goals.user_id')
        ->leftJoin('user_goals', 'user_goal_id', '=', 'user_goals.id')
        ->leftJoin('quarter_goals', 'quarter_goal_id', '=', 'quarter_goals.id')
        ->leftJoin('goal_details', 'goal_detail_id', '=', 'goal_details.id')
        ->leftJoin('offices', 'offices.id', '=', 'users.office_id')
        ->where('goal_details.id', '=', $request->goal_id)
        ->where('booking_date', '=', date("Y-m-d",strtotime($dates)))
        ->where('first_approval_status', '=', 'Approval')
        ->where('second_approval_status', '=', 'Approval')
        ->whereIn('offices.code', $_office)
        ->groupBy('booking_date')
        ->get()->first();



        $targets = User_goal::select([
           DB::raw('SUM(user_goals.amount) AS amount'),
           'goal_details.name',
           DB::raw(
              'SUM((user_goals.amount / (DATEDIFF(end_date, start_date)+1))) AS daily_goal'
            )
        ])
        ->leftJoin('users', 'user_goals.user_id', '=', 'users.id')
        ->leftJoin('offices', 'users.office_id', '=', 'offices.id')
        ->leftJoin('quarter_goals', 'quarter_goal_id', '=', 'quarter_goals.id')
        ->leftJoin('goal_details', 'goal_detail_id', '=', 'goal_details.id')
        ->leftJoin('quarters', 'quarter_id', '=', 'quarters.id')
        ->whereIn('offices.code', $_office)
        ->where('goal_details.id', '=', $request->goal_id)
        ->where([
            ['start_date', '<=', $request->start_date],
            ['end_date', '>=', $request->end_date],
          ])
        ->groupBy('goal_details.name')
        ->get()->first();

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
