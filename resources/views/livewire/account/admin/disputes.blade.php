<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2>Disputes</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <h4 class="card-title">Disputes</h4>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Item</th>
                                        <th>Vendor A</th>
                                        <th>Vendor B</th>
                                        <th>Grievance</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dsps AS $dsp)
                                    <tr>
                                        <td>
                                            @if($dsp->item->product->images->count() > 0)
                                                <img style="height: 50px" src="{{ asset('storage/'.$dsp->item->product->images->first()->image_url) }}" alt="Card image cap">
                                            @endif
                                        </td>
                                        <td>{{ $dsp->item->product->item_name }} </td>
                                        <td>
                                            {{ $dsp->user1->vendor->name }}
                                            @if($dsp->item->product->vendor_id == $dsp->user1->vendor_id)
                                                <small>(S)</small>
                                            @else
                                                <small>(B)</small>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $dsp->user2->vendor->name }}
                                            @if($dsp->item->product->vendor_id == $dsp->user2->vendor_id)
                                                <small>(S)</small>
                                            @else
                                                <small>(B)</small>
                                            @endif
                                        </td>
                                        <td>{{ $dsp->message }}</td>
                                        <td>{{ date('d M Y', strtotime($dsp->created_at)) }}</td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-primary btn-sm" wire:click.prevent="setResolved({{ $dsp->id }})">Resolved</a>
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
    </div>
</div>