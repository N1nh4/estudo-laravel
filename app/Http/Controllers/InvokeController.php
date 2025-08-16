<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvokeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
         dd('quando temos um __invoke ele sempre vai ser executado automaticamente, ou seja não precissamos passar essa função na rota');
    }
}
