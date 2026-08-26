<?php

namespace App\Livewire\Forms;

use App\Enums\ListStatusEnum;
use App\Enums\ListTypeEnum;
use App\Enums\ListUserRoleEnum;
use App\Models\ItemList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ListForm extends Form
{
    const MAX_LISTS_COUNT = 4;
    public $list;
    public $name, $type, $status;

    protected function rules()
    {
        return [
            'name'      => ['required', 'min:3', 'max:15'],
            'type'      => [],
            'status'    => [],
        ];
    }

    public function setList(ItemList $list)
    {
        $this->list = $list;
        $this->name = $list->name;
        $this->type = $list->type;
        $this->status = $list->status;
    }

    /**
     * Create new custom list and attach it to auth user.
     */
    public function create()
    {
        if(Auth::user()->lists()->where('type', ListTypeEnum::CUSTOM->value)->count() >= $this::MAX_LISTS_COUNT){
            LivewireAlert::title(__('Can not add new list.'))
                ->text(__('You have reached the maximum number of lists allowed.'))
                ->error()
                ->asToast()
                ->timer(10000)
                ->show();
            return;
        }
        $this->validate();
        
        try {
            DB::beginTransaction();
            $list = ItemList::create([
                'name' => $this->name,
                'type' => ListTypeEnum::CUSTOM->value,
                'status' => ListStatusEnum::ACTIVE->value,
                'created_by' => Auth::id(),
            ]);

            // Attach the user to the new custom list with the owner role
            Auth::user()->lists()->attach($list->id, [
                'role' => ListUserRoleEnum::OWNER,
                'status' => ListTypeEnum::CUSTOM->value,
            ]);

            $this->name = '';
            DB::commit();
            LivewireAlert::title(__('List added successfully.'))
                ->success()
                ->asToast()
                ->show();
            return $list;
        } catch (\Exception $e) {
            Log::error(__('Failed to create list: ') . $e);
            LiveWireAlert::title(__("Error"))
                ->text(__('Failed to create list'))
                ->error()
                ->show();
            return false;
        }
    }

    /**
     * Update existing list.
     */
    public function update()
    {
        $this->validate();
        try {
            $this->list->update([
                'name'  => trim($this->name),
            ]);
            return true;
        } catch (\Throwable $th) {
            Log::critical($th);
            return false;
        }
    }
}
