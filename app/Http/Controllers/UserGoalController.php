<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;
use App\User_goal;
use App\Quarter_goal;
use App\Quarter;
use App\User;

class UserGoalController extends Controller
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

        return view('userGoal.index')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'userGoal',
                'page' => __('User Goal')
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
        $quarters = Quarter::get()->pluck('name', 'id');
        $users = User::leftJoin('offices', 'office_id', '=', 'offices.id')
                ->leftJoin('corporates', 'offices.corporate_id', '=', 'corporates.id')
                ->leftJoin('model_has_roles', 'users.id', '=', 'model_id')
                ->where([
                    ['corporates.id', '=', '1'],
                    ['role_id', '=', '9']
                ])
                ->pluck('users.name', 'users.id');
        return view('userGoal.create')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'userGoal',
                'page' => __('Create User Goal'),
                'quarters' => $quarters,
                'users' => $users,
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
            'user_id' => 'required|unique:user_goals,user_id,NULL,id,quarter_goal_id,'.$request->quarter_goal_id,
            'quarter_goal_id' => 'required',
            'quarter_id' => 'required',
            'amount' => 'required|numeric',
        ]);
        $quarter = User_goal::create($request->all());

        return redirect()->route('userGoal.show', ['id' => $quarter->id ])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User_goal $user_goal)
    {
        //
        return view('userGoal.show')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'userGoal',
                'page' => __('Show User Goal'),
                'user_goal' => $user_goal
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User_goal $user_goal)
    {
        //
        $quarters = Quarter::get()->pluck('name', 'id');
        $users = User::leftJoin('offices', 'office_id', '=', 'offices.id')
                ->leftJoin('corporates', 'offices.corporate_id', '=', 'corporates.id')
                ->where([
                    ['corporates.id', '=', '1'],
                ])->pluck('users.name', 'users.id');
        return view('userGoal.edit')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'userGoal',
                'page' => __('Edit User Goal'),
                'quarters' => $quarters,
                'users' => $users,
                'user_goal' => $user_goal
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User_goal $goal, Request $request)
    {
        //
        $request->validate([
            'user_id' => 'required|unique:user_goals,user_id,'.$goal->id.',id,quarter_goal_id,'.$request->quarter_goal_id,
            'quarter_goal_id' => 'required',
            'quarter_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        $goal->update($request->all());

        return redirect()->route('userGoal.show', ['id' => $goal->id ])->with([
            'message_success' => __('Data has been updated successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_goal $goal)
    {
        //
        $goal->delete(); 
        return redirect()->route('userGoal.index')->with([
            'message_success' => __('Data has been deleted successfully')
        ]);;
    }


    public function anyData(Request $request)
    {   
        if($request->ajax()) {
            $quarter = User_goal::with(['quarter_goal', 'user'])
            ->select(['user_goals.id', 'user_id', 'quarter_goal_id', 'user_goals.amount', 'users.name AS username', 'quarters.name AS quartername', 'goal_details.name AS goal'])
            ->leftJoin('quarter_goals', 'quarter_goal_id', '=', 'quarter_goals.id')
            ->leftJoin('goal_details', 'goal_detail_id', '=', 'goal_details.id')
            ->leftJoin('quarters', 'quarter_id', '=', 'quarters.id')
            ->leftJoin('users', 'user_id', '=', 'users.id');

            return Datatables::of($quarter)
                    ->editColumn('amount', function($data){
                        return number_format($data->amount, 2);
                    })
                    ->addColumn('action','userGoal.action')
                    ->make(true);
        }

        return abort('404');
    }

    public function getGoal(Request $request)
    {
        if($request->ajax()) {
            $result = [];
            $goal_details = Quarter_goal::select(['quarter_goals.id', 'goal_details.name'])
            ->leftJoin('quarters', 'quarter_id', '=', 'quarters.id')
            ->leftJoin('goal_details', 'goal_detail_id', '=', 'goal_details.id')
            ->where('quarter_id', $request->q);

            if($request->except) $goal_details->where('quarter_goals.id', '!=', $request->except);

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
