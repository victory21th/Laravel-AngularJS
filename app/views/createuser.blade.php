<!doctype html>
<html lang="en">
<head></head>
<body>
@foreach($errors->all() as $error)
    <P>
        {{ $error }}
    </P>
@endforeach
    {{ Form::open(array('url' => 'users')) }}
        <p>
            {{ Form::label('username', 'Username*') }}
            {{ Form::text('username') }}
        </p>
    <p>
        {{ Form::label('password', 'Password*') }}
        {{ Form::password('password') }}
    </p>
    <p>
        {{ Form::label('password-repeat','Password-Repeat*') }}
        {{ Form::password('password-repeat') }}
    </p>
    <p>
        {{ Form::submit() }}
    </p>
    {{ Form::close() }}

</body>
</html>