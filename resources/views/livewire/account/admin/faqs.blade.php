<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h3 class="page-title bold">
                @if(url()->current() != URL::previous())
                <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                @endif
                FAQ Settings
            </h3>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">FAQ Editor</h4>
                    </div>
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if($errors->any())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <button type="button" class="btn btn-primary btn-sm mb-3" wire:click="addItem">
                            <i class="fa fa-plus"></i>
                            Add Main Item
                        </button>

                        @include('livewire.account.admin.partials.tree-item', [
                            'items' => $items,
                            'path' => []
                        ])
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">
                                Save FAQs
                            </span>
                            <span wire:loading wire:target="save">
                                Saving...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>