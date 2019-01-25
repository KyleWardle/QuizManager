@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body text-center">
                        <h2>Start Quiz : {{ $Quiz->title }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="lead">
                            This Quiz has <strong>{{ $Quiz->Questions->count() }}</strong> Questions.
                        </p>

                        <p class="lead">
                            You must get at least <strong>{{ $Quiz->pass_amount }} Questions correct to pass.</strong>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('home') }}" class="btn btn-warning">Back</a>
                        <a href="{{ route('submitStartQuiz', $Quiz->id) }}" class="btn btn-success float-right">Start Quiz</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
