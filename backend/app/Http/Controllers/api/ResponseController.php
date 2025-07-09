<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Respondent;
use App\Models\Response;
use App\Models\Question;

class ResponseController extends Controller
{
    /**
     * Store survey responses for a respondent.
     */
    public function store(Request $request)
    {
        // 1. Validate input
        $data = $request->validate([
            'email' => 'required|email',
            'responses' => 'required|array|size:20', // exactly 20
            'responses.*.question_id' => 'required|exists:questions,id',
            'responses.*.answer' => 'required|string',
        ]);

        // 2. Check if this email has already submitted responses
        $alreadyAnswered = Respondent::where('email', $data['email'])->first();
        if ($alreadyAnswered && Response::where('respondent_id', $alreadyAnswered->id)->exists()) {
            return response()->json([
                'message' => 'You have already submitted responses.'
            ], 409);
        }

        // 3. Create or find respondent
        $respondent = Respondent::firstOrCreate(
            ['email' => $data['email']],
            ['token' => Str::uuid()]
        );

        // 4. Save each response
        foreach ($data['responses'] as $response) {
            Response::create([
                'respondent_id' => $respondent->id,
                'question_id' => $response['question_id'],
                'answer' => $response['answer'],
            ]);
        }

        // 5. Return token
        return response()->json([
            'message' => 'Responses recorded successfully',
            'token' => $respondent->token
        ]);
    }

    /**
     * Retrieve all responses for a respondent using their token.
     */
    public function showByToken($token)
    {
        // 1. Find respondent by token
        $respondent = Respondent::where('token', $token)->first();

        if (!$respondent) {
            return response()->json(['message' => 'Invalid token'], 404);
        }

        // 2. Get all responses with question text
        $responses = Response::with('question')
            ->where('respondent_id', $respondent->id)
            ->get();

        // 3. Format response
        $formatted = $responses->map(function ($response) {
            return [
                'question' => $response->question->body,
                'answer' => $response->answer,
            ];
        });

        return response()->json([
            'email' => $respondent->email,
            'responses' => $formatted
        ]);
    }
}
