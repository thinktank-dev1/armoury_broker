<?php

namespace App\Livewire\Account\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\Faq;

class Faqs extends Component
{
    public $items = [];

    public function mount(){
        $records = Faq::whereNull('parent_id')
        ->orderBy('sort_order')
        ->get();

        $this->items = $this->loadItems($records);
    }

    private function loadItems($records){
        $items = [];

        foreach ($records as $record) {
            $items[] = [
                '_key' => (string) Str::uuid(),
                'id' => $record->id,
                'name' => $record->content,
                'children' => $this->loadItems(
                    $record->children()->get()
                ),
            ];
        }
        
        return $items;
    }

    public function addItem($path = []){
        $newItem = [
            '_key' => (string) Str::uuid(),
            'id' => null,
            'name' => '',
            'children' => [],
        ];

        $this->addToPath($this->items, $path, $newItem);
    }

    private function addToPath(&$items, $path, $newItem)
{
    if (empty($path)) {
        $items[] = $newItem;
        return;
    }

    $index = array_shift($path);

    if (!isset($items[$index])) {
        return;
    }

    // Skip the literal "children" key
    if (!empty($path) && $path[0] === 'children') {
        array_shift($path);
    }

    $this->addToPath(
        $items[$index]['children'],
        $path,
        $newItem
    );
}

    public function removeItem($path){
        $this->removeFromPath($this->items, $path);
    }

    private function removeFromPath(&$items, $path){
        $index = array_shift($path);

        if (!isset($items[$index])) {
            return;
        }

        if (empty($path)) {
            array_splice($items, $index, 1);
            return;
        }

        $this->removeFromPath(
            $items[$index]['children'],
            $path
        );
    }

    private function validateItems($items){
        foreach ($items as $item) {

            Validator::make($item, [
                'name' => 'required|string',
                'children' => 'present|array',
            ])->validate();

            $this->validateItems($item['children']);
        }
    }

    public function save(){
        $this->validateItems($this->items);

        DB::transaction(function () {

            $savedIds = [];

            foreach ($this->items as $index => $item) {
                $this->saveItem(
                    $item,
                    null,
                    $index,
                    $savedIds
                );
            }

            // Remove records deleted from the form
            $query = Faq::query();

            if (!empty($savedIds)) {
                $query->whereNotIn('id', $savedIds);
            }

            $query->delete();
        });

        // Reload database IDs
        $this->mount();

        session()->flash('success', 'Tree saved successfully!');
    }

    private function saveItem(
        $item,
        $parentId,
        $sortOrder,
        &$savedIds
    ) {
        if (!empty($item['id'])) {
            $record = Faq::findOrFail($item['id']);
        } else {
            $record = new Faq();
        }

        $record->parent_id = $parentId;
        $record->content = $item['name'];
        $record->sort_order = $sortOrder;

        $record->save();

        $savedIds[] = $record->id;

        foreach ($item['children'] as $index => $child) {
            $this->saveItem(
                $child,
                $record->id,
                $index,
                $savedIds
            );
        }
    }

    public function render(){
        return view('livewire.account.admin.faqs');
    }
}