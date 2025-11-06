<div>
    <div class="section auth-bg" wire:ignore.self>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card auth-cont">
                        <div class="card-body px-4">
                            <div class="d-grid mt-3">
                                <div class="btn-group">
                                    <a href="{{ url('auth/login') }}" class="btn btn-auth active">Login</a>
                                    <a href="{{ url('auth/register') }}" class="btn btn-auth">Register</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-4">
                                    <h4 class="page-title">Welcome back</h4>
                                </div>
                            </div>
                            @if($errors->any())
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        {{ $errors->first() }}
                                    </div>
                                </div>
                            </div>
                            @endif
                            <form wire:submit="logInUser">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="mb-4">
                                            <input type="text" class="form-control" placeholder="Email" name="email" wire:model.defer="email">
                                        </div>
                                        <div class="mb-3">
                                            <div class="password-wrapper">
                                                <input type="password" class="form-control" placeholder="Password" id="password" name="password" wire:model.defer="password">
                                                <span id="togglePassword" class="toggle-icon"><i class="fa fa-eye"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <p><a href="{{ url('auth/forgot-password') }}" style="font-weight: 600">Forgot Password?</a></p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 text-center">
                                        <input type="submit" class="btn btn-primary-outline w-wide" wire:click.prevent="logInUser" value="Login">
                                    </div>
                                </div>
                                <div class="row mt-5 mb-5">
                                    <div class="col-md-6 d-grid social-login-cont mb-3">
                                        <a href="{{ url('auth/social-login/google') }}" class="btn bt-white"><img src="{{ asset('img/auth-gl.png') }}" style="height: 20px;"> &nbsp;&nbsp;Continue With Google</a>
                                    </div>
                                    <div class="col-md-6 d-grid social-login-cont mb-3">
                                        <a href="{{ url('auth/social-login/facebook') }}" class="btn bt-white"><img src="{{ asset('img/auth-fb.png') }}" style="height: 25px;"> &nbsp;&nbsp;Continue With Facebook</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        const passwordInput = document.getElementById("password");
        const togglePassword = document.getElementById("togglePassword");

        togglePassword.addEventListener("click", () => {
            const isPassword = passwordInput.type === "password";
            passwordInput.type = isPassword ? "text" : "password";
            togglePassword.innerHTML = isPassword ? "<i class='fa fa-eye-slash'></i>" : "<i class='fa fa-eye'></i>";
        });
    </script>
    @endpush
</div>
