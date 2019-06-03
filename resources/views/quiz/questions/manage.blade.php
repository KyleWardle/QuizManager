@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body text-center">
                        <h2>Manage Questions for Quiz : {{ $Quiz->title }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="table-responsive">

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Question</th>
                                        <th>No. of Answers</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Quiz->Questions as $key => $Question)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $Question->question }}</td>
                                            <td>{{ $Question->Answers->count() }}</td>
                                            <td>
                                                <a href="{{ route('editQuestion', [$Quiz->id, $Question->id]) }}" class="btn btn-info btn-sm">Edit</a>
                                            @if(Auth::user()->can_edit)
                                                <a href="{{ route('deleteQuestion', [$Quiz->id, $Question->id]) }}" class="btn btn-danger btn-sm">Delete</a>
                                            @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('home') }}" class="btn btn-warning">Back</a>
                        @if(Auth::user()->can_edit)
                            <a href="{{ route('newQuestion', $Quiz->id) }}" class="btn btn-success float-right">New Question</a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
