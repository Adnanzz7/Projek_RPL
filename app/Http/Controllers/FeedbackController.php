<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saran;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('suggestion');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'pesan' => 'required',
        ]);

        Saran::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Saran berhasil dikirim.');
    }

    public function showSuggestions()
    {
        $suggestions = Saran::paginate(10);
        return view('suggestion-list', compact('suggestions'));
    }
}

