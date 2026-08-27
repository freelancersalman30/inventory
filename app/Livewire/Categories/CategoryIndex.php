<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryIndex extends Component
{
    public string $name = '';
    public ?int $editingCategoryId = null;
    public ?string $successMessage = null;

    public function editCategory(int $id)
    {
        $cat = Category::findOrFail($id);
        $this->editingCategoryId = $cat->id;
        $this->name = $cat->name;
    }

    public function cancelEdit()
    {
        $this->reset(['editingCategoryId', 'name']);
    }

    public function saveCategory()
    {
        $this->validate(['name' => 'required|string|max:255']);

        if ($this->editingCategoryId) {
            $cat = Category::findOrFail($this->editingCategoryId);
            $cat->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name) . '-' . rand(100, 999),
            ]);
            $this->successMessage = 'Category updated!';
        } else {
            Category::create([
                'name' => $this->name,
                'slug' => Str::slug($this->name) . '-' . rand(100, 999),
            ]);
            $this->successMessage = 'Category added!';
        }

        $this->reset(['editingCategoryId', 'name']);
    }

    public function deleteCategory(int $id)
    {
        Category::findOrFail($id)->delete();
        $this->successMessage = 'Category deleted!';
    }

    public function render()
    {
        $categories = Category::withCount('products')->get();
        return view('livewire.categories.index', compact('categories'))->layout('components.layouts.app');
    }
}
