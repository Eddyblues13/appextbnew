@include('layouts.header')
<div class="content-wrapper">
    <div class="breadcrumb-wrap bg-spring">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-8">
                    <div class="breadcrumb-title">
                        <h2>500 - Server Error</h2>
                        <ul class="breadcrumb-menu list-style">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>500</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div style="padding: 60px 30px; background: #fff; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                        <h1 style="font-size: 100px; color: #c92041; font-weight: 700; margin-bottom: 10px;">500</h1>
                        <h3 style="margin-bottom: 15px;">Internal Server Error</h3>
                        <p style="color: #666; margin-bottom: 30px;">Something went wrong on our end. Please try again later.</p>
                        <a href="{{ url('/') }}" class="btn style1">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('layouts.footer')
