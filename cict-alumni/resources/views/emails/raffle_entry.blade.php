<!-- resources/views/emails/raffle_entry.blade.php -->
<h1>Congratulations!</h1>

<p>You have successfully entered the raffle: <strong>{{ $raffleTitle }}</strong></p>

<p>Points used: {{ $reward->point_cost }}</p>

<p>Thank you for participating!</p>

<p><a href="{{ route('rewards.index') }}">View Rewards</a></p>

<p>Thanks,<br>{{ config('app.name') }}</p>
