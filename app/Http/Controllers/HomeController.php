<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'UAE');
        $validCategories = Ticket::categories();

        if (!in_array($category, $validCategories)) {
            $category = 'UAE';
        }

        $ticketsByCategory = [];
        foreach ($validCategories as $cat) {
            $ticketsByCategory[$cat] = Ticket::where('category', $cat)
                ->where('status', Ticket::STATUS_AVAILABLE)
                ->orderBy('departure_date')
                ->take(6)
                ->get();
        }

        $featuredTickets = Ticket::where('status', Ticket::STATUS_AVAILABLE)
            ->orderBy('departure_date')
            ->take(8)
            ->get();

        return view('home', compact('ticketsByCategory', 'featuredTickets', 'category', 'validCategories'));
    }
}
