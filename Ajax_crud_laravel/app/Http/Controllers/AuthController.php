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
    $users = User::select(['id','name','email', 'created_at']);
    return Datatables::of($users)->make();
    }
}
