<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        $users = User::paginate(5)->all();
        return view('index', [
            'users' => $users
        ]);
    }
}
