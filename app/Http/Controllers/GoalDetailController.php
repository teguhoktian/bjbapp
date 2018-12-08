<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Goal_detail;
use App\Goal;
use Yajra\Datatables\Datatables;

class GoalDetailController extends Controller
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

        return view('goalDetail.index')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'goalDetail',
                'page' => __('Goal Detail')
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
        $goals = Goal::pluck('name', 'id');
        return view('goalDetail.create')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'goalDetail',
                'page' => __('Create Goal Detail'),
                'goals' => $goals
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
            'name' => 'required|unique:goals,name',
            'goal_id' => 'required',
        ]);

        $goal = new Goal_detail;
        $goal->name = $request->name;
        $goal->goal_id = $request->goal_id;
        $goal->save($request->all());

        return redirect()->route('goalDetail.show',['id' => $goal->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Goal_detail $goal)
    {
        //
        return view('goalDetail.show')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'goalDetail',
                'page' => __('Show Goal Detail'),
                'goal' => $goal
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Goal_detail $goal_detail)
    {
        $goals = Goal::pluck('name', 'id');
        return view('goalDetail.edit')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'goalDetail',
                'page' => __('Edit Goal Detail'),
                'goal_detail' => $goal_detail,
                'goals' => $goals
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Goal_detail $goal, Request $request)
    {
        //
        $request->validate([
            'name' => 'required|unique:goals,name,' . $goal->id,
            'goal_id' => 'required',
        ]);

        $goal->name = $request->name;
        $goal->goal_id = $request->goal_id;
        $goal->update();

        return redirect()->route('goalDetail.show',['id' => $goal->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goal_detail $goal)
    {
        //
        $goal->delete(); 
        return redirect()->route('goalDetail.index')->with([
            'message_success' => __('Data has been deleted successfully')
        ]);;
    }


    public function anyData(Request $request)
    {   
        if($request->ajax()) {
            $goal = Goal_detail::with('goal')->select(['goal_details.id', 'goal_details.name', 'goal_id']);

            return Datatables::of($goal)
                    ->addColumn('action','goalDetail.action')
                    ->make(true);
        }
        
        return abort('404');
    }
}
