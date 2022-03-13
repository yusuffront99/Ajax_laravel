<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::all();

        if($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="javascript:void(0)" data-id="'.$data->id.'"class="btn btn-info"><i class="bi bi-pencil-square"></i> Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'"class="btn btn-danger"><i class="bi bi-trash-fill"></i> Delete</a>';     
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('index', [
            'data' => $data
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
        User::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name, 'email' => $request->email]
        );

        return response()->json(['success' => 'User Added Successfully']);
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
    }
}
