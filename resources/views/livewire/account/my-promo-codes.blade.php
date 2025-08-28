<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2>My Promo Codes</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Buy New Promo Code</h4>
                </div>
                <div class="card-body">
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
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <form wire:submit.prevent="createPromoCode">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <input type="number" class="form-control" name="amount" wire:model.live="amount">
                                </div>
                            </div>
                            @if($amount)
                                <div class="col-md-12 d-grid mt-3">
                                    <input type="submit" class="btn btn-primary" value="Proceed To payment">
                                </div>
                                @if(Auth::user()->vendor)
                                    @if(Auth::user()->vendor->balance() > $amount)
                                        <div class="col-md-12 d-grid mt-3">
                                            <a href="#" class="btn btn-secondary" wire:click.prevent="createPromoCode('wallet')">Pay With Wallet</a>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Promo Code</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if($codes->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Status</th>
                                        <th>Payment Reff</th>
                                        <th>Payment Type</th>
                                        <th>Payment Status</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($codes AS $cd)
                                    <tr>
                                        <td><b>{{ $cd->code }}</b></td>
                                        <td>
                                            @if($cd->status == 0)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Used</span>
                                            @endif
                                        </td>
                                        <td>{{ $cd->payment_reff }}</td>
                                        <td>{{ ucwords(str_replace('_', ' ',$cd->payment_type)) }}</td>
                                        <td>{{ ucwords(strtolower($cd->payment_status)) }}</td>
                                        <td class="text-end">R {{ number_format($cd->amount,2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="text-center mt-5">
                                <h1 class="text-muted">Get started</h1>
                                <p>Your promo codes will show here when you purchase them.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('process-payment', (event) => {
                var data = JSON.parse(event.data);

                url = '{{ $payment_url }}';
                console.log(url);
                
                var form = $(document.createElement('form'));
                $(form).attr("action", url);
                $(form).attr("method", "POST");

                $.each(data, function(key,val){
                    var input = $("<input>").attr("type", "hidden").attr("name", key).val(val);
                    $(form).append($(input));
                });
                // console.log(form)
                $(document.body).append(form);
                $(form).submit();
                
            });
        });
    </script>
    @endpush
</div>