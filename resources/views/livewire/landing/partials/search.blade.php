<form wire:submit.prevent="gotToShop">
    <div class="input-group">
        <input type="text" class="form-control header-search-input" list="suggestions" placeholder="Search" wire:model.defer="search_key">
        <button class="btn heder-search-btn" type="button" wire:click.prevent="gotToShop">GO</button>
        <datalist id="suggestions">
            @foreach($searches AS $srch)
                <option value="{{ $srch->search_key }}" />
            @endforeach
        </datalist>
    </div>
</form>
