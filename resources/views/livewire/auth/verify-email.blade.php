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
                                    <a href="{{ url('auth/login') }}" class="btn btn-auth =">Login</a>
                                    <a href="{{ url('auth/register') }}" class="btn btn-auth">Register</a>
                                </div>
                            </div>
                            --}}
                            <div class="row">
                                <div class="col-md-12 text-center mt-4 mb-3 pt-3">
                                    <h4 class="page-title">Verify your Email</h4>
                                </div>
                            </div>
                            @if($errors->any())
                            @if (!$errors->has('email'))
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        {{ $errors->first() }}
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                            @if (session('status'))
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="alert alert-success text-center">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row mt-3 mb-3">
                                <div class="col-md-12 text-center mb-5">
                                    <b>We have sent a verification link to your email address.<br /><br /> Please check your inbox (and spam folder, just in case) and click the link to verify your account to log in.</b>
                                </div>
                                <div class="col-md-12 mb-4 text-center">
                                    <a href="" class="bnt btn-primary" wire:click.prevent="ResendEmail">Resend Email</a>
                                </div>
                                @if(!Auth::guest())
                                <div class="col-md-12 mb-5 text-center">
                                    <a href="#" style="font-weight: 600" data-bs-toggle="modal" data-bs-target="#edit-email-modal">Edit email address</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="edit-email-modal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Email Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <form wire:submit.prevent="editEmail">
                        <div class="mb-3">
                            <label class="form-label">Enter your email address</label>
                            <input type="email" class="form-control" name="email" wire:model.defer="email">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="editEmail">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal', (e) => {
                $('.modal').modal('hide');
            });
        });
    </script>
    @endpush
</div>
