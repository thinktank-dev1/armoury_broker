<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h3 class="page-title bold">
                @if(url()->current() != URL::previous())
                <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                @endif
                Disputes
            </h3>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <h4 class="card-title">Legal Documents</h4>
                        <div class="ms-auto">
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#legal-modal">Add Doc</a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <ul class="list-group">
                                @foreach($docs AS $doc)
                                <li class="list-group-item d-flex">
                                    <b>{{ ucwords(str_replace('_', ' ',$doc->name)) }}</b>
                                    <span class="ms-auto">
                                        <a href="{{ url('storage/'.$doc->link_url) }}" target="_blank">View</a>
                                        &nbsp;|&nbsp;
                                        <a href="#" wire:click.prevent="showModal('{{ $doc->name }}')">Edit</a>
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="legal-modal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update {{ ucwords(str_replace('_', ' ',$cur_type)) }}</h5>
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
                    <form wire:submit.prevent="saveDoc">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Type</label>
                                    <select class="form-control" name="type" wire:model.live="cur_type">
                                        <option value="">Select Option</option>
                                        <option value="privacy_policy">Privacy Policy</option>
                                        <option value="terms_of_use">Terms of Use</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Select new {{ str_replace('_', ' ',$cur_type) }} document</label>
                                    <input type="file" class="form-control" name="file" wire:model.defer="file">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="saveDoc">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-modal', () => {
                $('#legal-modal').modal('show');
            });
            @this.on('close-modal', () => {
                $('.modal').modal('hide');
            })
        })
    </script>
    @endpush
</div>