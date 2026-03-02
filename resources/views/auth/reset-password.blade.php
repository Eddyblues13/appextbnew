@include('layouts.header')

<div class="content-wrapper">
    <div class="breadcrumb-wrap bg-spring">
        <img src="{{ asset('asset/img/breadcrumb/br-shape-1.png') }}" alt="Image" class="br-shape-one bounce">
        <img src="{{ asset('asset/img/breadcrumb/br-shape-2.png') }}" alt="Image" class="br-shape-two moveHorizontal">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-8">
                    <div class="breadcrumb-title">
                        <h2>Reset Password</h2>
                        <ul class="breadcrumb-menu list-style">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>Reset Password</li>
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
                            <h3>Set New Password</h3>
                            <p>Enter your new password below.</p>
                        </div>

                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="email" style="font-weight: 600; margin-bottom: 8px;">Email Address</label>
                                        <input type="email" name="email" id="email" class="form-control" required placeholder="Enter your email" value="{{ $email ?? old('email') }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3 position-relative">
                                        <label for="password" style="font-weight: 600; margin-bottom: 8px;">New Password</label>
                                        <input type="password" name="password" id="password" class="form-control" required placeholder="Enter new password" style="padding-right: 40px;">
                                        <span toggle="#password" class="toggle-password" style="position: absolute; right: 15px; top: 38px; cursor: pointer; color: #666; font-size: 18px;">
                                            <i class="ri-eye-off-line"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3 position-relative">
                                        <label for="password_confirmation" style="font-weight: 600; margin-bottom: 8px;">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Confirm new password" style="padding-right: 40px;">
                                        <span toggle="#password_confirmation" class="toggle-password" style="position: absolute; right: 15px; top: 38px; cursor: pointer; color: #666; font-size: 18px;">
                                            <i class="ri-eye-off-line"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn style1 w-100 d-block">Reset Password</button>
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
