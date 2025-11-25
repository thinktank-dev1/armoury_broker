<div>
    <div class="section head shop-bg" wire:ignore.self>
        <div class="head-back">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-title text-center">
                            <h3 class="text-white mt-3">
                                @if($page_title)
                                    {{ $page_title }}
                                @else
                                    Shop
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section pt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3">
                    <b class="text-dark-blue text-upper text-14">Filter Options</b>
                    <div class="shop-filters mt-4 w-100 sicky-filters">
                        <div class="accordion" id="filter_accodion" wire:ignore.self>
                            <div class="accordion-item mb-2">
                                <h2 class="accordion-header" id="category_filter" wire:ignore>
                                    <button class="accordion-button collapsed upper-cat-header" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
                                        By Category
                                    </button>
                                </h2>
                                <div id="collapseCategory" class="accordion-collapse collapse" aria-labelledby="category_filter" data-bs-parent="#filter_accodion" wire:ignore.self>
                                    <div class="accordion-body">
                                        <div class="">
                                            <div class="accordion" id="innerCategoryFilter">
                                                @php
                                                $cnt = 0;
                                                @endphp
                                                @foreach($cats AS $cat)
                                                @php
                                                $cnt += 1;
                                                $collapsed = "collapsed";
                                                $expanded = "false";
                                                $show = "";
                                                /*
                                                if($cnt == 1){
                                                    $collapsed = "";
                                                    $expanded = "true";
                                                    $show = "show";
                                                }
                                                */
                                                @endphp
                                                <div class="accordion-item" wire:ignore.self>
                                                    <h2 class="accordion-header" id="heading_{{ $cat->id }}">
                                                        <button class="accordion-button {{ $collapsed }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $cat->id }}" aria-expanded="{{ $expanded }}" aria-controls="collapse_{{ $cat->id }}" wire:ignore>
                                                            {{ $cat->category_name }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapse_{{ $cat->id }}" class="accordion-collapse collapse {{ $show }}" aria-labelledby="heading_{{ $cat->id }}" data-bs-parent="#innerCategoryFilter" wire:ignore.self>
                                                        <div class="accordion-body">
                                                            <ul class="sub_cat_filter_list">
                                                                @foreach($cat->sub_cats->whereNull('parent_id') AS $sub)
                                                                <li>
                                                                    @php
                                                                    $checked = "";
                                                                    if(isset($current_filters['sub-category'])){
                                                                        if(in_array($sub->slug, $current_filters['sub-category'])){
                                                                            $checked = "checked";
                                                                        }
                                                                    }
                                                                    @endphp
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" wire:key="{{ $sub->id.now() }}" id="sub_check_{{ $sub->id }}" wire:key="sub_cat_{{ $sub->id.now() }}" wire:click.prevent="updateFilters('sub-category', '{{ $sub->slug }}')" {{ $checked }}>
                                                                        <label class="form-check-label" for="sub_check_{{ $sub->id }}">
                                                                            {{ $sub->sub_category_name }}
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                <div class="mt-2">
                                                    <a href="{{ url('shop?wanted') }}" class="ms-3" style="font-weight: 400">
                                                        Wanted
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="accordion-item mb-2" wire:ignore.self>
                                <h2 class="accordion-header" id="headingBrand">
                                    <button class="accordion-button upper-cat-header collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBrand" aria-expanded="false" aria-controls="collapseBrand" wire:ignore>
                                        By Brand
                                    </button>
                                </h2>
                                <div id="collapseBrand" class="accordion-collapse collapse" aria-labelledby="headingBrand" data-bs-parent="#filter_accodion" wire:ignore.self>
                                    <div class="accordion-body" wire:ignore.self>
                                        <div wire:ignore>
                                            <label>Select Brand</label>
                                            <select class="brands-select-multiple" name="states[]" multiple="multiple" style="width: 100%;" onchange="updatedBrands()" wire:ignore>
                                                @foreach($brands AS $brand)
                                                <option value="{{ $brand->slug }}" wire:click.prevent="updateFilters('brands', '{{ $brand->slug }}')">{{ $brand->brand_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-2" wire:ignore.self>
                                <h2 class="accordion-header" id="headingCondition" wire:ignore>
                                    <button class="accordion-button upper-cat-header collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCondition" aria-expanded="false" aria-controls="collapseCondition">
                                        By Condition
                                    </button>
                                </h2>
                                <div id="collapseCondition" class="accordion-collapse collapse" aria-labelledby="headingCondition" data-bs-parent="#filter_accodion" wire:ignore.self>
                                    <div class="accordion-body">
                                        <ul class="sub_cat_filter_list">
                                            @foreach($conditions AS $k => $cond)
                                            @php
                                            $cond_checked = "";
                                            if(isset($current_filters['condition'])){
                                                if(in_array($cond, $current_filters['condition'])){
                                                    $cond_checked = "checked";
                                                }
                                            }
                                            @endphp
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" wire:key="cond_fl_{{ $cond.now() }}" id="cond_check_{{ $k }}" wire:click.prevent="updateFilters('condition', '{{ $cond }}')" {{ $cond_checked }} />
                                                    <label class="form-check-label" for="cond_check_{{ $k }}">
                                                        {{ $cond }}
                                                    </label>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-2" wire:ignore.self>
                                <h2 class="accordion-header" id="headingCalibre">
                                    <button class="accordion-button upper-cat-header collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCalibre" aria-expanded="false" aria-controls="collapseCalibre" wire:ignore>
                                        By Caliber
                                    </button>
                                </h2>
                                <div id="collapseCalibre" class="accordion-collapse collapse" aria-labelledby="headingCalibre" data-bs-parent="#filter_accodion" wire:ignore.self>
                                    <div class="accordion-body" wire:ignore.self>
                                        <div wire:ignore>
                                            <label>Select Caliber</label>
                                            <select class="caliber-select-multiple" name="caliber[]" multiple="multiple" style="width: 100%;" onchange="updatedCaliber()" wire:ignore>
                                                @foreach($calibers AS $cal)
                                                <option value="{{ $cal->caliber }}">{{ $cal->caliber }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-2" wire:ignore.self>
                                <h2 class="accordion-header" id="headingPrice" wire:ignore.self>
                                    <button class="accordion-button upper-cat-header collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrice" aria-expanded="false" aria-controls="collapsePrice" wire:ignore>
                                        By Price
                                    </button>
                                </h2>
                                <div id="collapsePrice" class="accordion-collapse collapse" aria-labelledby="headingPrice" data-bs-parent="#filter_accodion" wire:ignore.self>
                                    <div class="accordion-body">
                                        <div class="" wire:ignore>
                                            <input type="text" class="js-range-slider" name="my_range" value="" data-min="{{ $static_min_price }}" data-max="{{ $static_max_price }}" data-skin="round" data-type="double" data-grid="false" />
                                            <input type="hidden" class="from" wire:model.live="min_price" />
                                            <input type="hidden"  class="to" wire:model.live="max_price" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <b class="text-dark-blue text-14">{{ $results_count }} Results</b>
                            @if($search_key || $wanted)
                            <span class="ms-3">
                                <a href="{{ url('shop') }}"><u><b class="text-dark-blue text-14">Clear Search</b></u></a>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-7">
                            @if(count($current_filters) > 0)
                                <span class="text-dark-blue">Active filter:</span> 
                                @foreach($current_filters AS $key => $filters)
                                    @foreach($filters AS $k => $filter)
                                    <span class="badge bg-dark mb-1">{{ $filter }} &nbsp;&nbsp;<a href="#" class="text-white" wire:click.prevent="removeFilter('{{ $key }}', {{ $k }})">x</a></span>
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                        <div class="col-12 col-md-5 d-flex mt-3 mt-md-0">
                            <div class="ms-ms-auto d-flex">
                                <span class="me-3 text-dark-blue">Sort By:</span>
                                <div class="">
                                    <select class="form-control filter-options" name="sort" wire:model.live="sort_by">
                                        @foreach($sort_options AS $op)
                                        <option value="{{ $op }}">{{ $op }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 product_list">
                        @foreach($products AS $product)
                            <livewire:landing.shop.partials.product-list-item wire:key="{{ $product->id.now() }}" :id="$product->id" />
                        @endforeach
                    </div>
                    <div class="row" x-data  x-intersect="$wire.call('loadMore')">
                        <div class="col-md-12 text-center">
                            @if($results_count > $items_count)
                                <div class="text-center" wire:loading>
                                    <img src="{{ asset('img/loading.gif') }}" class="loading-gif">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            $(document).ready(function() {
                $('.brands-select-multiple').select2();
                $('.caliber-select-multiple').select2();
            });
        })

        function updatedCaliber(){
            var values = $('.caliber-select-multiple').val();
            @this.dispatch('caliber-updated', { caliber: values });
        }

        function updatedBrands(){
            var values = $('.brands-select-multiple').val();
            @this.dispatch('brand-updated', { brands: values });
        }

        var $range = $(".js-range-slider"),
        $from = $(".from"),
        $to = $(".to"), 
        range, 
        min = $range.data('min'), 
        max = $range.data('max'), 
        from, 
        to;

        var updateValues = function () {
            $from.prop("value", from);
            $to.prop("value", to);
            @this.set('min_price', from);
            @this.set('max_price', to);
        };
        $range.ionRangeSlider({
            onChange: function (data) {
                from = data.from;
                to = data.to;
                updateValues();
            }
        });
        range = $range.data("ionRangeSlider");
        var updateRange = function () {
            range.update({
                from: from,
                to: to
            });
        };
        $from.on("input", function () {
            from = +$(this).prop("value");
            if (from < min) {
                from = min;
            }
            if (from > to) {
                from = to;
            }
            updateValues();    
            updateRange();
        });
        $to.on("input", function () {
            to = +$(this).prop("value");
            if (to > max) {
                to = max;
            }
            if (to < from) {
                to = from;
            }
            updateValues();    
            updateRange();
        });
    </script>
    @endpush
</div>
