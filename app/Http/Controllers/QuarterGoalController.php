<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;
use App\Quarter_goal;
use App\Quarter;
use App\Goal;
use App\Goal_detail;

class QuarterGoalController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin 4DX');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('quarterGoal.index')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'quarterGoal',
                'page' => __('Quarter Goal')
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
        $quarters = Quarter::pluck('name', 'id');
        $goals = Goal::pluck('name', 'id');
        return view('quarterGoal.create')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'quarterGoal',
                'page' => __('Create Quarter Goal'),
                'quarters' => $quarters,
                'goals' => $goals,
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
        $request->validate([
            'quarter_id' => 'required|unique:quarter_goals,quarter_id,NULL,id,goal_detail_id,'.$request->goal_detail_id,
            'goal_detail_id' => 'required',
            'goal_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        $quarter = Quarter_goal::create($request->all());

        return redirect()->route('quarterGoal.show', ['id' => $quarter->id ])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Quarter_goal $quarter_goal)
    {
        //
        return view('quarterGoal.show')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'quarterGoal',
                'page' => __('Show Quarter Goal'),
                'quarter_goal' => $quarter_goal
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Quarter_goal $quarter_goal)
    {
        //
        $quarters = Quarter::pluck('name', 'id');
        $goals = Goal::pluck('name', 'id');
        return view('quarterGoal.edit')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'quarterGoal',
                'page' => __('Edit Quarter Goal'),
                'quarters' => $quarters,
                'goals' => $goals,
                'quarter_goal' => $quarter_goal
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Quarter_goal $quarter_goal, Request $request)
    {
        //
        $request->validate([
            'quarter_id' => 'required|unique:quarter_goals,quarter_id,'.$quarter_goal->id.',id,goal_detail_id,'.$request->goal_detail_id,
            'goal_detail_id' => 'required',
            'goal_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        $quarter_goal->update($request->all());

        return redirect()->route('quarterGoal.show', ['id' => $quarter_goal->id ])->with([
            'message_success' => __('Data has been updated successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quarter_goal $quarter)
    {
        //
        $quarter->delete(); 
        return redirect()->route('quarterGoal.index')->with([
            'message_success' => __('Data has been deleted successfully')
        ]);;
    }


    public function anyData(Request $request)
    {   
        if($request->ajax()) {
            $quarter = Quarter_goal::with(['quarter', 'goal_detail'])->select(['quarter_goals.id', 'quarter_id', 'goal_detail_id', 'amount', 'breakdown', 'orientation']);

            return Datatables::of($quarter)
                    ->addColumn('action','quarterGoal.action')
                    ->editColumn('amount', function($data){
                        return number_format($data->amount, 0);
                    })
                    ->make(true);
        }

        return abort('404');
    }

    public function getGoal(Request $request)
    {
        if($request->ajax()) {
            $result = [];
            $goal_details = Goal_detail::select(['id', 'name'])->where('goal_id', $request->q);

            if($request->except) $goal_details->where('id', '!=', $request->except);

            foreach ($goal_details->get() as $goal) {
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
