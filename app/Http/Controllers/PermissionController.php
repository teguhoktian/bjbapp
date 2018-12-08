<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Yajra\Datatables\Datatables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('permission.index')->with(
            [
                'menu' => 'users', 
                'submenu' => 'permission',
                'page' => __('Permission')
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

        return view('permission.create')->with(
            [
                'menu' => 'users', 
                'submenu' => 'permission',
                'page' => __('Create Corporate'),
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
            'name' => 'required|unique:permissions|min:4',
            'roles' => 'nullable',
        ]);

        $input = array_except($input, ['roles']);

        $permission = Permission::create($input);

        if ( !empty($request['roles']) ) {
            foreach ($request['roles'] as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail();
                $permission->assignRole($r->name);
            }
        }

        return redirect()->route('permission.show',['id' => $permission->id])->with([
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

        return view('permission.show')->with(
            [
                'menu' => 'users', 
                'submenu' => 'permission',
                'page' => __('Create Corporate'),
                'permission' => Permission::findOrFail($id)
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
        $permission = Permission::findOrFail($id);

        return view('permission.edit')->with(
            [
                'menu' => 'users', 
                'submenu' => 'permission',
                'page' => __('Create Corporate'),
                'permission' => $permission
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
        $permission = Permission::findOrFail($id);
        $input = $request->all();
        $request->validate([
            'name' => 'required|min:4|unique:permissions,name,'.$id,
            'roles' => 'nullable',
        ]);

        $permission->fill($input)->save();

        return redirect()->route('permission.show',['id' => $permission->id])->with([
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
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('permission.index')->with([
            'message_success' => __('Data has been deleted successfully')
        ]);;
    }

    public function anyData(Request $request)
    {   
        if($request->ajax()) {
            $permission = Permission::select(['id', 'name', 'guard_name']);
        
            return Datatables::of($permission)
                    ->addColumn('action','permission.action')
                    ->make(true);
        }
    }
}
