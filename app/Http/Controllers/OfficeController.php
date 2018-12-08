<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Office;
use Yajra\Datatables\Datatables;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('office.index')->with(
            [
                'menu' => 'users', 
                'submenu' => 'office',
                'page' => __('Office')
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
        $offices = Office::pluck('name', 'id');
        return view('office.create')->with(
            [
                'menu' => 'users', 
                'submenu' => 'office',
                'page' => __('Create Office'),
                'offices' => $offices,
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
            'code' => 'required|alpha_dash|unique:offices|max:30|max:12|min:4',
            'name' => 'required|max:120|min:4',
            'corporate_id' => 'required',
            'parent' => 'nullable'
        ]);

        $office = Office::create($request->all());

        return redirect()->route('office.show',['id' => $office->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        //
        return view('office.show')->with(
            [
                'menu' => 'users', 
                'submenu' => 'office',
                'page' => __('Show Office'),
                'office' => $office
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        //
        $offices = Office::pluck('name', 'id')->except([$office->id]);

        return view('office.edit')->with(
            [
                'menu' => 'users', 
                'submenu' => 'office',
                'page' => __('Edit Office'),
                'office' => $office,
                'offices' => $offices,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Office $office, Request $request)
    {
        //
        $request->validate([
            'code' => 'required|alpha_dash|max:12|min:4|unique:offices,code,'.$office->id,
            'name' => 'required|max:120|min:4',
            'corporate_id' => 'required',
            'parent' => 'nullable'
        ]);

        $office->update($request->all());

        return redirect()->route('office.show',['id' => $office->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        //
        $office->delete(); 
        return redirect()->route('office.index')->with([
            'message_success' => __('Data has been deleted successfully')
        ]);;
    }

    public function anyData(Request $request)
    {   
        if($request->ajax()) {
            $office = Office::select(['id', 'code', 'name', 'parent', 'corporate_id']);
        
            return Datatables::of($office)
                    ->addColumn('action','office.action')
                    ->editColumn('parent', function ($office) {
                        return ( !is_null( $office->parent()->first() ) ) ? ($office->parent()->first()['name']) : "" ;
                    })->editColumn('corporate_id', function ($office) {
                        return ( !is_null( $office->corporate_id ) ) ? ($office->corporate->corporate_ID) : "" ;
                    })
                    ->make(true);
        }
    }

    /**
     * Get the specified office in corporate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getOffice(Request $request)
    {
        if($request->ajax()) {
            $result = [];
            $offices = Office::select(['id', 'name'])->where('corporate_id', $request->q);

            if($request->except) $offices->where('id', '!=', $request->except);

            foreach ($offices->get() as $office) {
                $selected = ($request->selected == $office->id) ? $request->selected : ''; 
                $result[] = array(  
                    'id' => $office->id,
                    'text' => $office->name,
                    'selected' => $selected 
                );
            }

            return $result;
        }
    }
}
