<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Livewire\Component;

class ExpenseIndex extends Component
{
    public float $amount = 0.00;
    public ?int $categoryId = null;
    public string $paymentMethod = 'cash';
    public ?string $description = null;
    public ?int $editingExpenseId = null;

    public ?string $successMessage = null;

    public function editExpense(int $id)
    {
        $exp = Expense::findOrFail($id);
        $this->editingExpenseId = $exp->id;
        $this->amount = (float) $exp->amount;
        $this->categoryId = $exp->category_id;
        $this->paymentMethod = $exp->payment_method;
        $this->description = $exp->description;
    }

    public function cancelEdit()
    {
        $this->reset(['editingExpenseId', 'amount', 'categoryId', 'paymentMethod', 'description']);
    }

    public function saveExpense()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1',
            'categoryId' => 'required|exists:expense_categories,id',
        ]);

        if ($this->editingExpenseId) {
            $exp = Expense::findOrFail($this->editingExpenseId);
            $exp->update([
                'category_id' => $this->categoryId,
                'amount' => $this->amount,
                'payment_method' => $this->paymentMethod,
                'description' => $this->description,
            ]);
            $this->successMessage = 'Expense entry updated!';
        } else {
            Expense::create([
                'business_id' => auth()->user()?->business_id ?? 1,
                'category_id' => $this->categoryId,
                'amount' => $this->amount,
                'payment_method' => $this->paymentMethod,
                'expense_date' => now()->toDateString(),
                'description' => $this->description,
                'created_by' => auth()->id(),
            ]);
            $this->successMessage = 'Expense successfully logged!';
        }

        $this->reset(['editingExpenseId', 'amount', 'categoryId', 'description']);
    }

    public function deleteExpense(int $id)
    {
        Expense::findOrFail($id)->delete();
        $this->successMessage = 'Expense record deleted successfully!';
    }

    public function render()
    {
        $expenses = Expense::with(['category', 'creator'])->latest('expense_date')->get();
        $categories = ExpenseCategory::orderBy('name')->get();

        return view('livewire.expenses.index', [
            'expenses' => $expenses,
            'categories' => $categories,
        ])->layout('components.layouts.app');
    }
}
