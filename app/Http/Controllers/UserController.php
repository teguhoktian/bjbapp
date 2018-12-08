<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super User');
        $this->middleware('permission:view user')->only('index');
        $this->middleware('permission:create user')->only('create', 'store');
        $this->middleware('permission:update user')->only('edit', 'update');
        $this->middleware('permission:delete user')->only('delete');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('user.index')->with(
            [
                'menu' => 'users', 
                'submenu' => 'user',
                'page' => __('Users')
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
        $roles = Role::pluck('name', 'id');

        return view('user.create')->with(
            [
                'menu' => 'users', 
                'submenu' => 'user',
                'page' => __('Create User'),
                'roles' => $roles,
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
            'username' => 'required|unique:users|max:120|min:4',
            'name' => 'required|max:120|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'status' => 'required',
            'roles' => 'nullable',
            'office_id' => 'nullable'
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'password' => Hash::make($request->password),
        ]);

        // Roles Handle
        if ( $request->has('roles') ) {
             foreach ($request->roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();            
                $user->assignRole($role_r); 
            }
        }

        return redirect()->route('user.show',['id' => $user->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        $user_roles = $user->roles->pluck('name')->implode(', ');

        return view('user.show')->with(
            [
                'menu' => 'users', 
                'submenu' => 'user',
                'page' => __('Show User'),
                'user' => $user,
                'user_roles' => $user_roles
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        $roles = Role::pluck('name', 'id');
        $user_roles = $user->roles->pluck('id','id');

        return view('user.edit')->with(
            [
                'menu' => 'users', 
                'submenu' => 'user',
                'page' => __('Edit User'),
                'user' => $user,
                'roles' => $roles,
                'user_roles' => $user_roles
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        //
        $input = $request->all();

        $request->validate([
            'username' => 'required|max:120|min:4|unique:users,username,'.$user->id,
            'name' => 'required|max:120|min:4',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|confirmed',
            'status' => 'required',
            'roles' => 'nullable',
            'office_id' => 'nullable',
        ]);

        // Password Handle Update
        if ( $input['password'] ) {
            $input['password'] = Hash::make( $input['password'] );
        }else{
            $input = array_except($input, ['password']);
        }

        // Handle Roles
        if ( $request->has('roles') ) {
             $user->roles()->sync($request->roles);
        }else{
            $user->roles()->detach();
        }

        $user->update( $input );

        return redirect()->route('user.show',['id' => $user->id])->with([
            'message_success' => __('Data has been updated successfully')
        ]);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete(); 
        return redirect()->route('user.index')->with([
            'message_success' => __('Data has been deleted successfully')
        ]);;

    }

    public function anyData(Request $request)
    {   
        if($request->ajax())
        {
            $users = User::select(['id', 'name', 'username', 'email', 'status']);
        
            return Datatables::of($users)
                    ->addColumn('action','user.action')
                    ->addColumn('roles', function($user){
                        return $user->roles()->pluck('name')->implode(', ');
                    })
                    ->make(true);
        }
    }

}
