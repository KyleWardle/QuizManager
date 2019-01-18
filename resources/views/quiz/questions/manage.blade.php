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
                                    @foreach($Quiz->Questions as $Question)
                                        <tr>
                                            <td>{{ $Question->question }}</td>
                                            <td>{{ $Question->Answers->count() }}</td>
                                            <td> <a href="{{ route('editQuestion', [$Quiz->id, $Question->id]) }}" class="btn btn-info btn-sm">Edit</a> </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('home') }}" class="btn btn-warning">Back</a>
                        <a href="{{ route('newQuestion', $Quiz->id) }}" class="btn btn-success float-right">New Question</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
