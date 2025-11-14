<div class="col-md-3">
    @if($shop)
    <div class="card bg-grey" style="border-radius: 0px; border: 0px solid #CCC;">
        <div class="card-body ps-4">
            <div class="">
                @if($shop->avatar)
                    <img class="cnt-img" src="{{ asset('storage/'.$shop->avatar) }}">
                @else
                    <img class="cnt-img" src="{{ asset('img/avatar_placeholder_large.png') }}">
                @endif
            </div>
            <div>
                <div class="">
                    <b>{{ $shop->name }}</b>
                </div>
                <div class="d-flex gap-3 mt-1">
                    <span><b>{{ $shop->likes->count() }}</b> Likes</span>
                    <span><b>{{ $shop->sold() }}</b> Items Sold</span>
                </div>
                <div class="mt-1">
                    <p class="mb-0"><i class="ti ti-truck"></i> Usually delivers in <b>0 days</b></p>
                </div>
                <div class="mt-1">
                    <p class="mt-1"><i class="ti-location-pin"></i> {{ $shop->city }}</p>
                </div>
                <div>
                    <a href="{{ url($shop->url_name) }}" class="mt-2 mt-md-0"><u>View Seller Profile</u></a>
                </div>
            </div>
            <a href="#" wire:click.prevent="likeVendor({{ $shop->id }})" class="shop-like-star">
                @if($shop->likes->where('user_id', Auth::user()->id)->first())
                <i class="fas fa-star"></i>
                @else
                <i class="icon-star"></i>
                @endif
            </a>
        </div>
    </div>
    @endif
</div>