<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\Raffle;
use Illuminate\Support\Facades\Storage;

class AdminRewardController extends Controller
{
    // List all rewards
    public function index()
    {
        $rewards = Reward::with('admin', 'raffle')->orderByDesc('created_at')->get();
        return view('admin.rewards.index', compact('rewards'));
    }

    // Show create form
    public function create()
    {
        $raffles = Raffle::orderByDesc('created_at')->get();
        return view('admin.rewards.create', compact('raffles'));
    }

    // Store a new reward
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'point_cost' => 'required|integer|min:1',
            'raffleID' => 'nullable|exists:raffles,raffleID',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rewards', 'public');
        }

        Reward::create([
            'adminID' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'point_cost' => $request->point_cost,
            'raffleID' => $request->raffleID ?? null,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.rewards.index')->with('success', 'Reward created successfully.');
    }

    // Show edit form
    public function edit($rewardID)
    {
        $reward = Reward::findOrFail($rewardID);
        $raffles = Raffle::orderByDesc('created_at')->get();
        return view('admin.rewards.edit', compact('reward', 'raffles'));
    }

    // Update reward
    public function update(Request $request, $rewardID)
    {
        $reward = Reward::findOrFail($rewardID);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'point_cost' => 'required|integer|min:1',
            'raffleID' => 'nullable|exists:raffles,raffleID',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($reward->image && Storage::disk('public')->exists($reward->image)) {
                Storage::disk('public')->delete($reward->image);
            }

            // Store new image
            $reward->image = $request->file('image')->store('rewards', 'public');
        }

        $reward->update([
            'name' => $request->name,
            'description' => $request->description,
            'point_cost' => $request->point_cost,
            'raffleID' => $request->raffleID ?? null,
            'image' => $reward->image,
        ]);

        return redirect()->route('admin.rewards.index')->with('success', 'Reward updated successfully.');
    }

    // Delete reward
    public function destroy($rewardID)
    {
        $reward = Reward::findOrFail($rewardID);

        // Delete image if exists
        if ($reward->image && Storage::disk('public')->exists($reward->image)) {
            Storage::disk('public')->delete($reward->image);
        }

        $reward->delete();
        return back()->with('success', 'Reward deleted successfully.');
    }

    // Optional: view alumni redemptions
    public function redemptions($rewardID)
    {
        $reward = Reward::with('redemptions.alumni')->findOrFail($rewardID);
        return view('admin.rewards.redemptions', compact('reward'));
    }
}
