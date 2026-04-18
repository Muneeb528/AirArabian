<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tickets = $query->latest()->paginate(15);
        $categories = Ticket::categories();

        return view('admin.tickets.index', compact('tickets', 'categories'));
    }

    public function create()
    {
        $categories = Ticket::categories();
        return view('admin.tickets.create', compact('categories'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'title'          => 'required',
        'category'       => 'required',
        'price'          => 'required|numeric',
        'seats'          => 'required|numeric',
        'departure_date' => 'required|date',
        'status'         => 'required',
        'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    // Image pehle handle karo
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('tickets', 'public');
    }

    Ticket::create([
        'title'          => $request->title,
        'category'       => $request->category,
        'price'          => $request->price,
        'seats_available'=> $request->seats,
        'departure_date' => $request->departure_date,
        'status'         => $request->status,
        'origin'         => $request->origin ?? 'Karachi',
        'destination'    => $request->destination ?? 'Dubai',
        'description'    => $request->description,
        'image'          => $validated['image'] ?? null,
    ]);
    
    return redirect()->route('admin.tickets.index')->with('success', 'Ticket added!');
}


    public function edit(Ticket $ticket)
    {
        $categories = Ticket::categories();
        return view('admin.tickets.edit', compact('ticket', 'categories'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'category'       => 'required|in:UAE,KSA,Umrah,Tour',
            'title'          => 'required|string|max:200',
            'description'    => 'nullable|string',
            'airline'        => 'nullable|string|max:100',
            'origin'         => 'required|string|max:100',
            'destination'    => 'required|string|max:100',
            'price'          => 'required|numeric|min:0',
            'seats_available'=> 'required|integer|min:0',
            'departure_date' => 'required|date',
            'return_date'    => 'nullable|date|after:departure_date',
            'status'         => 'required|in:available,booked,hold,cancelled',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($ticket->image) {
                Storage::disk('public')->delete($ticket->image);
            }
            $validated['image'] = $request->file('image')->store('tickets', 'public');
        }

        $ticket->update($validated);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        if ($ticket->image) {
            Storage::disk('public')->delete($ticket->image);
        }
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket deleted successfully.');
    }

    public function toggleStatus(Ticket $ticket)
    {
        $newStatus = $ticket->status === Ticket::STATUS_AVAILABLE
            ? Ticket::STATUS_CANCELLED
            : Ticket::STATUS_AVAILABLE;

        $ticket->update(['status' => $newStatus]);

        return back()->with('success', 'Ticket status updated.');
    }
}
