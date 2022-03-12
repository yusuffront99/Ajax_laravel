<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuthController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function dataJson()
    {
    //     return DataTables::of(User::query())->toJson();
    // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
    // return Datatables::of($users)->make();

    $users = User::select(['id', 'name', 'email', 'password', 'created_at', 'updated_at']);

    return Datatables::of($users)
        ->addColumn('action', function ($user) {
            return '<a href="edit'.$user->id.'" class="btn btn-md btn-primary">Edit</a>';
        })
        ->editColumn('id', '{{$id}}')
        ->editColumn('updated_at', function ($user) {
            return $user->updated_at->format('Y/m/d');
        })
        ->removeColumn('password')
        ->setRowId('id')
        ->setRowClass(function ($user) {
            return $user->id % 2 == 0 ? 'alert-success' : 'alert-warning';
        })
        ->setRowData([
            'id' => 'test',
        ])
        ->setRowAttr([
            'color' => 'red',
        ])
        ->make(true);
    }
}
