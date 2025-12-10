<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clinical Pathway</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: #1B3C53;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Elements */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(69, 104, 130, 0.15);
            border-radius: 50%;
            top: -200px;
            left: -200px;
            animation: float 20s infinite ease-in-out;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(35, 76, 106, 0.15);
            border-radius: 50%;
            bottom: -150px;
            right: -150px;
            animation: float 15s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-30px) translateX(30px);
            }
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 1;
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
            animation: slideDown 0.6s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-box {
            width: 80px;
            height: 80px;
            background: #456882;
            background-image: url('/image/logorsb.jpg');
            background-size: cover;
            background-position: center;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .login-header h1 {
            color: #E3E3E3;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .login-header p {
            color: rgba(227, 227, 227, 0.9);
            font-size: 16px;
        }

        .login-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            color: #1B3C53;
            margin-bottom: 24px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control:focus {
            outline: none;
            border-color: #456882;
            background: white;
            box-shadow: 0 0 0 4px rgba(69, 104, 130, 0.1);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #234C6A;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(35, 76, 106, 0.4);
        }

        .btn-login:hover {
            background: #456882;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(69, 104, 130, 0.5);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-top: 20px;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border: 2px solid #ef4444;
            color: #991b1b;
            font-weight: 500;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #9ca3af;
            margin: 24px 0;
            font-size: 14px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e5e7eb;
        }

        .divider span {
            padding: 0 16px;
        }

        .login-footer {
            text-align: center;
            margin-top: 24px;
            color: #E3E3E3;
            font-size: 14px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            user-select: none;
            color: #456882;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 24px;
            }

            .login-header h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <div class="logo-box"></div>
            <h1>Clinical Pathway</h1>
            <p>Management System</p>
        </div>

        <!-- Login Card -->
        <div class="login-card">
            <h2 class="card-title">Selamat Datang</h2>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input  
                        type="email" 
                        id="email"
                        name="email" 
                        class="form-control" 
                        placeholder="name@example.com"
                        value="{{ old('email') }}"
                        required 
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-toggle">
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            class="form-control" 
                            placeholder="Masukkan password Anda"
                            required
                        >
                        <span class="toggle-password" onclick="togglePassword()">👁</span>
                    </div>
                </div>

                <button class="btn-login" type="submit">
                    Login Sekarang
                </button>
            </form>
        </div>

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="alert alert-danger">
                ⚠️ {{ $errors->first() }}
            </div>
        @endif

        <!-- Footer -->
        <div class="login-footer">
            <p>© {{ date('Y') }} Clinical Pathway Management System</p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '👁';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁';
            }
        }

        // Add enter key support
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>