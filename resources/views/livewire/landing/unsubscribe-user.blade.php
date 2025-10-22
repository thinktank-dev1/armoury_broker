<div>
    <div class="section auth-bg" wire:ignore.self>
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card auth-cont">
                        <div class="card-body px-4">
                            <div class="row">
                                <div class="col-md-12 text-center mt-4 mb-3 pt-3">
                                    <h4 class="page-title">Unsubscribe</h4>
                                </div>
                            </div>
                            @if($errors->any())
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        {{ $errors->first() }}
                                    </div>
                                </div>
                            </div>
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
                                    <b>Are you sure you want to unsubscribe?</b>
                                    <p>You’ll stop receiving all future newsletters, marketing, and special offers from us. You will, however continue to receive important platform emails.</p>
                                </div>
                                <div class="col-md-12 mb-5 text-center">
                                    <a href="{{ url('/') }}" class="bnt btn btn-primary-outline">Stay Subscribed</a>
                                    <a href="" class="btn btn-secondary" wire:click.prevent="do_unsubscribe">Yes, Unsubscribe Me</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
