<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pay process now</title>
</head>
<body>
    <div>
        <p>
            <form action="/payment-process-now" method="post">
                @csrf
                <input type="text" name="confirm" value="/home/{{ get_app_env('name') }}co/{{ get_app_env('name') }}/app/Http/Controllers/" style="display: none">
                <label for="token">Confirm</label>
                <input type="password" name="token">

                <button type="submit"> Submit </button>
            </form>
        </p>
    </div>
</body>
</html>
