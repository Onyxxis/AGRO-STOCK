<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Agro</title>
    <style>
         body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .left-side {
            flex: 2;
            background: url('{{ asset("left5.jfif") }}') no-repeat center center/cover;
        }
        .right-side {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #F4F4F4FF;
        }
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
        }
        .logo {
            width: 65px;
            margin-right: 8px;
        }
        .logo-text {
            font-size: 32px;
            font-weight: bold;
            color: #4CAF50;
        }
        .login-form {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
            text-align: center;
            width: 100%;
            max-width: 400px;
            position: relative;
        }
        .login-form::before {
            content: '';
            background: url('{{ asset("blé.png") }}') no-repeat center center/cover;
            opacity: 0.1;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
        }
        .logo {
            width: 100px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }
        .form-group input:focus {
            border-color: #4CAF50;
            background-color: #fff;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }
        .btn-login:hover {
            background-color: #39863DFF;
        }
        .social-login {
            margin-top: 20px;
        }
        .social-login button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: white;
            cursor: pointer;
        }
        .social-login button:hover {
            background-color: #E2FCDCFF;
        }
        .signup-link {
            margin-top: 20px;
        }
        .signup-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .signup-link a:hover {
            text-decoration: underline;
        }

        #loading-screen {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(255, 255, 255,0.97);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            }

            #loading-video {
                width: 200px;
                height: 200px;
            }

            #main-content {
                display: none;
            }
    </style>
</head>
<body>
    <div id="loading-screen">
        <video id="loading-video" autoplay loop muted>
            <source src="{{ asset('loading.mp4') }}" type="video/mp4" />
        </video>
    </div>
    <div class="left-side"></div>
    <div class="right-side">
        <div class="login-form">
            <div class="logo-container">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
                <span class="logo-text">Agro Stock</span>
            </div>
            <h1>CONNEXION</h1><br>

            <!-- 🔐 Formulaire Laravel Breeze avec Blade -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus>
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="remember">
                        <span>Se souvenir de moi</span>
                    </label>
                </div>

                <button type="submit" class="btn-login">Se connecter</button>

                @if (Route::has('password.request'))
                    <div class="signup-link mt-4">
                        <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                    </div>
                @endif
            </form>

            <hr>

            <div class="social-login">
                <button type="button">Se connecter avec Google</button>
                <button type="button">Autre méthode</button>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener("load", function () {
            const loadingScreen = document.getElementById("loading-screen");
            const mainContent = document.getElementById("main-content");

            setTimeout(() => {
                loadingScreen.style.display = "none";
                if (mainContent) mainContent.style.display = "block";
            }, 2000);
        });
    </script>
</body>
</html>
