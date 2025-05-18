<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraduateFeedbackController extends Controller
{
    public function store(Request $request)
{
    $user = auth()->user();

    // التأكد أنه خريج
    if (!$user->graduates()->exists()) {
        return redirect()->route('dashboard')->with('error', 'Only graduates can submit feedback.');
    }

    // حفظ الرأي
    $graduate = $user->graduates()->first(); // حسب الحالة، ممكن يكون فيه أكثر من سجل
    $graduate->feedback = $request->input('feedback');
    $graduate->save();

    return redirect()->route('student.dashboard')->with('success', 'Thank you for your feedback!');
}

}
