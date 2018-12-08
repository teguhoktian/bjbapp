<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Booking_kredit_goal;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use DB;

use App\Quarter;
use App\User_goal;

class BookingKreditGoalController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:User 4DX');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //return \Auth::user()->appAuth->approval_first_id;

        return view('bookingKredit.index')->with(
            [
                'menu' => '4dx_user', 
                'submenu' => 'bookingKredit',
                'page' => __('Booking Kredit Goal')
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $years = Quarter::distinct()->get()->pluck('year','year');

        return view('bookingKredit.create')->with(
            [
                'menu' => '4dx_user', 
                'submenu' => 'bookingKredit',
                'page' => __('Booking Kredit'),
                'years' => $years,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        if(!(\Auth::user()->appAuth))
        {
            return redirect()->route('bookingKredit.create')->with([
                'message_error' => __('You have to setting up your approval first!')
            ]);
        }

        $request->validate([
            'year' => 'required',
            'quarter_id' => 'required',
            'user_goal_id' => 'required|unique:booking_kredit_goals,user_goal_id,NULL,id,booking_date,'.$request->booking_date,
            'booking_amount' => 'required',
            'noa' => 'required',
            'run_off' => 'sometimes',
            'loan_close' => 'sometimes',
            'booking_date' => 'required|date',
        ]);

        $booking = new Booking_kredit_goal;

        $booking->booking_amount = $request->booking_amount;
        $booking->run_off = $request->run_off ?: 0;
        $booking->loan_close = $request->loan_close ?: 0;
        $booking->booking_date = $request->booking_date;
        $booking->noa = $request->noa;
        $booking->action_id = str_random(6);
        $booking->user_id = \Auth::user()->id;
        $booking->user_goal_id = $request->user_goal_id;
        $booking->first_approval_id  = \Auth::user()->appAuth->approval_first_id;
        $booking->second_approval_id  = \Auth::user()->appAuth->approval_second_id;
        $booking->save();

        return redirect()->route('bookingKredit.show',['id' => $booking->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Booking_kredit_goal $goal)
    {
        //
        if($goal->user_id <> \Auth::user()->id)
        {
            abort('403');
        }

        return view('bookingKredit.show')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'bookingKredit',
                'page' => __('Booking Kredit'),
                'goal' => $goal
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking_kredit_goal $goal)
    {
        //
        if($goal->user_id <> \Auth::user()->id)
        {
            abort('403');
        }

        $years = Quarter::distinct()->get()->pluck('year','year');

        return view('bookingKredit.edit')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'bookingKredit',
                'page' => __('Booking Kredit'),
                'years' => $years,
                'goal' => $goal,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Booking_kredit_goal $goal, Request $request)
    {
        //
        $request->validate([
            'year' => 'required',
            'quarter_id' => 'required',
            'user_goal_id' => 'required|unique:booking_kredit_goals,user_goal_id,'.$goal->id.',id,booking_date,'.$request->booking_date,
            'booking_amount' => 'required',
            'noa' => 'required',
            'run_off' => 'sometimes',
            'loan_close' => 'sometimes',
            'booking_date' => 'required|date',
        ]);

        $goal->booking_amount = $request->booking_amount;
        $goal->run_off = $request->run_off ?: 0;
        $goal->loan_close = $request->loan_close ?: 0;
        $goal->booking_date = $request->booking_date;
        $goal->noa = $request->noa;
        $goal->action_id = str_random(6);
        $goal->user_goal_id = $request->user_goal_id;
        $goal->first_approval_id  = \Auth::user()->appAuth->approval_first_id;
        $goal->second_approval_id  = \Auth::user()->appAuth->approval_second_id;
        $goal->first_approval_status = 'Ongoing';
        $goal->second_approval_status  = 'Ongoing';
        $goal->update();

        return redirect()->route('bookingKredit.show',['id' => $goal->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking_kredit_goal $goal)
    {
        //
        if($goal->user_id <> \Auth::user()->id)
        {
            abort('403');
        }

        $goal->delete();

        return redirect()->route('bookingKredit.index')->with([
            'message_success' => __('Data has been deleted successfully')
        ]);;

    }

    public function anyData(Request $request)
    {
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
                DB::raw('DATEDIFF(end_date, start_date) AS day_quarter'),
                DB::raw('((user_goals.amount / DATEDIFF(end_date, start_date))) AS daily_goal'),
                DB::raw('(booking_amount / ((user_goals.amount / (DATEDIFF(end_date, start_date)+1) ))) * 100 AS percentage_daily_goal'),
                DB::raw('(booking_amount - loan_close) AS nett_booking')
            ])
            ->leftJoin('user_goals', 'user_goal_id', '=', 'user_goals.id')
            ->leftJoin('quarter_goals', 'quarter_goal_id', '=', 'quarter_goals.id')
            ->leftJoin('goal_details', 'goal_detail_id', '=', 'goal_details.id')
            ->leftJoin('quarters', 'quarter_id', '=', 'quarters.id')
            ->where([
                ['booking_kredit_goals.user_id', '=', \Auth::user()->id]
            ]);

            return Datatables::of($goal)
                    ->addColumn('action','bookingKredit.action')
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

    public function getQuarter(Request $request)
    {
        if($request->ajax()) {
            $result = [];
            $quarters = Quarter::select(['id', 'name'])
            ->where('year', $request->q);

            if($request->except) $quarters->where('id', '!=', $request->except);

            foreach ($quarters->get() as $quarter) {
                $selected = ($request->selected == $quarter->id) ? $request->selected : ''; 
                $result[] = array(  
                    'id' => $quarter->id,
                    'text' => $quarter->name,
                    'selected' => $selected 
                );
            }

            return $result;
        }

        return abort('404');
    }

    public function getGoal(Request $request)
    {
        if($request->ajax()) {
            $result = [];
            $goals = User_goal::select(['user_goals.id AS id', 'goal_details.name AS name'])
            ->leftJoin('quarter_goals', 'quarter_goal_id', '=', 'quarter_goals.id')
            ->leftJoin('goal_details', 'goal_detail_id', '=', 'goal_details.id')
            ->leftJoin('quarters', 'quarter_id', '=', 'quarters.id')
            ->leftJoin('goals', 'goal_id', '=', 'goals.id')
            ->where([
                ['quarter_id', '=', $request->q],
                ['goals.name', '=', 'Booking Kredit'],
                ['user_goals.user_id', '=', \Auth::user()->id]
            ]);

            if($request->except) $goals->where('id', '!=', $request->except);

            foreach ($goals->get() as $goal) {
                $selected = ($request->selected == $goal->id) ? $request->selected : ''; 
                $result[] = array(  
                    'id' => $goal->id,
                    'text' => $goal->name,
                    'selected' => $selected 
                );
            }

            return $result;
        }

        return abort('404');
    }
}
