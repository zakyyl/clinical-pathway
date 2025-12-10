<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clinical Pathway Management System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', system-ui, -apple-system, sans-serif;
            background: #1B3C53;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #E3E3E3;
            padding: 20px;
        }

        .container {
            text-align: center;
            max-width: 600px;
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            width: 120px;
            height: 120px;
            background-image: url('{{ asset('image/logorsb.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 24px;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }


        h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #E3E3E3;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .subtitle {
            font-size: 1.25rem;
            color: rgba(227, 227, 227, 0.8);
            margin-bottom: 3rem;
            line-height: 1.5;
        }

        .btn-login {
            display: inline-block;
            padding: 1rem 3rem;
            background: #456882;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-size: 1.125rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(69, 104, 130, 0.3);
        }

        .btn-login:hover {
            background: #234C6A;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(69, 104, 130, 0.4);
        }

        .footer {
            margin-top: 4rem;
            font-size: 0.875rem;
            color: rgba(227, 227, 227, 0.5);
        }

        @media (max-width: 768px) {
            .logo {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }

            h1 {
                font-size: 2rem;
            }

            .subtitle {
                font-size: 1.125rem;
            }

            .btn-login {
                padding: 0.875rem 2.5rem;
                font-size: 1rem;
            }
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="logo"></div>
        <h1>Clinical Pathway</h1>
        <p class="subtitle">Management System</p>
        <a href="{{ route('login') }}" class="btn-login">Login</a>
        <div class="footer">
            © {{ date('Y') }} Clinical Pathway Management System
        </div>
    </div>
</body>
</html>