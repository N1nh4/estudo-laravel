<?php

namespace App\Http\Controllers;

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
}
