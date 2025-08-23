<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserComDbController extends Controller
{
    public function index()
    {
        //dd('oi');

        $users = User::all();
        //dd($users);

        //$nome = 'Alana Abreu';

        /*return view('userComDbView', [
            'nome' => $nome,
        ]);*/

        return view('userComDbView', [
            //'users' => ['Alana Abreu'],
            'users' => $users,
        ]);
    }

    public function store() 
    {
        User::create([
            'name' => 'Create no Controller',
            'email' => 'create@email.com',
            'password' => bcrypt('123456'),
        ]);
    }

    public function diretivaBlade() 
    {
        $users = User::all();

        return view('diretivasDoBlade', [
            //'users' => ['Alana Abreu'],
            'users' => $users,
        ]);
    }
}
