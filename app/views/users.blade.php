<!doctype html>
<html lang="en">
    <head></head>
    <body>
    <h1>
        List of all Users
    </h1>
        @foreach($users as $user)
            {{ $user->username }}
        @endforeach


    </body>
</html>