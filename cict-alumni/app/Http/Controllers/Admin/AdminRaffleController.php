<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Raffle;
use App\Models\RaffleEntry;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use App\Mail\RaffleWinnerMail;

class AdminRaffleController extends Controller
{
    // List all raffles
    public function index()
    {
        $raffles = Raffle::with('admin', 'event', 'entries.alumni')->orderByDesc('created_at')->get();
        return view('admin.raffles.index', compact('raffles'));
    }

    // Show create form
    public function create()
    {
        $events = Event::orderByDesc('event_date')->get();
        return view('admin.raffles.create', compact('events'));
    }

    // Store a new raffle
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Raffle::create([
            'adminID' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.raffles.index')->with('success', 'Raffle created successfully.');
    }

    // Show edit form
    public function edit($raffleID)
    {
        $raffle = Raffle::findOrFail($raffleID);
        $events = Event::orderByDesc('event_date')->get();
        return view('admin.raffles.edit', compact('raffle', 'events'));
    }

    // Update raffle
    public function update(Request $request, $raffleID)
    {
        $raffle = Raffle::findOrFail($raffleID);
    
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $raffle->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);
    
        return redirect()->route('admin.raffles.index')
                         ->with('success', 'Raffle updated successfully.');
    }


    // Pick a random winner for a raffle
    public function pickWinner($raffleID)
    {
        $raffle = Raffle::with('entries.alumni')->findOrFail($raffleID);
    
        if ($raffle->entries->isEmpty()) {
            return back()->with('error', 'No entries to pick from.');
        }
    
        $winnerEntry = $raffle->entries->random();
        $winner = $winnerEntry->alumni;
    
        // Send email
        Mail::to($winner->email)->send(new RaffleWinnerMail($winner, $raffle));
    
        return back()->with('winner', $winner)->with('success', 'Winner picked and notified via email!');
    }


    // Delete raffle
    public function destroy($raffleID)
    {
        $raffle = Raffle::findOrFail($raffleID);
        $raffle->delete();
        return back()->with('success', 'Raffle deleted successfully.');
    }

    // View all entries for a raffle
    public function entries($raffleID)
    {
        $raffle = Raffle::with('entries.alumni')->findOrFail($raffleID);
        return view('admin.raffles.entries', compact('raffle'));
    }
}
