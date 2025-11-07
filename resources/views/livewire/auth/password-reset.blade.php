<div>
    <div class="section auth-bg" wire:ignore.self>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card auth-cont">
                        <div class="card-body px-4">
                            {{--
                            <div class="d-grid mt-3">
                                <div class="btn-group">
                                    <a href="{{ url('auth/login') }}" class="btn btn-auth">Login</a>
                                    <a href="{{ url('auth/register') }}" class="btn btn-auth">Register</a>
                                </div>
                            </div>
                            --}}
                            <div class="row">
                                <div class="col-md-12 text-center mt-4">
                                    <h4 class="page-title">Reset Password</h4>
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
                            @if (session()->has('message'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                </div>
                            </div>
                            @endif
                            <form wire:submit="updatePass">
                                <div class="mb-4">
                                    <input type="email" class="form-control" placeholder="Email" name="email" wire:model.defer="email">
                                </div>
                                <div class="mb-4">
                                    <div class="password-wrapper">
                                        <input type="password" class="form-control" placeholder="New Password" id="password" name="password" wire:model.defer="password">
                                        <span id="togglePassword" class="toggle-icon"><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-5">
                                    <div class="col-md-12 text-center">
                                        <input type="submit" class="btn btn-primary-outline w-wide" wire:click.prevent="updatePass" value="Update Password">
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
