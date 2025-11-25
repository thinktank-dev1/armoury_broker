<div class="dropdown">
    <a href="#" type="button" id="seller-warning-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-ellipsis-h"></i>
    </a>
    <ul class="dropdown-menu" aria-labelledby="seller-warning-dropdown">
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#report-modal">Report Seller</a></li>
        @if(!Auth::guest())
        <li><a class="dropdown-item" href="#" id="block-seller" >Block Seller</a></li>
        @endif
    </ul>

    <div class="modal fade" tabindex="-1" id="report-modal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title text-white">Report {{ $vendor->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <form wire:submit.prevent="reportVendor">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Describe your complaint</label>
                                    <textarea class="form-control" name="description" wire:model.defer="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="reportVendor">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('report-sent', () => {
                $('.modal').modal('hide');
                $.notify("Report has been submitted", "success");
            });
        });
        $(document).ready(function(){
            $('#block-seller').on('click', function(e){
                e.preventDefault();
                var vendor_id = {{ $vendor->id }};
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Block!"
                }).then((result) => {
                    if (result.hasOwnProperty('value')){
                        if(result.value == true){
                            @this.dispatch('block-vendor', { vendor_id: vendor_id });
                        }
                    }
                });
            });
        });
    </script>
    @endpush
</div>