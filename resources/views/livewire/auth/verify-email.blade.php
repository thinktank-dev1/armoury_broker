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
                                    <a href="{{ url('auth/register') }}" class="btn btn-auth">Register</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-4">
                                    <h4 class="page-title">Verify your Email</h4>
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
                            <div class="row mt-3 mb-3">
                                <div class="col-md-12 text-center">
                                    <b>Please check inbox for a email verification</b>
                                </div>
                                <div class="col-md-12 text-center mb-3">
                                    <p><a href="{{ url('auth/login') }}">Login</a></p>
                                </div>
                                <div class="col-md-12 mb-5 text-center">
                                    <a href="" class="bnt dark-btn" wire:click.prevent="ResendEmail">Resend Email</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
