<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserIsTeacher;
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
        $this->middleware(UserIsTeacher::class);
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
}
