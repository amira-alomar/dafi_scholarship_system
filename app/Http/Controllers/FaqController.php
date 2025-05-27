<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function create()
    {
        $faqs = Faq::all();
        return view('admin.faq', compact('faqs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->back()->with('success', 'FAQ added successfully!');
    }
}
