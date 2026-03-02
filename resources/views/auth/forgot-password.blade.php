@include('layouts.header')

<div class="content-wrapper">
    <div class="breadcrumb-wrap bg-spring">
        <img src="{{ asset('asset/img/breadcrumb/br-shape-1.png') }}" alt="Image" class="br-shape-one bounce">
        <img src="{{ asset('asset/img/breadcrumb/br-shape-2.png') }}" alt="Image" class="br-shape-two moveHorizontal">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-8">
                    <div class="breadcrumb-title">
                        <h2>Forgot Password</h2>
                        <ul class="breadcrumb-menu list-style">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>Forgot Password</li>
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
                            <h3>Reset Your Password</h3>
                            <p>Enter your email address and we'll send you a link to reset your password.</p>
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

                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="email" style="font-weight: 600; margin-bottom: 8px;">Email Address</label>
                                        <input type="email" name="email" id="email" class="form-control" required placeholder="Enter your registered email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn style1 w-100 d-block">Send Reset Link</button>
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <p class="mb-0">Remember your password? <a href="{{ route('login') }}" class="link style1" style="color: #3037ff; font-weight: 600;">Login</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('layouts.footer')
