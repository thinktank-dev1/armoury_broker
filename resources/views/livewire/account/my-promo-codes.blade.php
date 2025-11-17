<div>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-12">
                <h3 class="page-title bold">
                    @if(url()->current() != URL::previous())
                    <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                    @endif
                    PROMO CODES
                </h3>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card bg-none">
                    <div class="card-header bg-dark">
                        <h3 class="card-title text-white">Create a New Promo Code</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="#" class="btn @if($code_type == 'percentage') btn-primary @else btn-secondary @endif" wire:click.prevent="changeType('percentage')">Percentage</a>
                                <a href="#" class="btn @if($code_type == 'value') btn-primary @else btn-secondary @endif" wire:click.prevent="changeType('value')">Rand Value</a>
                            </div>
                        </div>
                        @if($errors->any())
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <form wire:submit.prevent="createVendorPromoCode">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Value</label>
                                                <div class="input-group">
                                                    @if($code_type == 'value')
                                                    <span class="input-group-text" id="basic-addon1">R</span>
                                                    @endif
                                                    <input type="number" class="form-control" name="vendor_promo_code_value" wire:model="vendor_promo_code_value">
                                                    @if($code_type == 'percentage')
                                                    <span class="input-group-text" id="basic-addon1">%</span>
                                                    @endif
                                                </div>
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
                                            <input type="submit" class="btn btn-primary" value="Create Promo Code">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <ul class="nav nav-tabs profile-tab settings-tabs" role="tablist" wire:ignore.self>
                    <li class="nav-item" wire:ignore><a class="nav-link active" data-bs-toggle="tab" href="#active" role="tab">Active</a></li>
                    <li class="nav-item" wire:ignore><a class="nav-link" data-bs-toggle="tab" href="#inactive" role="tab">Inactive</a></li>
                </ul>
                <div class="tab-content tabcontent-border">
                    <div class="tab-pane active bg-white" id="active" role="tabpanel">
                        <div class="p-20">
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
                                    @foreach($v_codes_active AS $cd)
                                    <tr>
                                        <td>{{ $cd->code }}</td>
                                        <td>{{ $cd->description }}</td>
                                        <td>
                                            @if($cd->type == "percentage")
                                                {{ $cd->value }} %
                                            @else
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
                                                Inactive
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
                    <div class="tab-pane p-20 bg-white" id="inactive" role="tabpanel">
                        <div class="">
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
                                    @foreach($v_codes_inactive AS $cd)
                                    <tr>
                                        <td>{{ $cd->code }}</td>
                                        <td>{{ $cd->description }}</td>
                                        <td>
                                            @if($cd->type == "percentage")
                                                {{ $cd->value }} %
                                            @else
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
                                                Inactive
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
</div>