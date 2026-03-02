@include('admin.header')
<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            <div class="mt-2 mb-4">
                <h1 class="title1 text-dark">Admin Settings</h1>
            </div>

            @if(session('message'))
            <div class="alert alert-success mb-3">{{ session('message') }}</div>
            @endif

            <div class="row">
                <!-- Profile Settings -->
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h4 class="card-title mb-0"><i class="fas fa-user-cog mr-2"></i>Profile Settings</h4>
                        </div>
                        <div class="card-body bg-light">
                            <div id="profileAlert"></div>
                            <form id="profileForm">
                                @csrf
                                <div class="form-group">
                                    <label class="text-dark font-weight-bold">Name</label>
                                    <input type="text" name="firstname" class="form-control bg-white text-dark"
                                        value="{{ Auth::guard('admin')->user()->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="text-dark font-weight-bold">Email</label>
                                    <input type="email" name="email" class="form-control bg-white text-dark"
                                        value="{{ Auth::guard('admin')->user()->email }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="text-dark font-weight-bold">Phone</label>
                                    <input type="text" name="phone" class="form-control bg-white text-dark"
                                        value="" placeholder="Enter phone number">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save mr-1"></i> Update Profile
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-danger text-white">
                            <h4 class="card-title mb-0"><i class="fas fa-lock mr-2"></i>Change Password</h4>
                        </div>
                        <div class="card-body bg-light">
                            <div id="passwordAlert"></div>
                            <form id="passwordForm">
                                @csrf
                                <div class="form-group">
                                    <label class="text-dark font-weight-bold">Current Password</label>
                                    <div style="position: relative;">
                                        <input type="password" name="old_password" id="old_password"
                                            class="form-control bg-white text-dark" required placeholder="Enter current password"
                                            style="padding-right: 40px;">
                                        <span class="toggle-pwd" data-target="old_password"
                                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:#666;">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="text-dark font-weight-bold">New Password</label>
                                    <div style="position: relative;">
                                        <input type="password" name="new_password" id="new_password"
                                            class="form-control bg-white text-dark" required placeholder="Enter new password"
                                            style="padding-right: 40px;">
                                        <span class="toggle-pwd" data-target="new_password"
                                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:#666;">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="text-dark font-weight-bold">Confirm New Password</label>
                                    <div style="position: relative;">
                                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                            class="form-control bg-white text-dark" required placeholder="Confirm new password"
                                            style="padding-right: 40px;">
                                        <span class="toggle-pwd" data-target="new_password_confirmation"
                                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:#666;">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="fas fa-key mr-1"></i> Change Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Password toggle
    document.querySelectorAll('.toggle-pwd').forEach(function(el) {
        el.addEventListener('click', function() {
            var target = document.getElementById(this.getAttribute('data-target'));
            var icon = this.querySelector('i');
            if (target.type === 'password') {
                target.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                target.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });

    // Profile update via AJAX
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch("{{ route('admin.profile.update') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            var alertDiv = document.getElementById('profileAlert');
            if (data.status === 'success') {
                alertDiv.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
            } else {
                alertDiv.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
            }
        })
        .catch(() => {
            document.getElementById('profileAlert').innerHTML = '<div class="alert alert-danger">Something went wrong.</div>';
        });
    });

    // Password update via AJAX
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch("{{ route('admin.profile.password.update') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            var alertDiv = document.getElementById('passwordAlert');
            if (data.status === 'success') {
                alertDiv.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                document.getElementById('passwordForm').reset();
            } else {
                alertDiv.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
            }
        })
        .catch(() => {
            document.getElementById('passwordAlert').innerHTML = '<div class="alert alert-danger">Something went wrong.</div>';
        });
    });
</script>

@include('admin.footer')
