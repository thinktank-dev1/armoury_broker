<div>
    <div class="section auth-bg" wire:ignore.self>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card auth-cont">
                        <div class="card-body px-4">
                            <div class="d-grid mt-3">
                                <div class="btn-group">
                                    <a href="{{ url('auth/login') }}" class="btn btn-auth =">Login</a>
                                    <a href="{{ url('auth/register') }}" class="btn btn-auth active">Register</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-4">
                                    <h4 class="page-title">Welcome</h4>
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
                            <form wire:submit="RegisterUser">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <input type="text" class="form-control" placeholder="Name" name="name" wire:model.defer="name">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <input type="text" class="form-control" placeholder="Surname" name="surname" wire:model.defer="surname">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" placeholder="Mobile Number" name="mobile_number" wire:model.defer="mobile_number">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" placeholder="Email" name="email" wire:model.defer="email">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="password-wrapper">
                                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" wire:model.defer="password">
                                                    <span id="togglePassword" class="toggle-icon"><i class="fa fa-eye"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="terms_check_box" wire:model.defer="terms_and_condotions">
                                                    <label class="form-check-label" for="terms_check_box" style="color: #000">
                                                        I accept the <a href="{{ url('docs/Terms of Use and User Agreement_AB_Courier amendments_v02_20250629.pdf') }}" style="font-weight: 600;" target="_blank">Terms & Conditions</a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12 text-center">
                                        <p style="color: #000; font-weight: 600"><a href="{{ url('auth/login') }}">Already have an account? Login</a></p>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-12 text-center">
                                        <input type="submit" class="btn btn-primary-outline w-wide" wire:click.prevent="RegisterUser" value="Register">
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
