<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    private function resolveModel(string $source): string
    {
        return $source === 'admins' ? Admin::class : User::class;
    }

    public function index(Request $request): View
    {
        $source = $request->query('source', 'users');
        $modelClass = $this->resolveModel($source);
        $items = $modelClass::orderBy('name')->paginate(15)->withQueryString();
        return view('admin.users.index', compact('items', 'source'));
    }

    public function create(Request $request): View
    {
        $source = $request->query('source', 'users');
        return view('admin.users.create', compact('source'));
    }

    public function store(Request $request): RedirectResponse
    {
        $source = $request->input('source', 'users');
        $modelClass = $this->resolveModel($source);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique((new $modelClass)->getTable(), 'email')],
            'password' => ['required', 'string', 'min:8'],
            'email_verified' => ['nullable', 'boolean'],
        ]);

        $record = $modelClass::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (!empty($validated['email_verified'])) {
            $record->forceFill(['email_verified_at' => now()])->save();
        }

        return redirect()->route('admin.users.index', ['source' => $source])
            ->with('status', ucfirst(rtrim($source, 's')).' created successfully');
    }

    public function show(Request $request, int $id): View
    {
        $source = $request->query('source', 'users');
        $modelClass = $this->resolveModel($source);
        $record = $modelClass::findOrFail($id);
        return view('admin.users.show', ['record' => $record, 'source' => $source]);
    }

    public function edit(Request $request, int $id): View
    {
        $source = $request->query('source', 'users');
        $modelClass = $this->resolveModel($source);
        $record = $modelClass::findOrFail($id);
        return view('admin.users.edit', ['record' => $record, 'source' => $source]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $source = $request->input('source', 'users');
        $modelClass = $this->resolveModel($source);
        $record = $modelClass::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique((new $modelClass)->getTable(), 'email')->ignore($record->id)],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $update = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $update['password'] = Hash::make($validated['password']);
        }

        $record->update($update);

        return redirect()->route('admin.users.index', ['source' => $source])
            ->with('status', ucfirst(rtrim($source, 's')).' updated successfully');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        $source = $request->query('source', 'users');
        $modelClass = $this->resolveModel($source);
        $record = $modelClass::findOrFail($id);
        $record->delete();

        return redirect()->route('admin.users.index', ['source' => $source])
            ->with('status', ucfirst(rtrim($source, 's')).' deleted successfully');
    }
}


