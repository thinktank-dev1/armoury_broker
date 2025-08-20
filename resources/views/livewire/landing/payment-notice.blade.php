<div>
    <div class="section how-it-works">
        <div class="container">
            <div class="row align-items-center mb-4">
                <div class="col-md-12 text-center">
                    <h2 class="page-title">Payment {{ $status }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body text-center">
                            @if($status == "pending")
                                <p>Your payment was successful, please give us a moment to notify the seller.</p>
                            @elseif($status == "canceled")
                                <p>Your payment was cancelled.</p>
                            @endif
                            <a href="{{ url('shop') }}">Continue shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>