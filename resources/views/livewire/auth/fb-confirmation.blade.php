<div>
    <div class="section auth-bg" wire:ignore.self>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card auth-cont">
                        <div class="card-body px-4">
                            <div class="row">
                                <div class="col-md-12 text-center mt-4">
                                    <h4 class="page-title">Confirmation of Data Removal</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    @if($status)
                                    <p>Your personal data has been successfully removed from our website in accordance with your request.</p>
                                    <p>We no longer store or process your information in our systems, except where retention is required by law.</p>
                                    @else
                                    <p>We cant find any record with your personal information.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
