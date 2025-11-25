<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Reward;
use App\Models\RedeemedReward;
use App\Models\RaffleEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RewardController extends Controller
{
    /**
     * Display all available rewards (including raffle tickets)
     */
    public function index()
    {
        $alumni = Auth::guard('alumni')->user();

        $totalPoints = Point::where('alumniID', $alumni->alumniID)->value('total_points') ?? 0;

        // Eager load raffle for raffle-type rewards
        $rewards = Reward::with('raffle')->get();

        return view('rewards.index', compact('totalPoints', 'rewards'));
    }

    /**
     * Handle reward redemption or raffle ticket entry
     */
    public function redeem($rewardID)
    {
        $alumni = Auth::guard('alumni')->user();
        $reward = Reward::with('raffle')->findOrFail($rewardID);
    
        $totalPoints = Point::where('alumniID', $alumni->alumniID)->value('total_points') ?? 0;
    
        // Check if already redeemed (only for normal rewards)
        if (!$reward->raffleID) {
            $alreadyRedeemed = RedeemedReward::where('alumniID', $alumni->alumniID)
                ->where('rewardID', $reward->rewardID)
                ->exists();
    
            if ($alreadyRedeemed) {
                return back()->with('info', 'You have already redeemed this reward.');
            }
        }
    
        if ($totalPoints < $reward->point_cost) {
            return back()->with('error', 'You do not have enough points to redeem this reward.');
        }
    
        DB::transaction(function () use ($alumni, $reward) {
            // Deduct points
            Point::where('alumniID', $alumni->alumniID)
                ->decrement('total_points', $reward->point_cost);
    
            if ($reward->raffleID) {
                // Raffle reward
                RaffleEntry::create([
                    'raffleID' => $reward->raffleID,
                    'alumniID' => $alumni->alumniID,
                    'points_used' => $reward->point_cost,
                ]);
    
                if ($alumni->email) {
                    Mail::to($alumni->email)
                        ->send(new \App\Mail\RaffleEntryMail($reward));
                }
    
            } else {
                // Normal reward redemption
                RedeemedReward::create([
                    'alumniID' => $alumni->alumniID,
                    'rewardID' => $reward->rewardID,
                    'redeemed_at' => now(),
                ]);
    
                if ($alumni->email) {
                    Mail::to($alumni->email)
                        ->send(new \App\Mail\RewardRedeemedMail($reward));
                }
            }
        });
    
        $message = $reward->raffleID
            ? 'You have successfully entered the raffle! Check your email for confirmation.'
            : 'Reward redeemed successfully! Check your email for confirmation.';
    
        return back()->with('success', $message);
    }

}
