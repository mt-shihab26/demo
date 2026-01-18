<?php

namespace App\Http\Controllers\App;

use App\Enums\Period;
use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $budgets = $request->user()->budgets()
            ->with('category')
            ->limit(1000)
            ->get()
            ->map(fn ($budget) => [
                ...$budget->toArray(),
                'spent' => 123, // TODO: Calculate actual spent amount from transactions
            ]);

        $categories = $request->user()->categories()
            ->doesntHave('budget')
            ->limit(1000)
            ->get();

        return inertia('app/Budgets', [
            'budgets' => $budgets,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id', function ($attribute, $value, $fail) use ($request) {
                if (! $request->user()->categories()->where('id', $value)->exists()) {
                    $fail('The selected category does not belong to you.');
                }
                if (Budget::where('category_id', $value)->exists()) {
                    $fail('The selected category already has a budget.');
                }
            }],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'period' => ['required', 'string', Rule::in(Period::values())],
        ]);

        Budget::create($validated);

        return redirect()->back()->with('success', 'Budget created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        Gate::allowIf(fn (User $user) => $budget->category->user_id === $user->id); // @phpstan-ignore-line

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id', function ($attribute, $value, $fail) use ($request, $budget) {
                if (! $request->user()->categories()->where('id', $value)->exists()) {
                    $fail('The selected category does not belong to you.');
                }
                if (Budget::where('category_id', $value)->where('id', '!=', $budget->id)->exists()) {
                    $fail('The selected category already has a budget.');
                }
            }],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'period' => ['required', 'string', Rule::in(Period::values())],
        ]);

        $budget->update($validated);

        return redirect()->back()->with('success', 'Budget updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        Gate::allowIf(fn (User $user) => $budget->category->user_id === $user->id); // @phpstan-ignore-line

        $budget->delete();

        return redirect()->back()->with('success', 'Budget deleted successfully.');
    }
}
