<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Agro</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .left-side {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #F4F4F4FF;
        }
        .right-side {
            flex: 2;
            background: url('{{ asset("left4.jfif") }}') no-repeat center center/cover;
        }
        .login-form {
            background: white;
            padding: 40px;
            border-radius: 10px;
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
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
            left: 3;
            right: 0;
            bottom: 0;
            opacity: 15;
            z-index: -1;
        }
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .logo {
            width: 100px;
            margin-bottom: 20px;
        }
        .logo-text {
            font-size: 32px;
            font-weight: bold;
            color: #4CAF50;
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
            width: 93%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-register {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-register:hover {
            background-color: #39863DFF;
        }
        .login-link {
            margin-top: 20px;
        }
        .login-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }

        #loading-screen {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(255, 255, 255);
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

    <div class="left-side">
        <div class="login-form">
            <div class="logo-container">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
                <span class="logo-text">Agro Stock</span>
            </div>
            <h1>CRÉATION DE COMPTE</h1><br>
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmez le mot de passe</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn-register">S'inscrire</button>
                <div class="login-link">
                    <p>Déjà un compte ? <a href="/login">Connectez-vous</a></p>
                </div>
            </form>
        </div>
    </div>
    <div class="right-side"></div>


    <script>

        </script>

    <script>
            window.addEventListener("load", function () {
                const loadingScreen = document.getElementById("loading-screen");
                const mainContent = document.getElementById("main-content");

                setTimeout(() => {
                    loadingScreen.style.display = "none";
                    mainContent.style.display = "block";
                }, 2000);
            });
        </script>
</body>
</html>
