<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds to insert 20 survey questions.
     */
    public function run(): void
    {
        $questions = [
            [
                'number' => 1,
                'body' => 'What is your email address?',
                'type' => 'B',
                'options' => null,
            ],
            [
                'number' => 2,
                'body' => 'What is your age?',
                'type' => 'B',
                'options' => null,
            ],
            [
                'number' => 3,
                'body' => 'What is your gender?',
                'type' => 'A',
                'options' => json_encode(['Male', 'Female', 'Prefer not to say']),
            ],
            [
                'number' => 4,
                'body' => 'How many people are in your household (adults & children)?',
                'type' => 'C',
                'options' => null,
            ],
            [
                'number' => 5,
                'body' => 'What is your profession?',
                'type' => 'B',
                'options' => null,
            ],
            [
                'number' => 6,
                'body' => 'Which VR headset do you use?',
                'type' => 'A',
                'options' => json_encode(['Oculus Quest', 'Oculus Rift/s', 'HTC Vive', 'Windows Mixed Reality', 'Valve Index']),
            ],
            [
                'number' => 7,
                'body' => 'On which store do you buy VR content?',
                'type' => 'A',
                'options' => json_encode(['SteamVR', 'Oculus Store', 'Viveport', 'Windows Store']),
            ],
            [
                'number' => 8,
                'body' => 'Which headset do you plan to buy soon?',
                'type' => 'A',
                'options' => json_encode(['Oculus Quest', 'Oculus Go', 'HTC Vive Pro', 'PSVR', 'Other', 'None']),
            ],
            [
                'number' => 9,
                'body' => 'How many people in your household use Bigscreen with your headset?',
                'type' => 'C',
                'options' => null,
            ],
            [
                'number' => 10,
                'body' => 'What do you mainly use Bigscreen for?',
                'type' => 'A',
                'options' => json_encode(['Watching live TV', 'Watching movies', 'Working', 'Playing solo', 'Playing multiplayer']),
            ],
            [
                'number' => 11,
                'body' => 'How would you rate the image quality on Bigscreen?',
                'type' => 'C',
                'options' => null,
            ],
            [
                'number' => 12,
                'body' => 'How would you rate the interface usability on Bigscreen?',
                'type' => 'C',
                'options' => null,
            ],
            [
                'number' => 13,
                'body' => 'How would you rate the network connection quality on Bigscreen?',
                'type' => 'C',
                'options' => null,
            ],
            [
                'number' => 14,
                'body' => 'How would you rate the 3D graphics quality on Bigscreen?',
                'type' => 'C',
                'options' => null,
            ],
            [
                'number' => 15,
                'body' => 'How would you rate the audio quality on Bigscreen?',
                'type' => 'C',
                'options' => null,
            ],
            [
                'number' => 16,
                'body' => 'Would you like to receive more accurate notifications during your sessions?',
                'type' => 'A',
                'options' => json_encode(['Yes', 'No']),
            ],
            [
                'number' => 17,
                'body' => 'Would you like to invite a friend to your session via smartphone?',
                'type' => 'A',
                'options' => json_encode(['Yes', 'No']),
            ],
            [
                'number' => 18,
                'body' => 'Would you like to record TV shows to watch later?',
                'type' => 'A',
                'options' => json_encode(['Yes', 'No']),
            ],
            [
                'number' => 19,
                'body' => 'Would you like to play exclusive games on Bigscreen?',
                'type' => 'A',
                'options' => json_encode(['Yes', 'No']),
            ],
            [
                'number' => 20,
                'body' => 'Which new feature would you like to see on Bigscreen?',
                'type' => 'B',
                'options' => null,
            ],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
