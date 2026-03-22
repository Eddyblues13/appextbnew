@include('layouts.header')

<div class="content-wrapper">
    <div class="breadcrumb-wrap bg-spring">
        <img src="{{ asset('asset/img/breadcrumb/br-shape-1.png') }}" alt="Image" class="br-shape-one bounce">
        <img src="{{ asset('asset/img/breadcrumb/br-shape-2.png') }}" alt="Image" class="br-shape-two moveHorizontal">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-8">
                    <div class="breadcrumb-title">
                        <h2>Register</h2>
                        <ul class="breadcrumb-menu list-style">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>Register</li>
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
                <div class="col-lg-8">
                    <div class="login-form-wrap"
                        style="background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                        <div class="login-header text-center mb-4">
                            <h3>Create an Account</h3>
                            <p>Complete your enrollment to get started</p>
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

                        <form class="login-form" action="{{ route('user.register') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px;">Name</label>
                                        <input type="text" name="name" class="form-control" required
                                            placeholder="Enter Full Name" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px;">Email</label>
                                        <input type="email" name="email" class="form-control" required
                                            placeholder="Enter Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px;">Phone</label>
                                        <input type="text" name="phone" class="form-control"
                                            placeholder="Enter Phone Number" value="{{ old('phone') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px;">Country</label>
                                        <input type="text" name="country" class="form-control"
                                            placeholder="Enter Country" value="{{ old('country') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px;">City</label>
                                        <input type="text" name="city" class="form-control" placeholder="Enter City"
                                            value="{{ old('city') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label style="font-weight: 600; margin-bottom: 8px;">Account Currency</label>
                                        <select name="currency" class="form-control" required>
                                            <option value="">Select Currency</option>
                                            <!-- Major Currencies -->
                                            <option value="$">US Dollar (USD)</option>
                                            <option value="€">Euro (EUR)</option>
                                            <option value="£">Pound Sterling (GBP)</option>
                                            <option value="¥">Japanese Yen (JPY)</option>
                                            <option value="CHF">Swiss Franc (CHF)</option>
                                            <option value="C$">Canadian Dollar (CAD)</option>
                                            <option value="A$">Australian Dollar (AUD)</option>
                                            <option value="NZ$">New Zealand Dollar (NZD)</option>
                                            <!-- Asian Currencies -->
                                            <option value="¥">Chinese Yuan (CNY)</option>
                                            <option value="₹">Indian Rupee (INR)</option>
                                            <option value="₩">South Korean Won (KRW)</option>
                                            <option value="HK$">Hong Kong Dollar (HKD)</option>
                                            <option value="SG$">Singapore Dollar (SGD)</option>
                                            <option value="NT$">Taiwan Dollar (TWD)</option>
                                            <option value="₱">Philippine Peso (PHP)</option>
                                            <option value="฿">Thai Baht (THB)</option>
                                            <option value="Rp">Indonesian Rupiah (IDR)</option>
                                            <option value="RM">Malaysian Ringgit (MYR)</option>
                                            <option value="₫">Vietnamese Dong (VND)</option>
                                            <option value="৳">Bangladeshi Taka (BDT)</option>
                                            <option value="₨">Pakistani Rupee (PKR)</option>
                                            <option value="₨">Sri Lankan Rupee (LKR)</option>
                                            <!-- European Currencies -->
                                            <option value="kr">Swedish Krona (SEK)</option>
                                            <option value="kr">Norwegian Krone (NOK)</option>
                                            <option value="kr">Danish Krone (DKK)</option>
                                            <option value="zł">Polish Zloty (PLN)</option>
                                            <option value="Kč">Czech Koruna (CZK)</option>
                                            <option value="Ft">Hungarian Forint (HUF)</option>
                                            <option value="lei">Romanian Leu (RON)</option>
                                            <option value="лв">Bulgarian Lev (BGN)</option>
                                            <option value="kn">Croatian Kuna (HRK)</option>
                                            <option value="₽">Russian Ruble (RUB)</option>
                                            <option value="₺">Turkish Lira (TRY)</option>
                                            <option value="₴">Ukrainian Hryvnia (UAH)</option>
                                            <!-- Middle Eastern Currencies -->
                                            <option value="د.إ">UAE Dirham (AED)</option>
                                            <option value="﷼">Saudi Riyal (SAR)</option>
                                            <option value="﷼">Qatari Riyal (QAR)</option>
                                            <option value="د.ك">Kuwaiti Dinar (KWD)</option>
                                            <option value="د.ب">Bahraini Dinar (BHD)</option>
                                            <option value="﷼">Omani Rial (OMR)</option>
                                            <option value="ع.د">Iraqi Dinar (IQD)</option>
                                            <option value="₪">Israeli Shekel (ILS)</option>
                                            <option value="ج.م">Egyptian Pound (EGP)</option>
                                            <option value="د.ج">Algerian Dinar (DZD)</option>
                                            <option value="د.م.">Moroccan Dirham (MAD)</option>
                                            <option value="د.ت">Tunisian Dinar (TND)</option>
                                            <!-- African Currencies -->
                                            <option value="₦">Nigerian Naira (NGN)</option>
                                            <option value="ZAR">South African Rand (ZAR)</option>
                                            <option value="KSh">Kenyan Shilling (KES)</option>
                                            <option value="GH₵">Ghanaian Cedi (GHS)</option>
                                            <option value="USh">Ugandan Shilling (UGX)</option>
                                            <option value="TSh">Tanzanian Shilling (TZS)</option>
                                            <option value="ETB">Ethiopian Birr (ETB)</option>
                                            <option value="CFA">West African CFA Franc (XOF)</option>
                                            <option value="CFA">Central African CFA Franc (XAF)</option>
                                            <option value="E£">Egyptian Pound (EGP)</option>
                                            <option value="RF">Rwandan Franc (RWF)</option>
                                            <!-- Americas Currencies -->
                                            <option value="R$">Brazilian Real (BRL)</option>
                                            <option value="MX$">Mexican Peso (MXN)</option>
                                            <option value="AR$">Argentine Peso (ARS)</option>
                                            <option value="COP$">Colombian Peso (COP)</option>
                                            <option value="S/.">Peruvian Sol (PEN)</option>
                                            <option value="CLP$">Chilean Peso (CLP)</option>
                                            <option value="$U">Uruguayan Peso (UYU)</option>
                                            <option value="Bs">Venezuelan Bolivar (VES)</option>
                                            <option value="RD$">Dominican Peso (DOP)</option>
                                            <option value="J$">Jamaican Dollar (JMD)</option>
                                            <option value="TT$">Trinidad & Tobago Dollar (TTD)</option>
                                            <!-- Cryptocurrency -->
                                            <option value="₿">Bitcoin (BTC)</option>
                                            <option value="Ξ">Ethereum (ETH)</option>
                                            <option value="USDT">Tether (USDT)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3 position-relative">
                                        <label style="font-weight: 600; margin-bottom: 8px;">Password</label>
                                        <input type="password" name="password" id="reg-password" class="form-control"
                                            required placeholder="Enter Password" style="padding-right: 40px;">
                                        <span toggle="#reg-password" class="toggle-password"
                                            style="position: absolute; right: 15px; top: 38px; cursor: pointer; color: #666; font-size: 18px;">
                                            <i class="ri-eye-off-line"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3 position-relative">
                                        <label style="font-weight: 600; margin-bottom: 8px;">Repeat Password</label>
                                        <input type="password" name="password_confirmation" id="reg-password-confirm"
                                            class="form-control" required placeholder="Confirm Password"
                                            style="padding-right: 40px;">
                                        <span toggle="#reg-password-confirm" class="toggle-password"
                                            style="position: absolute; right: 15px; top: 38px; cursor: pointer; color: #666; font-size: 18px;">
                                            <i class="ri-eye-off-line"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn style1 w-100 d-block mt-3">Register</button>
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <p class="mb-0">Already have an account? <a href="{{ route('login') }}"
                                            class="link style1" style="color: #3037ff; font-weight: 600;">Login</a></p>
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