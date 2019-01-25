@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body text-center">
                        <h2>Quiz Summary for : {{ $Quiz->title }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body text-center">
                        @if($QuizAttempt->has_passed)
                            <div class="alert alert-success">
                                <h1>Passed!</h1>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <h1>Failed!</h1>
                            </div>
                        @endif

                        <hr />

                        <p class="lead">
                            You took {{ $QuizAttempt->time_taken }} to complete the quiz!
                        </p>

                        <p>
                            You got <strong>{{ $QuizAttempt->correct_questions_count }}</strong> out of <strong>{{ $Quiz->Questions->count() }}</strong> questions correct.
                        </p>

                        <p>
                            You needed <strong>{{ $Quiz->pass_amount }}</strong> out of <strong>{{ $Quiz->Questions->count() }}</strong> correct questions to Pass.
                        </p>

                        <hr />

                        <h2>Summary of Questions</h2>

                        @foreach($QuizAttempt->QuizAttemptAnswers as $key => $Answer)
                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <strong>{{ $key+1 }}.</strong> {{ $Answer->Question->question }}
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-12 @if($Answer->Answer->is_correct) text-success @else text-danger @endif ">
                                    <strong>You Chose:</strong> {{ $Answer->Answer->answer }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('home') }}" class="btn btn-warning">Back to Home</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
