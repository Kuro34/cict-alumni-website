<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0; padding: 0;
            font-family: 'Poppins', sans-serif;
            background: url('/images/bulsu.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex; justify-content: center; align-items: center; min-height: 100vh;
        }
        .form-container {
            background: rgba(255,255,255,0.9); padding: 30px; border-radius: 10px;
            width: 100%; max-width: 400px; box-sizing: border-box;
        }
        h2 { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn { width: 100%; padding: 10px; border: none; border-radius: 5px; background-color: #007bff; color: white; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .error { color: red; font-size: 14px; margin-bottom: 10px; }
        .success { color: green; font-size: 14px; margin-bottom: 10px; }
        .link { text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>OTP Verification</h2>
        @if(session('success')) <div class="success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="error">{{ session('error') }}</div> @endif

        <form action="{{ route('alumni.reset-password-otp.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Enter OTP</label>
                <input type="number" name="otp_code" required>
                @error('otp_code') <div class="error">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn">Verify OTP</button>
        </form>

        <div class="link">
            <a href="{{ route('alumni.forgot-password.form') }}">Change Email</a>
        </div>
    </div>
</body>
</html>
