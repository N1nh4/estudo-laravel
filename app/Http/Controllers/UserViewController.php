<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserViewController extends Controller
{
    public function index() 
    {

        $view = view('userView');

        // Lógica 1 if else

        $view->with([
            'user' => 'Alana',
        ]);

        // Lógica 2 if else

        $view->with([
            'user2' => 'Gabe',
        ]);

        // Terminou a Lógica 

        return $view;

        //pasando dados para minha view, ela passa como variavel para view da para usar o ->with([])
        return view('userView', [
            'user' => 'Alana',
        ]);
    }
}
