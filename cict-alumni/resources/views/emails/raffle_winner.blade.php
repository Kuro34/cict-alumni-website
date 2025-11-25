<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Raffle Winner</title>
</head>
<body>
    <h1>Congratulations {{ $alumni->first_name }}! 🎉</h1>
    <p>You are the winner of the raffle: <strong>{{ $raffle->title }}</strong>.</p>

    @if($raffle->description)
        <p>{{ $raffle->description }}</p>
    @endif

    <p>Please wait for further instructions from the admin to claim your prize.</p>

    <p>Thank you for participating!</p>
</body>
</html>
