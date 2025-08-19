<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12 d-flex">
            <div class="">
                <h2>CATEGORIES</h2>
            </div>
            <span class="ms-auto">
                <a href="#" class="btn btn-primary" wire:click.prevent="showEdit">Add Category</a>
            </span>
        </div>
    </div>
    <div class="row mt-3">
        <div class="@if($show_sub_sub) col-md-4 @elseif($show_subs) col-md-6 @else col-md-12 @endif">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5 class="card-title">Categories</h5>
                            <p><small>Click on a category to manage sub-categories.</small></p>
                        </div>
                        <div class="ms-auto">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="search-addon"><i class="icon-magnifier"></i></span>
                                <input type="text" class="form-control" placeholder="Search" aria-describedby="search-addon" name="search_key" wire:model.live="search_key">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>CATEGRY NAME</th>
                                @if(!$show_sub_sub && !$show_subs)
                                <th>REGULATED</th>
                                <th>FEATURED</th>
                                <th>STATUS</th>
                                <th class="text-center">SUB-CATEGORIES</th>
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories AS $cat)
                            <tr>
                                <td class="txt-oflo">
                                    <a href="#" wire:click.prevent="showSubCats({{ $cat->id }})">
                                    {{ $cat->category_name }}
                                    </a>
                                </td>
                                @if(!$show_sub_sub && !$show_subs)
                                <td>
                                    @if($cat->regulated)
                                        Regulated
                                    @endif
                                </td>
                                <td>
                                    @if($cat->featured)
                                        Featured
                                    @endif
                                </td>
                                <td><span class="badge @if($cat->status) bg-success @else bg-secondary @endif rounded-pill">@if($cat->status) Active @else Disabled @endif</span></td>
                                <td class="text-center">({{ $cat->sub_cats->whereNull('parent_id')->count() }}) @if($cat->sub_cats->whereNotNull('parent_id')->count() > 0) ({{ $cat->sub_cats->whereNotNull('parent_id')->count() }}) @endif</td>
                                <td class="text-end">
                                    <a href="" wire:click.prevent="showEdit({{ $cat->id }})">Edit</a>
                                    &nbsp;|&nbsp;
                                    <a href="#" class="text-danger" wire:click.prevent="deleteCategory({{ $cat->id }})">Delete</a>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if($show_subs)
        <div class="@if($show_sub_sub) col-md-4 @else col-md-6 @endif">
            <div class="card">
                <div class="card-body">
                    @if($cur_cat)
                    <div class="d-flex">
                        <div>
                            <h5 class="card-title">{{ $cur_cat->category_name }} Sub Categories</h5>
                            <p><small>Click on a sub-category to manage sub-categories.</small></p>
                        </div>
                        <div class="ms-auto">
                        <a href="#" wire:click.prevent="showSubCatModal({{ $cur_cat->id }}, '', '', 'new')">Add Sub Category</a>
                    </div>
                    </div>
                    <div class="">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sub Category Name</th>
                                    @if(!$show_sub_sub)
                                    <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cur_cat->sub_cats->whereNull('parent_id') AS $cat)
                                <tr>
                                    <td>
                                        @if($cat->sub_sub->count() > 0)
                                        <a href="#" wire:click.prevent="showSubSub({{ $cat->id }})">
                                        @endif
                                            {{ $cat->sub_category_name }}
                                        @if($cat->sub_sub->count() > 0)    
                                        </a>
                                        @endif
                                    </td>
                                    @if(!$show_sub_sub)
                                    <td class="text-end">
                                        <a href="#" wire:click.prevent="showSubCatModal({{ $cur_cat->id }}, {{ $cat->id }}, '', 'edit')">Edit</a>
                                        &nbsp;|&nbsp;
                                        <a href="#" wire:click.prevent="showSubCatModal({{ $cur_cat->id }}, {{ $cat->id }}, '', 'new')">Add Sub</a>
                                        &nbsp;|&nbsp;
                                        <a href="#" class="text-danger">Remove</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
        @if($show_sub_sub)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sub Category Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cur_cat->sub_cats->where('parent_id', $cur_sub_id) AS $cat)
                            <tr>
                                <td>{{ $cat->sub_category_name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="modal fade" tabindex="-1" id="category-modal" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Category Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveCategory">
                        @if($errors->any())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="category_name" wire:model.defer="category_name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Category Image</label>
                                    <input type="file" class="form-control" name="category_image" wire:model.defer="category_image">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status" wire:model.defer="status">
                                        <option value="">Select Option</option>
                                        <option value="1">Active</option>
                                        <option value="0">Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">measurement_type</label>
                                    <select class="form-control" name="measurement_type" wire:model.defer="measurement_type">
                                        <option value="">Select Option</option>
                                        <option value="caliber">Caliber (Firearms)</option>
                                        <option value="dimensions">Dimensions (Products)</option>
                                        <option value="size">Size (Clothing)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="Regulated" wire:model.defer="regulated">
                                        <label class="form-check-label" for="Regulated">
                                            Regulated
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="Featured" wire:model.defer="featured">
                                        <label class="form-check-label" for="Featured">
                                            Featured
                                        </label>
                                    </div>
                                </div>
                            </div>
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
    <div class="modal fade" tabindex="-1" id="sub-category-modal" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sub Category Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveSubCategory">
                        @if($errors->any())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="category_name" wire:model.defer="sub_category_name">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="saveSubCategory">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-sub-category-modal', () => {
                $('#sub-category-modal').modal('show');
            });
            @this.on('show-category-modal', () => {
                $('#category-modal').modal('show');
            });
            @this.on('close-modal', () => {
                $('.modal').modal('hide');
            })
        })
    </script>
    @endpush
</div>