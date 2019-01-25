<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use App\Question;
use App\QuizAttempt;
use App\QuizAttemptAnswer;
use App\Answer;
use Auth;
use Response;

class QuizTakingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function start(request $request, $QuizID)
    {
        $Quiz = Quiz::with('Questions')->findOrFail($QuizID);

        return view('quiz.taking.start', compact('Quiz'));
    }

    public function submitStart(request $request, $QuizID)
    {
        $Quiz = Quiz::findOrFail($QuizID);

        $QuizAttempt = new QuizAttempt;
        $QuizAttempt->quiz_id = $Quiz->id;
        $QuizAttempt->user_id = Auth::id();
        $QuizAttempt->quiz_start_time = \Carbon\Carbon::now('Europe/London');
        $QuizAttempt->save();

        return redirect()->route('takeQuiz', [$Quiz->id, $QuizAttempt->id]);
    }

    public function take(request $request, $QuizID, $QuizAttemptID)
    {
        $Quiz = Quiz::with('Questions')->findOrFail($QuizID);
        $QuizAttempt = QuizAttempt::findOrFail($QuizAttemptID);

        return view('quiz.taking.take', compact('Quiz', 'QuizAttempt'));
    }

    public function grabNextQuestion(request $request, $QuizID, $QuizAttemptID)
    {
        $Quiz = Quiz::with('Questions.Answers')->findOrFail($QuizID);
        $QuizAttempt = QuizAttempt::with('QuizAttemptAnswers')->findOrFail($QuizAttemptID);

        if ($QuizAttempt->QuizAttemptAnswers->count() > 0) {
            $QuestionIDs = $QuizAttempt->QuizAttemptAnswers->pluck('question_id')->toArray();

            $NextQuestion = $Quiz->Questions->whereNotIn('id', $QuestionIDs)->first();
        } else {
            $NextQuestion = $Quiz->Questions->first();
        }

        return Response::json([
            'question' => $NextQuestion->toJson(),
        ], 200);
    }

    public function saveAnswer(request $request, $QuizID, $QuizAttemptID)
    {
        $Quiz = Quiz::with('Questions.Answers')->findOrFail($QuizID);
        $QuizAttempt = QuizAttempt::findOrFail($QuizAttemptID);

        $Question = Question::findOrFail($request->input('question_id'));
        $Answer = Answer::findOrFail($request->input('answer_id'));

        $QuizAttemptAnswer = new QuizAttemptAnswer;
        $QuizAttemptAnswer->quiz_attempt_id = $QuizAttempt->id;
        $QuizAttemptAnswer->question_id = $Question->id;
        $QuizAttemptAnswer->answer_id = $Answer->id;
        $QuizAttemptAnswer->question_answer_time = \Carbon\Carbon::now('Europe/London');
        $QuizAttemptAnswer->save();

        $QuizAttempt->load('QuizAttemptAnswers');

        $QuizFinished = ($QuizAttempt->QuizAttemptAnswers->count() >= $Quiz->Questions->count())  ? true : false;

        if ($QuizFinished) {
            $QuizAttempt->quiz_end_time = \Carbon\Carbon::now('Europe/London');
            $QuizAttempt->save();
        }

        return Response::json([
            'quiz_finished' => $QuizFinished,
        ], 200);
    }

    public function summary(request $request, $QuizID, $QuizAttemptID)
    {
        $Quiz = Quiz::with('Questions.Answers')->findOrFail($QuizID);
        $QuizAttempt = QuizAttempt::with('QuizAttemptAnswers')->findOrFail($QuizAttemptID);

        return view('quiz.summary', compact('Quiz', 'QuizAttempt'));
    }
}
