<?php

namespace App\Http\Controllers\App;

use App\Enums\Kind;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = $request->user()->transactions()
            ->with('category')
            ->orderBy('date', 'desc')
            ->limit(1000)
            ->get();

        $categories = $request->user()->categories()
            ->limit(1000)
            ->get();

        return inertia('app/Transactions', [
            'transactions' => $transactions,
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
            }],
            'kind' => ['required', 'string', Rule::in(Kind::values())],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'description' => ['required', 'string', 'max:1000'],
            'date' => ['required', 'date'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
        ]);

        $request->user()->transactions()->create($validated);

        return redirect()->back()->with('success', 'Transaction created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        Gate::allowIf(fn (User $user) => $transaction->user_id === $user->id);

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id', function ($attribute, $value, $fail) use ($request) {
                if (! $request->user()->categories()->where('id', $value)->exists()) {
                    $fail('The selected category does not belong to you.');
                }
            }],
            'kind' => ['required', 'string', Rule::in(Kind::values())],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'description' => ['required', 'string', 'max:1000'],
            'date' => ['required', 'date'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
        ]);

        $transaction->update($validated);

        return redirect()->back()->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        Gate::allowIf(fn (User $user) => $transaction->user_id === $user->id);

        $transaction->delete();

        return redirect()->back()->with('success', 'Transaction deleted successfully.');
    }
}
