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

    {{ count($users) }} <br>

    @if (count($users) === 3)
        <p>Eu tenho 3 usuários</p>
        
    @endif
</body>
</html>