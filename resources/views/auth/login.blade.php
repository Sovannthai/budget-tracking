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
        <img src="{{ asset('uploads/images/bg-login.png') }}" alt="login image" class="login__img">

        <form method="POST" action="{{ route('login') }}" class="container">
            @csrf
            <h1 class="login__title">Login</h1>

            <div class="login__content">
                <div class="login__box">
                    <i class="ri-user-3-line login__icon"></i>

                    <div class="login__box-input">
                        <input type="email" required class="login__input @error('email') is-invalid @enderror" 
                               id="login-email" name="email" value="{{ old('email') }}" placeholder=" ">
                        <label for="login-email" class="login__label">Email</label>
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
                               id="login-pass" name="password" placeholder=" ">
                        <label for="login-pass" class="login__label">Password</label>
                        <i class="ri-eye-off-line login__eye" id="login-eye"></i>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="login__check">
                <div class="login__check-group">
                    <input type="checkbox" class="login__check-input" id="login-check" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="login-check" class="login__check-label">Remember me</label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="login__forgot">Forgot Password?</a>
                @endif
            </div>

            <button type="submit" class="login__button">Login</button>

            <p class="login__register">
                Don't have an account? <a href="{{ route('register') }}">Register</a>
            </p>
        </form>
    </div>

    <script>
        const loginEye = document.querySelector('.login__eye'); 
        const loginPass = document.querySelector('#login-pass');

        loginEye.addEventListener('click', function () {
            const type = loginPass.getAttribute('type') === 'password' ? 'text' : 'password';
            loginPass.setAttribute('type', type);
            this.classList.toggle('ri-eye-line');
            this.classList.toggle('ri-eye-off-line');
        });
    </script>
</body>

</html>
