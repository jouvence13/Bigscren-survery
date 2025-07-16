<?php
// app/Http/Controllers/Api/AdminStatsController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Response;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminStatsController extends Controller
{
    public function getDashboardStats()
    {
        // PIE CHARTS : Count answers per option for questions 6, 7, 10
        $pieQuestionIds = [6, 7, 10];
        $pieData = [];

        foreach ($pieQuestionIds as $qid) {
            $question = Question::find($qid);
            $options = json_decode($question->options);
            $counts = [];

            foreach ($options as $opt) {
                $counts[$opt] = Response::where('question_id', $qid)
                    ->where('answer', $opt)
                    ->count();
            }

            $pieData[$qid] = $counts;
        }

        // RADAR CHART : Average scores for questions 11-15 (1 to 5)
        $qualityIds = range(11, 15);
        $qualityData = [];

        foreach ($qualityIds as $qid) {
            $average = Response::where('question_id', $qid)->avg('answer');
            $qualityData[] = round((float) $average, 2);
        }

        return response()->json([
            'pie' => $pieData, // e.g. ['Oculus Quest' => 20, ...]
            'radar' => $qualityData
        ]);
    }
}
