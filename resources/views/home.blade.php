@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body text-center">
                        <h1>Quiz Manager</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Options</h3>
                    </div>
                    <div class="card-body">
                        @if(Auth::user()->is_teacher)
                            <div class="row">
                                <div class="col-sm-12">
                                        <a href="{{ route('createQuiz') }}" class="btn btn-info">Create New Quiz</a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-12">
                                    <a href="{{ route('manageUsers') }}" class="btn btn-warning">Manage Users</a>
                                </div>
                            </div>
                        @endif

                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <a href="{{ route('myAttempts') }}" class="btn btn-success">My Quiz Attempts</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Current Quizes</h3>
                    </div>
                    <div class="card-body">
                        @if(count($Quizes) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Created Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($Quizes as $Quiz)
                                            <tr>
                                                <td>{{ $Quiz->title }}</td>
                                                <td>{{ $Quiz->description }}</td>
                                                <td>{{ $Quiz->created_at_display_date_time }}</td>
                                                <td>
                                                    <a href="{{ route('startQuiz', $Quiz->id) }}" class="btn btn-primary btn-sm mt-2">Take Quiz</a>
                                                    @if(Auth::user()->is_teacher)
                                                        <a href="{{ route('quizAttempts', $Quiz->id) }}" class="btn btn-success btn-sm mt-2">Attempts</a>
                                                        <a href="{{ route('manageQuestions', $Quiz->id) }}" class="btn btn-info btn-sm mt-2">Manage Questions</a>
                                                        <a href="{{ route('editQuiz', $Quiz->id) }}" class="btn btn-warning btn-sm mt-2">Edit</a>
                                                        {!! $Quiz->render_delete_button('deleteQuiz', 'title') !!}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="lead">
                                None Found!
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
