<?php

namespace App\Livewire\Forms;

use App\Enums\CategoryTypeEnum;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Form;

class CategoryForm extends Form
{
    public $name, $color, $list_id;

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
                [
                    "name" => trim($this->name),
                    "list_id"   => $this->list_id
                ],
                [
                    "type"  => CategoryTypeEnum::CUSTOM,
                    "color" => $this->color,
                    "created_by" => Auth::id()
                ]
            );
        } catch (\Throwable $th) {
            Log::critical($th);
            return false;
        }
    }

    /**
     * Update existing category.
     */
    public function update(Category $category)
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $category->update($this->only('name', 'color'));
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
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
