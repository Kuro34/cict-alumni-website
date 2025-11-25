<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CICT Alumni Login</title>

    <!-- Bootstrap + Icons + Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Poppins',sans-serif;
            background-image:url('/images/bulsu.jpg');
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
            height:100vh;
            margin:0;
            display:flex;
            align-items:center;
            justify-content:center;
            position:relative;
            overflow:hidden;
        }
        body::before{
            content:"";
            position:absolute;
            top:0;left:0;
            width:100%;height:100%;
            background-color:rgba(30,58,138,0.85);
            z-index:0;
        }
        .form-container{
            position:relative;
            z-index:1;
            background:#fff;
            border-radius:12px;
            box-shadow:0 4px 10px rgba(0,0,0,0.25);
            padding:25px 28px;
            width:100%;
            max-width:550px;
        }
        h2{
            font-weight:700;
            text-align:center;
            color:#1e3a8a;
            font-size:1.25rem;
            margin-bottom:0.85rem;
        }
        label{
            font-weight:600;
            color:#1e3a8a;
            font-size:0.8rem;
        }
        input{
            border-radius:6px!important;
            border:1px solid #ccc;
            font-size:0.8rem;
            padding:4px 8px;
            height:32px;
        }
        .btn{
            border-radius:6px;
            background-color:#1e3a8a;
            color:#fff;
            font-weight:600;
            font-size:0.8rem;
            border:none;
            padding:6px 14px;
            transition:0.3s;
        }
        .btn:hover{
            background-color:#3b82f6;
        }
        .error{
            color:red;
            font-size:0.75rem;
            margin-top:3px;
        }
        .link a{
            color:#1e3a8a;
            text-decoration:none;
            font-size:0.8rem;
        }
        .link a:hover{
            text-decoration:underline;
        }
        .forgot-password-link a{
            font-size:0.7rem;
            color:#1e3a8a;
            text-decoration:none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2><i class="fa-solid fa-user-graduate me-2"></i>Alumni Login</h2>

        @if(session('error'))
            <div class="alert alert-danger text-center py-1 mb-2">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success text-center py-1 mb-2">{{ session('success') }}</div>
        @endif

        <form action="{{ route('alumni.login.submit') }}" method="POST">
            @csrf

            <div class="mb-2">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="mb-1">
                <label>Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="forgot-password-link mt-1 mb-2">
                <a href="{{ route('alumni.forgot-password.form') }}">Forgot Password?</a>
            </div>

            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input" onclick="togglePassword()">
                <label class="form-check-label">Show Password</label>
            </div>

            @if(session('lockout_seconds'))
                <div class="error mb-2">
                    Too many failed attempts. Try again in <span id="lockout-timer">{{ session('lockout_seconds') }}</span> seconds.
                </div>
            @endif

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ url('/') }}" class="btn">← Back</a>
                <button type="submit" class="btn" {{ session('lockout_seconds') ? 'disabled' : '' }}>Login</button>
            </div>

            <div class="text-center mt-3 link">
                <a href="{{ route('alumni.register') }}">Don't have an account? Sign Up</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(){
            const pwd=document.getElementById('password');
            pwd.type=pwd.type==="password"?"text":"password";
        }

        const timerElem=document.getElementById('lockout-timer');
        if(timerElem){
            let seconds=parseInt(timerElem.innerText);
            const interval=setInterval(()=>{
                seconds--;
                timerElem.innerText=seconds;
                if(seconds<=0){
                    clearInterval(interval);
                    location.reload();
                }
            },1000);
        }
    </script>
</body>
</html>
