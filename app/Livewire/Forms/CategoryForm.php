<?php

namespace App\Livewire\Forms;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CategoryForm extends Form
{
    public $name, $color;

    protected function rules()
    {
        return [
            'name'      => ['required', 'string', 'min:3', 'max:20'],
            'color'     => ['required', 'hex_color'],
        ];
    }

    /**
     * Search for record then if not found create new one.
     * return category if process is done or false if fail
     * @return Category|bool
     */
    public function firstOrCreate()
    {
        $this->color = $this->generateRandomHexColor(); // TODO: generate random color
        $this->validate();
        try {
            return Category::query()->firstOrCreate(
                ['name' => trim($this->name)],
                [
                    'color' => $this->color,
                    'created_by' => Auth::id(),
                ]
            );
        } catch (\Throwable $th) {
            Log::critical($th);
            return false;
        }
    }

    /**
     * Generates a random 6-character hexadecimal color string.
     * @return string
     */
    function generateRandomHexColor(): string
    {
        // Generate 3 random bytes (one for Red, Green, and Blue)
        $bytes = random_bytes(3);

        // Convert the binary data to a clean hex string and prepend the hash
        return '#' . bin2hex($bytes);
    }
}
