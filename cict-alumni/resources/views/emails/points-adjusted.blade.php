<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Points Adjusted</title>
</head>
<body>
    <h2>Hello {{ $alumni->first_name }},</h2>
    <p>Your alumni points have been updated.</p>

    <ul>
        <li><strong>Points Changed:</strong> {{ $pointsChanged > 0 ? '+' : '' }}{{ $pointsChanged }}</li>
        <li><strong>Reason:</strong> {{ $reason }}</li>
        <li><strong>New Total Points:</strong> {{ $newTotal }}</li>
    </ul>

    <p>Thank you for being an active member of our alumni community!</p>
</body>
</html>
