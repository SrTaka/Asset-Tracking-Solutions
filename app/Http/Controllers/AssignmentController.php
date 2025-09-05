<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Asset;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with(['user', 'asset'])->get();
        return view('admin.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $users = User::all();
        $assets = Asset::all();
        return view('admin.assignments.create', compact('users', 'assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'asset_id' => 'required|exists:assets,id',
        ]);

        Assignment::create([
            'user_id' => $request->user_id,
            'asset_id' => $request->asset_id,
        ]);

        return redirect()->route('admin.assignments.index')->with('success', 'Asset assigned successfully!');
    }
}
