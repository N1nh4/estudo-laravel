<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Usuários</h1>

    @php
        $count = count($users);
    @endphp

    {{ $count }}

    <br><br>

    @endphp
    @include('heading')

    @include('passandoVariavel', [
        'variavel' => 'Valor da variável',
    ])

    {{ count($users) }} <br>

    @if (count($users) === 3)
        <p>Eu tenho 3 usuários</p>
        
    @endif

    @for($i = 0; $i <= count($users); $i++)
        {{ $i }}
    @endfor

    <br>
    <br>

    @foreach ($users as $user)
        @if ($user->id === 1)
            {{ $user->name }}
        @endif
   
        <br>
    @endforeach

    <br><br>

    @forelse ($users as $user)
        {{ $user->name }}
        <br>
    @empty
        <span>Sem usuários</span>
    @endforelse

    <br><br>

    <?php
        $i = 0;
    ?>

    @while ($i <= 10)
        {{ $i++ }}
    @endwhile

</body>
</html>