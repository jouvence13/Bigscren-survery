<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Respondent;
use App\Models\Response;

class AdminController extends Controller
{
    // Liste des répondants
    public function index()
    {
        return response()->json(Respondent::select('id', 'email', 'token')->get());
    }

    // Voir les réponses d’un respondent (admin)
    public function show($token)
    {
        $respondent = Respondent::where('token', $token)->first();

        if (!$respondent) {
            return response()->json(['message' => 'Respondent not found'], 404);
        }

        $responses = Response::with('question')
            ->where('respondent_id', $respondent->id)
            ->get()
            ->map(function ($response) {
                return [
                    'question' => $response->question->body,
                    'answer' => $response->answer
                ];
            });

        return response()->json([
            'email' => $respondent->email,
            'responses' => $responses
        ]);
    }

    // (Optionnel) Supprimer un répondant
    public function destroy($id)
    {
        $respondent = Respondent::find($id);

        if (!$respondent) {
            return response()->json(['message' => 'Respondent not found'], 404);
        }

        $respondent->responses()->delete();
        $respondent->delete();

        return response()->json(['message' => 'Respondent and responses deleted']);
    }
}
