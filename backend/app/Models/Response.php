<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
     protected $fillable = ['respondent_id', 'question_id', 'answer'];

    /**
     * Each response belongs to a question.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Each response belongs to a respondent.
     */
    public function respondent()
    {
        return $this->belongsTo(Respondent::class);
    }
}
