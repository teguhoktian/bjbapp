<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Corporate;
use Yajra\Datatables\Datatables;

class CorporateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('corporate.index')->with(
            [
                'menu' => 'users', 
                'submenu' => 'corporate',
                'page' => __('Corporate')
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
        return view('corporate.create')->with(
            [
                'menu' => 'users', 
                'submenu' => 'corporate',
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
        $request->validate([
            'corporate_ID' => 'required|alpha_dash|unique:corporates|max:30|min:4',
            'corporate_name' => 'required|max:120|min:4',
        ]);

        $corporate = Corporate::create($request->all());

        return redirect()->route('corporate.show',['id' => $corporate->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Corporate $corporate)
    {
        //
        return view('corporate.show')->with(
            [
                'menu' => 'users', 
                'submenu' => 'corporate',
                'page' => __('Show Corporate'),
                'corporate' => $corporate
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Corporate $corporate)
    {
        //

        return view('corporate.edit')->with(
            [
                'menu' => 'users', 
                'submenu' => 'corporate',
                'page' => __('Edit Office'),
                'corporate' => $corporate,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Corporate $corporate, Request $request)
    {
        //
        $request->validate([
            'corporate_ID' => 'required|alpha_dash|max:30|min:4|unique:corporates,corporate_ID,'.$corporate->id,
            'corporate_name' => 'required|max:120|min:4',
        ]);

        $corporate->update($request->all());

        return redirect()->route('corporate.show',['id' => $corporate->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Corporate $corporate)
    {
        //
        $corporate->delete(); 
        return redirect()->route('corporate.index')->with([
            'message_success' => __('Data has been deleted successfully')
        ]);;
    }

    public function anyData(Request $request)
    {   
        //if($request->ajax()) {
            $corporate = Corporate::select(['id', 'corporate_ID', 'corporate_name']);
        
            return Datatables::of($corporate)
                    ->addColumn('action','corporate.action')
                    ->make(true);
        //}
    }

}
