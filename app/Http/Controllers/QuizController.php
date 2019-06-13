<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserCanEdit;
use App\Http\Middleware\UserCanView;
use App\QuizAttempt;
use Illuminate\Http\Request;
use App\Quiz;
use App\Http\Requests\QuizRequest;

class QuizController extends Controller
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
        $this->middleware(UserCanEdit::class)->except(['quizAttempts']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function create(request $request)
     {
         $formurl = route('submitCreateQuiz');
         $Quiz = null;
         return view('quiz.addedit', compact('Quiz', 'formurl'));
     }

     public function submitCreate(QuizRequest $request)
     {
         $Quiz = Quiz::create($request->all());
         return redirect()->route('home');
     }

     public function edit(request $request, $QuizID)
     {
         $Quiz = Quiz::findOrFail($QuizID);
         $formurl = route('submitEditQuiz', $QuizID);
         return view('quiz.addedit', compact('Quiz', 'formurl'));
     }

     public function submitEdit(QuizRequest $request, $QuizID)
     {
         $Quiz = Quiz::findOrFail($QuizID)->update($request->all());
         return redirect()->route('home');
     }

     public function delete(request $request, $QuizID)
     {
         $Quiz = Quiz::findOrFail($QuizID);
         $Quiz->delete();
         return redirect()->route('home');
     }

     public function quizAttempts($QuizID)
     {
         $Quiz = Quiz::findOrFail($QuizID);
         $AllRelatedQuizzes = Quiz::where('parent_id', $Quiz->id)->orWhere('id', $Quiz->id)->pluck('id')->toArray();
         $QuizAttempts = QuizAttempt::with('Quiz.Questions', 'User')->whereIn('quiz_id', $AllRelatedQuizzes)->get();
         return view('quiz.attempts', compact('Quiz', 'QuizAttempts'));

     }
}
