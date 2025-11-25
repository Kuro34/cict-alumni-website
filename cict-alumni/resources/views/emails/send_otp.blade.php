<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .otp {
            font-size: 32px;
            font-weight: bold;
            color: #007bff;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello,</h2>
        <p>Thank you for registering on the Alumni Portal.</p>
        <p>Your One-Time Password (OTP) is:</p>

        <div class="otp">{{ $otp }}</div>

        <p>Please enter this code on the website to verify your email.</p>
        <p>This OTP is valid for 5 minutes.</p>

        <p>If you did not initiate this registration, please ignore this email.</p>

        <p>Thank you,<br>CICT Alumni Management System Team</p>
    </div>
</body>
</html>
