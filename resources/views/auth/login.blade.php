    @extends('layouts.app')

    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white text-center py-4 border-0">
                        <h4 class="text-primary fw-bold mb-2">
                            <i class="fas fa-hospital me-2"></i>Sistem Klinik
                        </h4>
                        <p class="text-muted mb-0">Masuk ke akun Anda</p>
                    </div>

                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Input -->
                            <div class="mb-4">
                                <label for="email" class="form-label text-dark">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input id="email" type="email" 
                                        class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                        name="email" value="{{ old('email') }}" 
                                        placeholder="email@example.com" required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="mb-4">
                                <label for="password" class="form-label text-dark">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input id="password" type="password" 
                                        class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                        name="password" 
                                        placeholder="Masukkan password" required autocomplete="current-password">
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" 
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                            </div>

                            <!-- Login Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary py-2 fw-semibold">
                                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                </button>
                            </div>

                            <!-- Forgot Password -->
                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a class="text-decoration-none text-muted small" href="{{ route('password.request') }}">
                                        Lupa password?
                                    </a>
                                </div>
                            @endif
                        </form>

                        <!-- Demo Credentials -->
                        <div class="mt-5 pt-4 border-top">
                            <div class="bg-light rounded p-3">
                                <h6 class="text-dark mb-2 small fw-semibold">Akun Demo:</h6>
                                <div class="small text-muted">
                                    <div class="mb-1">
                                        <span class="text-primary">•</span> Admin: admin@klinik.com / password
                                    </div>
                                    <div class="mb-1">
                                        <span class="text-primary">•</span> Dokter: dokter@klinik.com / password
                                    </div>
                                    <div class="mb-1">
                                        <span class="text-primary">•</span> Perawat: perawat@klinik.com / password
                                    </div>
                                    <div>
                                        <span class="text-primary">•</span> Registrasi: registrasi@klinik.com / password
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .card {
        border-radius: 12px;
    }
    .card-header {
        background: transparent !important;
    }
    .form-control {
        padding: 10px 12px;
        border-radius: 0 8px 8px 0;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.1);
    }
    .input-group-text {
        border-radius: 8px 0 0 8px;
    }
    .btn-primary {
        border-radius: 8px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
    }
    </style>
    @endsection