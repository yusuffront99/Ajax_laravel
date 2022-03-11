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

    public function data()
    {
        return DataTables::of(User::query())
        ->addColumn('action', 'user.action')
        ->toJson();
        // return DataTables::of($users)->toJson();
    }
}
