<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Quarter;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class QuarterController extends Controller
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

        return view('quarter.index')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'quarter',
                'page' => __('Quarter')
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
        return view('quarter.create')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'quarter',
                'page' => __('Create Quarter')
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
            'year' => 'required|unique:quarters,year,NULL,id,number,'.$request->number,
            'number' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $quarter = new Quarter;
        $quarter->year = $request->year;
        $quarter->number = $request->number;
        $quarter->name =  'Quarter ' . $request->number . ' ' . $request->year;
        $quarter->start_date = $request->start_date;
        $quarter->end_date = $request->end_date;
        $quarter->save($request->all());

        return redirect()->route('quarter.show',['id' => $quarter->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Quarter $quarter)
    {
        //
        return view('quarter.show')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'quarter',
                'page' => __('Show Quarter'),
                'quarter' => $quarter
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Quarter $quarter)
    {
        //

        return view('quarter.edit')->with(
            [
                'menu' => '4dx_setting', 
                'submenu' => 'quarter',
                'page' => __('Edit Quarter'),
                'quarter' => $quarter
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Quarter $quarter, Request $request)
    {
        //
        $request->validate([
            'year' => 'required|unique:quarters,year,'.$quarter->id.',id,number,'.$request->number,
            'number' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $quarter->year = $request->year;
        $quarter->number = $request->number;
        $quarter->name =  'Quarter ' . $request->number . ' ' . $request->year;
        $quarter->start_date = $request->start_date;
        $quarter->end_date = $request->end_date;
        $quarter->update();

        return redirect()->route('quarter.show',['id' => $quarter->id])->with([
            'message_success' => __('Data has been saved successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quarter $quarter)
    {
        //
        $quarter->delete(); 
        return redirect()->route('quarter.index')->with([
            'message_success' => __('Data has been deleted successfully')
        ]);;
    }


    public function anyData(Request $request)
    {   
        if($request->ajax()) {
            $quarter = Quarter::select(['id', 'name', 'year', 'number', 'start_date', 'end_date']);

            return Datatables::of($quarter)
                    ->addColumn('action','quarter.action')
                    ->editColumn('start_date', function ($quarter) {
                        return $quarter->start_date ? with(new Carbon($quarter->start_date))->format('Y/m/d') : '';;
                    })
                    ->filterColumn('start_date', function ($query, $keyword) {
                        $query->whereRaw("DATE_FORMAT(start_date,'%m/%d/%Y') like ?", ["%$keyword%"]);
                    })
                    ->editColumn('end_date', function ($quarter) {
                        return $quarter->end_date ? with(new Carbon($quarter->end_date))->format('Y/m/d') : '';;
                    })
                    ->filterColumn('end_date', function ($query, $keyword) {
                        $query->whereRaw("DATE_FORMAT(end_date,'%m/%d/%Y') like ?", ["%$keyword%"]);
                    })
                    ->make(true);
        }

        return abort('404');
    }
}
