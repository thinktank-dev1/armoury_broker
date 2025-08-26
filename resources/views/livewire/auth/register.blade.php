<div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
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
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Name" name="name" wire:model.defer="name">
                                            </div>
                                            <div class="col-md-6">
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
                                                <input type="password" class="form-control" placeholder="Password" name="password" wire:model.defer="password">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="terms_check_box" wire:model.defer="terms_and_condotions">
                                                    <label class="form-check-label" for="terms_check_box">
                                                        I Accept The <a href="{{ url('terms-and-conditions') }}">Terms & Conditions</a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12 text-center">
                                        <p><a href="{{ url('auth/login') }}">Already have an account? Login</a></p>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-12 text-center">
                                        <input type="submit" class="btn btn-secondary w-wide" wire:click.prevent="RegisterUser" value="Register">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
