<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = User::get();
        $data = Score::with(['user'])->get();

        if($request->ajax()){
            return DataTables::of($data, $items)
            //=== relationship column add
            ->addColumn('users', function(Score $score){
                return $score->user->name;
            })
            //===============================
            ->addColumn('action', function($data){
                $button = '<a href="javascript:void(0)" data-id="'.$data->id.'"class="btn btn-info edit-data"><i class="bi bi-pencil-square"></i> Edit</a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'"class="btn btn-danger delete-data"><i class="bi bi-trash-fill"></i> Delete</a>';     
                return $button;
            })
            ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('score', [
            'items' => $items
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Score::updateOrCreate($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data Added Successfully'
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
