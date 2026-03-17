@include('user.header')
<!-- App Capsule -->
<div id="appCapsule">
    <div class="section full bg-primary">
        <!-- carousel single -->
        <div class="carousel-single splide p-2">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide">
                        <!-- card block -->
                        <div class="card-block bg-transparent border border-info">
                            <div class="card-main">
                                <div class="balance"> <span class="label">SAVINGS</span>
                                    <h1 class="title">
                                        {{ Auth::user()->currency }}{{ number_format($savings_balance, 2) }} </h1>
                                </div>
                                <div class="in">
                                    <div class="card-number"> <span class="label">Account Number</span>
                                        {{Auth::user()->account_number }}
                                    </div>
                                    <div class="bottom">
                                        <div class="card-expiry">
                                            <span class="label">Total Credit <br> {{ $currentMonth }}</span>
                                            {{ Auth::user()->currency }}{{ number_format($totalSavingsCredit, 2) }}
                                        </div>
                                        <div class="card-ccv">
                                            <span class="label">Total Debit<br> {{ $currentMonth }}</span>
                                            {{ Auth::user()->currency }}{{ number_format($totalSavingsDebit, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- * card block -->
                    </li>
                    <li class="splide__slide">
                        <!-- card block -->
                        <div class="card-block bg-transparent border border-light">
                            <div class="card-main">
                                <div class="balance"> <span class="label">CHECKINGS</span>
                                    <h1 class="title">
                                        {{ Auth::user()->currency }}{{ number_format($checking_balance, 2) }} </h1>
                                </div>
                                <div class="in">
                                    <div class="card-number"> <span class="label">Account Number</span>
                                        {{Auth::user()->account_number }}
                                    </div>
                                    <div class="bottom">
                                        <div class="card-expiry">
                                            <span class="label">Total Credit <br> {{ $currentMonth }}</span>
                                            {{ Auth::user()->currency }}{{ number_format($totalCheckingCredit, 2) }}
                                        </div>
                                        <div class="card-ccv">
                                            <span class="label">Total Debit<br> {{ $currentMonth }}</span>
                                            {{ Auth::user()->currency }}{{ number_format($totalCheckingDebit, 2) }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- * card block -->
                    </li>
                </ul>
            </div>
        </div>
        <!-- * carousel single -->
    </div>

    <div class="card">
        <div class="row">

            <div class="col-lg-8">
                <div class="section wallet-card-section mb-1">
                    <div class="wallet-card">
                        <h5 class="bg-danger p-2 text-white">
                            <i class="fas fa-exclamation-triangle"></i> Authorization Required
                        </h5>
                        <hr>
                        <h5 class="modal-title text-danger">
                            <i class="fas fa-lock"></i> Please enter your IMF Code to authorize this withdrawal. Contact support if you do not have your code.
                        </h5>
                        <hr>
                        <form method="POST" action="{{ route('transfer.confirmImf') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group basic">
                                        <label class="label text-danger font-weight-bold"><i class="fas fa-key"></i> IMF Code</label>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text text-danger"><i class="fas fa-key"></i></span>
                                            <input type="text" name="imf_code" class="form-control border-danger" placeholder="Enter IMF Code" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group basic">
                                        <input type="submit" name="submit_imf" value="Proceed" class="btn btn-primary btn-block">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <script>
                            @if(session('success'))
                                toastr.success("{{ session('success') }}");
                            @endif
                        
                            @if(session('error'))
                                toastr.error("{{ session('error') }}");
                            @endif
                        
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    toastr.error("{{ $error }}");
                                @endforeach
                            @endif
                        </script>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="section wallet-card-section mb-1">
                    <div class="wallet-card" id="cards">
                        <h5 class="text-primary">
                            First&nbsp;Cards
                        </h5>
                        <hr>

                        <div class="wrapper">
                            <div class="credit-card-wrap">
                                <div class="credit-card-inner">
                                    <img src="https://appextb.com/uploads/logo.png" class="pull-right sitelogo">
                                    <div class="mk-icon-sim"></div>
                                    <div class="credit-font credit-card-number" data-text="">4716 XXXX XXXX
                                        7554 </div>
                                    <br>
                                    <footer class="footer">
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <div class="credit-card-date"><span class="title">VALID
                                                        THRU</span>
                                                    <span class="credit-font">
                                                        02/28 </span>
                                                </div>
                                                <div class="credit-font credit-author">
                                                    {{Auth::user()->name}} </div>
                                            </div>
                                            <div class="pull-right">
                                                <div class="mk-icon-visa"></div>
                                            </div>
                                        </div>
                                    </footer>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('user.footer')
