<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="login">
        <img src="https://i.postimg.cc/MGfsBfGv/login-bg.png" alt="login image" class="login__img">

        <form method="POST" action="{{ route('register') }}" class="container">
            @csrf
            <h1 class="login__title">Register</h1>

            <div class="login__content">
                <div class="login__box">
                    <i class="ri-user-3-line login__icon"></i>

                    <div class="login__box-input">
                        <input type="text" required class="login__input @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" placeholder=" ">
                        <label for="name" class="login__label">Name</label>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="login__box">
                    <i class="ri-mail-line login__icon"></i>

                    <div class="login__box-input">
                        <input type="email" required class="login__input @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" placeholder=" ">
                        <label for="email" class="login__label">Email</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="login__box">
                    <i class="ri-lock-2-line login__icon"></i>

                    <div class="login__box-input">
                        <input type="password" required class="login__input @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder=" ">
                        <label for="password" class="login__label">Password</label>
                        <i class="ri-eye-off-line login__eye" id="password-eye"></i>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="login__box">
                    <i class="ri-lock-2-line login__icon"></i>

                    <div class="login__box-input">
                        <input type="password" required class="login__input" 
                               id="password-confirm" name="password_confirmation" placeholder=" ">
                        <label for="password-confirm" class="login__label">Confirm Password</label>
                        <i class="ri-eye-off-line login__eye" id="password-confirm-eye"></i>
                    </div>
                </div>
            </div>

            <button type="submit" class="login__button">Register</button>

            <p class="login__register">
                Already have an account? <a href="{{ route('login') }}">Login</a>
            </p>
        </form>
    </div>

    <script>
        const passwordEye = document.querySelector('#password-eye');
        const password = document.querySelector('#password');
        const passwordConfirmEye = document.querySelector('#password-confirm-eye');
        const passwordConfirm = document.querySelector('#password-confirm');

        passwordEye.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('ri-eye-line');
            this.classList.toggle('ri-eye-off-line');
        });

        passwordConfirmEye.addEventListener('click', function () {
            const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirm.setAttribute('type', type);
            this.classList.toggle('ri-eye-line');
            this.classList.toggle('ri-eye-off-line');
        });
    </script>
</body>
</html>
