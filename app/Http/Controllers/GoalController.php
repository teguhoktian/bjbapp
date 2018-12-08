<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Goal;
use Yajra\Datatables\Datatables;

class GoalController extends Controller
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

        return view('goal.index')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'goal',
                'page' => __('Goal')
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
        return view('goal.create')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'goal',
                'page' => __('Create Goal')
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
        ]);

        $goal = new Goal;
        $goal->name = $request->name;
        $goal->save($request->all());

        return redirect()->route('goal.show',['id' => $goal->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Goal $goal)
    {
        //
        return view('goal.show')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'goal',
                'page' => __('Show Goal'),
                'goal' => $goal
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Goal $goal)
    {
        //
        return view('goal.edit')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'goal',
                'page' => __('Edit Goal'),
                'goal' => $goal
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Goal $goal, Request $request)
    {
        //
        $request->validate([
            'name' => 'required|unique:goals,name,'.$goal->id,
        ]);

        $goal->name = $request->name;
        $goal->update($request->all());

        return redirect()->route('goal.show',['id' => $goal->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goal $goal)
    {
        //
        $goal->delete(); 
        return redirect()->route('goal.index')->with([
            'message_success' => __('Data has been deleted successfully')
        ]);;
    }


    public function anyData(Request $request)
    {   
        if($request->ajax()) {
            $goal = Goal::select(['id', 'name']);

            return Datatables::of($goal)
                    ->addColumn('action','goal.action')
                    ->make(true);
        }

        return abort('404');
    }
}