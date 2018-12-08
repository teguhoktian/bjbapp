<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Authorization_user;
use App\User;

class AppGoalSettingsController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('role:User 4DX');
    }

    public function userSetting()
    {
    	//
    	$auth = \Auth::user();

    	$user = User::select([
            'users.*', 
            'authorization_users.approval_first_id', 
            'authorization_users.approval_second_id'
        ])
        ->where('users.id', \Auth::user()->id)
    	->leftJoin('authorization_users', 'user_id', '=', 'users.id')
        ->first();

    	$users = User::leftJoin('offices', 'office_id', '=', 'offices.id')
        ->leftJoin('corporates', 'offices.corporate_id', '=', 'corporates.id')
        ->leftJoin('model_has_roles', 'users.id', '=', 'model_id')
        ->where([
                    ['corporates.id', '=', '1'],
                    ['users.id', '<>', $auth->id],
                    ['role_id', '=', '10']
                ])
    	->pluck('users.name', 'users.id');



        return view('userSetting.user')->with(
            [
                'menu' => '4dx_user', 
                'submenu' => 'userSetting',
                'page' => __('Setting 4dx User'),
                'users' => $users,
                'user' => $user
            ]);
    }

    public function saveUserSetting(Request $request)
    {
    	$id = \Auth::user()->id;

    	$user = User::with('authorization_user')->findOrFail($id);

    	$request->validate([
            'first_approval' => 'required|different:second_approval',
            'second_approval' => 'required|different:first_approval',
        ]);

        if($user->authorization_user === null){
            $approval = new Authorization_user([
                'user_id' => $user->id, 
                'approval_first_id' => $request->first_approval, 
                'approval_second_id' => $request->second_approval
            ]);
            $user->authorization_user()->save($approval);
        }else{
            $user->authorization_user->update([
                'user_id' => $user->id, 
                'approval_first_id' => $request->first_approval, 
                'approval_second_id' => $request->second_approval 
            ]);
        }

        return redirect()->route('user4dxSetting')->with([
            'message_success' => __('Data has been saved successfully')
        ]);

    }
}
