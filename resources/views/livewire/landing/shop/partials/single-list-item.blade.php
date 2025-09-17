<div class="owl-item cloned" style="width: 258px; margin-right: 20px;">
    <div class="item">
        <div class="product">
            @if($tag)
            <span class="pr_flash @if($tag == 'Sold') bg-warning @endif">{{ $tag }}</span>
            @endif
            @if(!Auth::guest())
            <span class="lr_flash">
                <a href="#" wire:click.prevent="addToWishList({{ $product->id }})">
                    @if(Auth::user()->whilist_item($product->id))
                    <i class=" fas fa-star"></i>
                    @else
                    <i class="far fa-star"></i>
                    @endif
                </a>
            </span>
            @endif
            @php
            $img = url('img/no-image.webp');
            if($product->images->count() > 0){
                $img = url('storage/'.$product->images->first()->image_url);
            }
            @endphp
            <div class="product_img" style="background-image: url('{{ $img }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                <a href="{{ url('shop/product/'.$product->id) }}"></a>
                <div class="product_action_box">
                    <ul class="list_none pr_action_btn">
                        @if($availability)
                        <li class="add-to-cart"><a href="#" wire:click.prevent="addToCart"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                        @endif
                        <!-- <li><a href="{{ url('shop/product/'.$product->id) }}">View</a></li> -->
                        <li><a href="{{ url('shop/product/'.$product->id) }}"><span>View</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="product_info mt-2">
                <h6 class="product_title mb-1 bold">
                    R {{ number_format($product->item_price, 2) }}
                </h6>
                <div class="product-name">
                    <a href="{{ url('shop/product/'.$product->id) }}">
                        {{ $product->item_name }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>