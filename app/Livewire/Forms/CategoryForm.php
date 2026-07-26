<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CategoryForm extends Form
{
    public $name, $color;

    protected function rules()
    {
        return [
            'name'      => ['required', 'string', 'min:3', 'max:128'],
            'color'     => ['required'],
        ];
    }
}
