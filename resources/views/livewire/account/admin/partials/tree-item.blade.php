@foreach($items as $index => $item)
    @php
    $currentPath = array_merge($path, [$index]);
    $fieldPath = 'items.' . implode('.', $currentPath);
    @endphp
    <div class="border rounded p-3 mb-2 bg-light" wire:key="tree-item-{{ $item['_key'] }}">
        <div class="d-flex align-items-center gap-2">
            <div class="flex-grow-1">
                <input type="text" class="form-control" wire:model.live="{{ $fieldPath }}.name" placeholder="Enter item name">
            </div>
            <button type="button" class="btn btn-success btn-sm" wire:click="addItem(@js($currentPath))">
            	<i class="fa fa-plus"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm" wire:click="removeItem(@js($currentPath))" wire:confirm="Delete this item and all its children?">
                <i class="fa fa-trash"></i>
            </button>
        </div>
        @if(!empty($item['children']))
            <div class="ms-4 mt-3">
                @include('livewire.account.admin.partials.tree-item', [
    				'items' => $item['children'],
    				'path' => array_merge($currentPath, ['children'])
				])
            </div>
        @endif
    </div>
@endforeach