<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ItemForm extends Form
{
    public $name, $category_id, $type;

    protected function rules()
    {
        return [
            'name'          => ['required', 'string', 'min:3', 'max:128'],
            'category_id'   => ['required', 'exists:categories,id'],
            'type'          => ['required', 'enum:ItemTypeEnum'],
        ];
    }
}
