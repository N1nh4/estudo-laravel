<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function index()
    {
        dd('index');
    }

    public function funcId(Request $request, $id)
    {
        dd($request->query(), $id);
    }


    public function funcModelUser(Request $request, User $user)
    {
        return $user;
        dd($user);
    }
}
    