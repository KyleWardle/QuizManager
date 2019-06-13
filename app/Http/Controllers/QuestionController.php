<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserCanEdit;
use App\Http\Middleware\UserCanView;
use Illuminate\Http\Request;
use App\Quiz;
use App\Question;
use App\Answer;
use App\Http\Requests\QuestionRequest;

class QuestionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(UserCanView::class);
        $this->middleware(UserCanEdit::class)->except(['manage', 'edit']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function manage(request $request, $QuizID)
     {
         $Quiz = Quiz::with('Questions.Answers')->findOrFail($QuizID);

         return view('quiz.questions.manage', compact('Quiz'));
     }

     public function new(request $request, $QuizID)
     {
         $Quiz = Quiz::findOrFail($QuizID);
         $Question = null;
         $formurl = route('submitNewQuestion', $Quiz->id);

         return view('quiz.questions.addedit', compact('Quiz', 'Question', 'formurl'));
     }

     public function submitNew(QuestionRequest $request, $QuizID)
     {
         $Quiz = Quiz::with('Questions')->findOrFail($QuizID);

         $Question = new Question;
         $Question->question = $request->input('question');
         $Question->quiz_id = $QuizID;
         $Question->position = ($Quiz->Questions->count() + 1) ?? 1;
         $Question->save();

         $correctArray = $request->input('correct');

         foreach ($request->input('answer') as $key => $answer) {
             $Answer = new Answer;
             $Answer->question_id = $Question->id;
             $Answer->answer = $answer;
             $Answer->position = $key + 1;
             $Answer->is_correct = isset($correctArray[$key]) ? 1 : 0;
             $Answer->save();
         }

         return redirect()->route('manageQuestions', $Quiz->id);
     }

     public function edit(request $request, $QuizID, $QuestionID)
     {
         $Quiz = Quiz::findOrFail($QuizID);
         $Question = Question::with('Answers')->findOrFail($QuestionID);
         $formurl = route('submitEditQuestion', [$Quiz->id, $Question->id]);

         return view('quiz.questions.addedit', compact('Quiz', 'Question', 'formurl'));
     }

     public function submitEdit(QuestionRequest $request, $QuizID, $QuestionID)
     {
         $Quiz = Quiz::findOrFail($QuizID);

         $Question = Question::with('Answers')->findOrFail($QuestionID);
         $Question->question = $request->input('question');
         $Question->save();

         foreach ($Question->Answers as $Answer) {
             $Answer->delete();
         }

         $correctArray = $request->input('correct');

         foreach ($request->input('answer') as $key => $answer) {
             $Answer = new Answer;
             $Answer->question_id = $Question->id;
             $Answer->answer = $answer;
             $Answer->position = $key + 1;
             $Answer->is_correct = isset($correctArray[$key]) ? 1 : 0;
             $Answer->save();
         }

         return redirect()->route('manageQuestions', $Quiz->id);
     }

     public function delete(request $request, $QuizID, $QuestionID)
     {
         $Quiz = Quiz::findOrFail($QuizID);
         $Question = Question::where('quiz_id', $QuizID)->findOrFail($QuestionID);

         $Question->delete();

         return redirect()->route('manageQuestions', $Quiz->id);
     }
}
