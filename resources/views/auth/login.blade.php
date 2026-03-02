@include('layouts.header')

<div class="content-wrapper">
    <div class="breadcrumb-wrap bg-spring">
        <img src="{{ asset('asset/img/breadcrumb/br-shape-1.png') }}" alt="Image" class="br-shape-one bounce">
        <img src="{{ asset('asset/img/breadcrumb/br-shape-2.png') }}" alt="Image" class="br-shape-two moveHorizontal">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-8">
                    <div class="breadcrumb-title">
                        <h2>Login</h2>
                        <ul class="breadcrumb-menu list-style">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>Login</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 col-md-4">
                    <div class="breadcrumb-img">
                        <img src="{{ asset('asset/img/breadcrumb/breadcrumb-1.png') }}" alt="Image">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="login-wrap ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-form-wrap" style="background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                        <div class="login-header text-center mb-4">
                            <h3>Welcome Back</h3>
                            <p>Please login to your account</p>
                        </div>
                        
                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form class="login-form" action="{{ route('auth.login') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="login" style="font-weight: 600; margin-bottom: 8px;">Email or Account ID</label>
                                        <input type="text" name="login" id="login" class="form-control" required placeholder="Enter Email or ID" value="{{ old('login') }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3 position-relative">
                                        <label for="password" style="font-weight: 600; margin-bottom: 8px;">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" required placeholder="Enter Password" style="padding-right: 40px;">
                                        <span toggle="#password" class="toggle-password" style="position: absolute; right: 15px; top: 38px; cursor: pointer; color: #666; font-size: 18px;">
                                            <i class="ri-eye-off-line"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-condition mb-3 d-flex justify-content-between">
                                        <div class="agree-label">
                                            <input type="checkbox" id="chb1" name="remember">
                                            <label for="chb1">Remember Me</label>
                                        </div>
                                        <a href="{{ route('password.request') }}" class="forgot-btn" style="color: #c92041;">Forgot Password?</a>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn style1 w-100 d-block">Login</button>
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="link style1" style="color: #3037ff; font-weight: 600;">Register</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePasswords = document.querySelectorAll('.toggle-password');
        togglePasswords.forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const icon = this.querySelector('i');
                icon.classList.toggle('ri-eye-line');
                icon.classList.toggle('ri-eye-off-line');
                const input = document.querySelector(this.getAttribute('toggle'));
                if (input.getAttribute('type') === 'password') {
                    input.setAttribute('type', 'text');
                } else {
                    input.setAttribute('type', 'password');
                }
            });
        });
    });
</script>

@include('layouts.footer')
