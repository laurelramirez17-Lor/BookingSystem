<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'min:10', 'max:1500'],
        ]);

        Feedback::create([
            'user_id' => $request->user()->id,
            ...$data,
        ]);

        return redirect()->to(route('welcome').'#feedback')
            ->with('feedback_success', 'Thank you for sharing your ARAUM experience.');
    }
}
