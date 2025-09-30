<div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card auth-cont">
                        <div class="card-body px-4">
                            <div class="row">
                                <div class="col-md-12 text-center mt-4 mb-3 pt-3">
                                    <h4 class="page-title">Payment {{ $status }}</h4>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-12 text-center mb-5">
                                    @if($status == "pending")
                                        <b>Your payment was successful, please give us a moment to notify the seller.</b>
                                    @elseif($status == "canceled")
                                        <b>Your payment was cancelled.</b>
                                    @endif
                                </div>
                                <div class="col-md-12 mb-5 text-center">
                                    <a href="{{ url('shop') }}" class="bnt btn-primary">Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>