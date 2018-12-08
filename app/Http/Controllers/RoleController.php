<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Yajra\Datatables\Datatables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('role.index')->with(
            [
                'menu' => 'users', 
                'submenu' => 'role',
                'page' => __('Role')
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
        $permissions = Permission::pluck('name', 'id');
        return view('role.create')->with(
            [
                'menu' => 'users', 
                'submenu' => 'role',
                'page' => __('Create Role'),
                'permissions' => $permissions
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
        $input = $request->all();
        $request->validate([
            'name' => 'required|unique:roles|min:4',
            'permissions' => 'nullable',
        ]);

        $input = array_except($input, ['permissions']);

        $role = Role::create($input);

        if ( !empty($request['permissions']) ) {
            foreach ($request['permissions'] as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        return redirect()->route('role.show',['id' => $role->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('role.show')->with(
            [
                'menu' => 'users', 
                'submenu' => 'role',
                'page' => __('Show Role'),
                'role' => Role::findOrFail($id)
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $role = Role::findOrFail($id);
        $permissions = Permission::pluck('name', 'id');
        return view('role.edit')->with(
            [
                'menu' => 'users', 
                'submenu' => 'role',
                'page' => __('Create Corporate'),
                'role' => $role,
                'permissions' => $permissions
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $role = Role::findOrFail($id);
        $input = $request->except(['permissions']);

        $request->validate([
            'name' => 'required|min:4|unique:roles,name,'.$id,
            'permissions' => 'nullable',
        ]);

        $role->fill($input)->save();

        $permissions = Permission::all();
        foreach ($permissions as $p) {
            $role->revokePermissionTo($p);
        }

        if ( !empty($request['permissions']) ) {
            foreach ($request['permissions'] as $ps) {
                $role->givePermissionTo($ps);
            }
        }

        return redirect()->route('role.show',['id' => $role->id])->with([
            'message_success' => __('Data has been updated successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('role.index')->with([
            'message_success' => __('Data has been deleted successfully')
        ]);;
    }

    public function anyData(Request $request)
    {   
        if($request->ajax()) {
            $role = Role::select(['id', 'name', 'guard_name']);
        
            return Datatables::of($role)
                    ->addColumn('action','role.action')
                    ->make(true);
        }
    }
}
