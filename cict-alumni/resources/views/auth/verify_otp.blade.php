<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('/images/bulsu.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .resend-btn {
            background-color: gray;
            margin-top: 10px;
        }
        .error { color: red; margin-bottom: 10px; }
        .success { color: green; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Email Verification</h2>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('otp.verify') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="otp_code">Enter the OTP sent to your email:</label>
                <input type="number" name="otp_code" id="otp_code" required>
                <input type="hidden" name="alumniID" value="{{ request('alumniID') }}">
            </div>
            <button type="submit" class="btn">Verify OTP</button>
        </form>

        <form action="{{ route('otp.resend') }}" method="POST" id="resendForm">
            @csrf
            <input type="hidden" name="alumniID" value="{{ request('alumniID') }}">
            <button type="submit" class="btn resend-btn" id="resendBtn" disabled>Resend OTP (30s)</button>
        </form>
    </div>

    <script>
        let cooldown = 30;
        const resendBtn = document.getElementById('resendBtn');

        function updateButton() {
            if (cooldown > 0) {
                resendBtn.textContent = `Resend OTP (${cooldown}s)`;
                resendBtn.disabled = true;
                cooldown--;
                setTimeout(updateButton, 1000);
            } else {
                resendBtn.textContent = 'Resend OTP';
                resendBtn.disabled = false;
            }
        }

        updateButton(); // Start cooldown on page load
    </script>
</body>
</html>
