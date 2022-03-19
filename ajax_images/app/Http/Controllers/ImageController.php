<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $data = Image::all();

        if($request->ajax()) {
            return DataTables::of($data)
                // ->addColumn('action', function($data){
                //     $button = '<a href="javascript:void(0)" data-id="'.$data->id.'"class="btn btn-info edit-data"><i class="bi bi-pencil-square"></i> Edit</a>';
                //     $button .= '&nbsp;&nbsp;';
                //     $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'"class="btn btn-danger delete-data"><i class="bi bi-trash-fill"></i> Delete</a>';     
                //     return $button;
                // })
                ->addColumn('image', 'image')
                ->addColumn('action', 'action')
                ->rawColumns(['action', 'image'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('index', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'image' => 'image|mimes:png,jpg, jpeg|max:2048',
        // ]);

        // $id = $request->id;

        // if($files = $request->file('image')){

        //     $path = 'public/images/';
        //     $profileImage = date('YmDHis') . "." . $files->getClientOriginalExtension();
        //     $files->move($path, $profileImage);
        //     $image['image'] = $request->image;
        // }

        // $data = Image::updateOrCreate(['id' => $id], $image);

        // return response()->json($data);

        $valideData = $request->validate([
            'image' => 'image|file|max:2048',
        ]);

        if($request->file('image')) {
            $valideData['image'] = $request->file('image')->store('uploads/images');

            Image::create($valideData);

            return response()->json([
                'success' => true,
                'message' => 'success'
            ]);

            // return to_route('image.index');
        }
    }

    // public function edit(Request $request)
    // {
    //     $where = array('id' => $request->id);
    //     $image  = Image::where($where)->first();
    
    //     return Response()->json($image);
    // }

    // public function delete(Request $request)
    // {
    //     $images= Image::where('id',$request->id)->delete();
    
    //     return Response()->json($images);
    // }
}
