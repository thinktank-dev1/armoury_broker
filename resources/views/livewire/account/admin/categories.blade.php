<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <h4 class="card-title">Categories</h4>
                    <span class="ms-auto">
                        <a href="#" class="btn btn-primary" wire:click.prevent="showModal">Add Category</a>
                    </span>
                </div>
                <div class="row mt-3">
                    <div class="@if($cats_std) col-md-4 @else col-md-12 @endif">
                        <ul class="list-group">
                            <li class="list-group-item">Categories</li>
                            @foreach($cats AS $cat)
                            <li class="list-group-item d-flex">
                                <img src="{{ asset('storage/'.$cat->category_image) }}" class="cat-tbl-img">
                                <a href="#" wire:click.prevent="getSubCats({{ $cat->id }})">
                                    <p>{{ $cat->category_name }}</p>
                                </a>
                                <span class="ms-auto">
                                    <a href="#" wire:click.prevent="showModal({{ $cat->id }})"><i class="icon-book-open"></i> Edit</a>
                                    &nbsp;|&nbsp;
                                    <a href="#" wire:click.prevent="removeCategory({{ $cat->id }})"><i class=" icon-trash"></i> Remove</a>
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @if($cats_std)
                    <div class="col-md-8">
                        <ul class="list-group">
                            <li class="list-group-item">Sub Categories</li>
                            @foreach($cats_std AS $cat)
                            <li class="list-group-item d-flex">
                                <p>{{ $cat->sub_category_name }}</p>
                                <span class="ms-auto"><a href="#" wire:click.prevent="reoveSubCategory({{ $cat->id }})"><i class=" icon-trash"></i> Remove</a></span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="category-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit="saveCategory" class="form-material m-t-40">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" class="form-control" placeholder="Category Name" name="category_name" wire:model.defer="category_name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <input type="file" class="form-control" placeholder="Category Image" name="category_image" wire:model.defer="category_image">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mt-3 d-flex">
                                    <h3>SUB CATAGORIES</h3>
                                    <span class="ms-auto">
                                        <a href="#" class="btn btn-secondary" wire:click.prevent="addSubCat">Add Sub Category</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            @foreach($sub_cats AS $k=>$sub)
                            <div class="mb-3">
                                <label class="form-label">Sub Category Name</label>
                                <input type="text" placeholder="Sub category Name" class="form-control" name="sub_category_name" wire:model.defer="sub_cats.{{$k}}.name">
                            </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="saveCategory">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-add-category-modal', () => {
                $('#category-modal').modal('show');
            });
            @this.on('close-modal', () => {
                $('.modal').modal('hide');
            })
        })
    </script>
    @endpush
</div>