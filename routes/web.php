<?php

use App\Http\Controllers\InvokeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserResourceModelController;
use App\Http\Controllers\UserScopeController;
use App\Http\Middleware\CheckToken;
use App\Http\Middleware\MiddlewareGlobal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+'); // Define a pattern global para o parâmetro id, assim não é necessário definir em cada rota


Route::resourceVerbs([
    'create' => 'criar',
]);

// posso pasar paramentro para achar o usuario pelo atributo email o padrão seria o id a função scoped não funciona mais nessa versão do laravel
Route::get('/userScope/{user:email}', [UserScopeController::class, 'show']);


// usersComments/{user}/comments
// usersComments/{user}/comments/{comment}
Route::resource('usersComments.comments', UserController::class);

Route::apiResource('users', UserController::class); // ele tira as rotas de view (create e edit)

Route::resources([
    'users' => UserController::class,
    'user-resource' => UserResourceModelController::class,
]);

Route::resource('user-resource', UserResourceModelController::class)->only('index');

Route::get('/testandoInvoke', InvokeController::class);

Route::get('/userControllerUser/{user}', [UserController::class, 'funcModelUser']);

Route::get('/userControllerId/{id}', [UserController::class, 'funcId']);

// O certo é usar a rota só para roteamento de rotas mesmo, o ideal é usar o controller para lidar com as regras de negócio
Route::get('/userController', [UserController::class, 'index']);

// Essa ordem de declaração do array IMPORTA!!
// poderia usar o 'myApp' que foi criado no app.php que seria um grupo de middlewares lá a ordem tambem importa 
Route::middleware(['check-token','middleware-group'])->group(function() {
    Route::get('/middlewareInGroup', function () {
        return 'Middleware aplicado em grupo';
    });

    Route::get('/anotherMiddlewareInGroup', function () {
        return 'Outro middleware aplicado em grupo';
    });

    Route::get('/removeMiddlewareInGroup', function () {
        return 'Removendo Middleware em grupo';
    })->withoutMiddleware('middleware-group'); // Removendo o middleware do grupo
});

// Rota usando middleware global
Route::middleware([MiddlewareGlobal::class])->get('/middleware-global', function () {
    return 'Middleware Global';
});

Route::get('/middleware', function () {
    dd('x');
})->middleware('user-agent'); // Aqui estamos usando o middleware nomeado 'user-agent' que foi definido no app.php


Route::get('/injecaoDependencia', function (Request $request) {
    dd($request); // dump e die, para ver o conteúdo da requisição
    dd($request->method()); // Mostra todos os dados da requisição
    return $request;
});

// Rotas com fallback, quando não encontrar nenhuma rota correspondente, irá retornar a mensagem 'HELLO WORLD'
Route::fallback(function () {
    return 'HELLO WORLD';
});


// Agrupando rotas com domínios e subdomínios, não herd não funciona o subdominio automaticamente, e para criar um domino é só ir no app do herd clicar com o botão direito e add um novo alias 
Route::domain('{user}.cursolaravelpro.test')->group(function () {
    Route::get('{id}', function ($user, $id) {
        return 'Usuário: ' . $user . ' - ID: ' . $id;
    });
});

// Agrupando rotas com middleware, atualmente na versão mais recente do Laravel não vem mais com a pasta middleware por padrão, mas memso assim é possivel utlizar o middleware auth e os outros padrões do Laravel
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return 'Polícia Federal';
    });

    Route::get('home/{id}', function ($id) {
        return 'ID: ' . $id;
    });
});

Route::get('/outraFormaDeUsarMiddleware', function () {
    return 'Outra forma de usar o middleware';
})->middleware('signed'); // Aqui estamos usando o middleware diretamente na rota


// Agrupando rotas com prefixo 'admin'
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return 'Admin Dashboard';
    })->name('dashboard');

    Route::get('/settings', function () {
        return 'Admin Settings';
    })->name('settings');
});

Route::get('/testePattern/{id}', function ($id) {
    return 'O id é: ' . $id;
});

Route::get('/', function () {
    return view('welcome');
});

// Acontece a mesma coisa que a rota acima, mas com o método view
// que é uma forma mais simples de retornar uma view
Route::view('/welcome', 'welcome', [
    'title' => 'Bem-vindo ao Laravel', // passando uma variável para a view
]);

// Rota com parametro obrigatório
// O where limita o parametro id para apenas números
Route::get('/usersTest/{id}/{name}', function ($id, $name) {
    return 'User ' . $id . ' - Name: ' . $name;
})->where('id', '[0-9]+')->where('name', '[A-Za-z]+'); // poderia ser whereNumber e whereAlpha ou whereAlphaNum, whereUuid em vez de usar expressões regulares

// Outra forma de limitar os parametros usando o where com array
Route::get('/produtos/{id}/{name}', function ($id, $name) {
    return 'Produto ' . $id . ' - Nome: ' . $name;
})->where([
    'id' => '[0-9]+',
    'name' => '[A-Za-z]+'
]);

// validação global 


// Parametro opcional e obrigatorio na rota
// Se não passar o id, o valor padrão será null (A ORDEM IMPORTA)
Route::get('/usuario/{id?}/{name}', function ($id = null, $name = null) {
    return 'Usuário ' . $id . ' - Nome: ' . $name;
});


//não é uma pratica comum usar o match
Route::match(['get', 'post'], 'users', function () {
    return 'Hello world';
})->name('users'); // criando nome da rota


// Redirecionando de uma rota para outra automaticamente
Route::redirect('rota-a', 'rota-b', 301);

// Mesma coisa que o redirect, mas com o status 301 (permanente)
Route::permanentRedirect('rota-a', 'rota-b');

// Redirecionando de uma rota para outra com uma função anônima (aqui está redirecionando pela uri rota-b)
Route::get('rota-a', function () {
    return redirect('rota-b');
});

// Redirecionando de uma rota para outra usando o nome da rota
// (aqui está redirecionando pela rota nomeada rotab)
Route::get('rota-a', function () {
    return redirect()->route('rotab');
});

Route::get('rota-b', function () {
    return 'Rota B';
})->name('rotab');
