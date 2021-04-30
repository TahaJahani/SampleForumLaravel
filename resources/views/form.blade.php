<!DOCTYPE html>
<html>
    <body>
        <h1>Hello!</h1>
        <form method="post" action="{{url('/test')}}">
            @csrf
            <input type="text" name="username">
            <input type="submit">
        </form>
    </body>
</html>
