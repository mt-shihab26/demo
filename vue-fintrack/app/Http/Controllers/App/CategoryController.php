<?php

namespace App\Http\Controllers\App;

use App\Enums\Kind;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = $request->user()->categories()
            ->limit(1000)
            ->get()
            ->map(fn ($category) => [
                ...$category->toArray(),
                'transaction_count' => 1,
                'total_amount' => 123,
            ]);

        return inertia('app/Categories', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'kind' => ['required', 'string', Rule::in(Kind::values())],
            'color' => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
        ]);

        $request->user()->categories()->create($validated);

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        Gate::allowIf(fn (User $user) => $category->user_id === $user->id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'kind' => ['required', 'string', Rule::in(Kind::values())],
            'color' => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
        ]);

        $category->update($validated);

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Gate::allowIf(fn (User $user) => $category->user_id === $user->id);

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
