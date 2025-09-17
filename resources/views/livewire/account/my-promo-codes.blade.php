<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h3 class="page-title bold">MY PROMO CODES</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <ul class="nav nav-tabs profile-tab" role="tablist" wire:ignore>
                    <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#promo_codes" role="tab" aria-selected="true">Promo Codes</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#gift_vouchers" role="tab" aria-selected="false">Gift Vouchers</a> </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="promo_codes" role="tabpanel" wire:ignore.self>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">My Promo Codes</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3>Create New Promo Code</h3>
                                        </div>
                                        <form wire:submit.prevent="createVendorPromoCode">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Type</label>
                                                        <div class="">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="code_type" id="code_type_per" value="percentage" wire:model.defer="code_type">
                                                                <label class="form-check-label" for="code_type_per">Percentage</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="code_type" id="code_type_value" value="value" wire:model.defer="code_type">
                                                                <label class="form-check-label" for="code_type_value">Rand Value</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Value</label>
                                                        <input type="number" class="form-control" name="vendor_promo_code_value" wire:model="vendor_promo_code_value">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="name" wire:model.live="name">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Code</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" aria-describedby="button-gen" name="vendor_promo_code" wire:model.defer="vendor_promo_code">
                                                            <button class="btn btn-outline-secondary" type="button" id="button-gen" wire:click.prevent="generateCode">Generate</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Start Date</label>
                                                        <input type="date" class="form-control" name="start_date" wire:model="start_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">End Date</label>
                                                        <input type="date" class="form-control" name="end_date" wire:model="end_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Start Time</label>
                                                        <input type="time" class="form-control" name="start_time" wire:model="start_time">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">End Time</label>
                                                        <input type="time" class="form-control" name="end_time" wire:model="end_time">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-grid mt-3">
                                                    <input type="submit" class="btn btn-primary" value="Save Promo Code">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-8">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>Value</th>
                                                    <th>Duration</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($v_codes AS $cd)
                                                <tr>
                                                    <td>{{ $cd->code }}</td>
                                                    <td>{{ $cd->description }}</td>
                                                    <td>
                                                        @if($cd->type == "percentage")
                                                            {{ $cd->value }} %
                                                        @elseif($cd->type == "value")
                                                            R {{ number_format($cd->value, 2) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($cd->start_date && $cd->start_time)
                                                            {{ date('d M Y H:i', strtotime($cd->start_date.' '.$cd->start_time)) }}
                                                        @elseif($cd->start_date)
                                                            {{ date('d M Y', strtotime($cd->start_date)) }}
                                                        @endif
                                                        -
                                                        @if($cd->end_date && $cd->end_time)
                                                            {{ date('d M Y H:i', strtotime($cd->end_date.' '.$cd->end_time)) }}
                                                        @elseif($cd->end_date)
                                                            {{ date('d M Y', strtotime($cd->end_date)) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($cd->status == 1)
                                                        Active
                                                        @else
                                                        Disabled
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="#" class="text-danger" wire:click.prevent="deleteCode({{ $cd->id }})" wire:confirm="Are you sure you want to delete this code?">Delete</a>
                                                        &nbsp;|&nbsp;
                                                        @if($cd->status == 1)
                                                        <a href="#" wire:click.prevent="changeStatus({{ $cd->id }}, 0)">Disable</a>
                                                        @else
                                                        <a href="#" wire:click.prevent="changeStatus({{ $cd->id }}, 1)">Enable</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="gift_vouchers" role="tabpanel" wire:ignore.self>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">My Gift Vouchers</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3>By New Gift Voucher</h3>
                                        </div>
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
                                    <div class="col-md-8">
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
                                        {{--
                                        <div class="text-center mt-5">
                                            <h1 class="text-muted">Get started</h1>
                                            <p>Your promo codes will show here when you purchase them.</p>
                                        </div>
                                        --}}
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