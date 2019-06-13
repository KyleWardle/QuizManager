@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body text-center">
                        <h2>Quiz Attempts</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body text-center">
                        @if(count($QuizAttempts) > 0)
                            <div class="table-responsive">

                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Score</th>
                                        <th>Time Taken</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($QuizAttempts as $Attempt)
                                        <tr @if($Attempt->has_passed) class="table-success" @else class="table-danger" @endif >
                                            <td>{{ $Attempt->created_at_display_date_time }}</td>
                                            <td>{{ $Attempt->User->name }}</td>
                                            <td>{{ $Attempt->correct_questions_count }} / {{ $Attempt->Quiz->Questions->count() }}</td>
                                            <td>{{ $Attempt->time_taken }}</td>
                                            <td>
                                                @if ($Attempt->quiz_end_time)
                                                        <a href="{{ route('quizSummary', [$Attempt->quiz_id, $Attempt->id]) }}" class="btn btn-info btn-sm">View Summary</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        @else
                            <div class="alert alert-info">
                                No Attempts.
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('home') }}" class="btn btn-warning">Back</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
