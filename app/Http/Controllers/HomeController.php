<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Auth;

use App\Charts\SampleChart;
use App\Charts\FusionChart;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        return view('dashboard')->with(
            [
                'menu' => 'home', 
                'submenu' => '', 
                'page' => __('Welcome') .', '. \Auth::user()->name,
            ]
        );
    }


    public function profile()
    {
        $user = \Auth::user();
        return view('user.profile')->with(
            [
                'menu' => '', 
                'submenu' => '',
                'page' => __('Your Profile'),
                'user' => $user
            ]);
    }

    public function edit_profile()
    {
        $user = \Auth::user();
        return view('user.pedit')->with(
            [
                'menu' => '', 
                'submenu' => '',
                'page' => __('Edit Profile'),
                'user' => $user
            ]);
    }


    public function update_profile(Request $request)
    {
        //
        $input = $request->all();

        $user = \Auth::user();

        $request->validate([
            'name' => 'required|max:120|min:4',
            'password' => 'nullable|confirmed',
        ]);

        // Password Handle Update
        if ( $input['password'] ) {
            $input['password'] = Hash::make( $input['password'] );
        }else{
            $input = array_except($input, ['password']);
        }

        $user->update( $input );

        return redirect()->route('profile')->with([
            'message_success' => __('Data has been updated successfully')
        ]);;
    }
}
