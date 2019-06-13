@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body text-center">
                        <h2>Manage Users</h2>
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
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($Users as $User)
                                    <tr>
                                        <td>{{ $User->name }}</td>
                                        <td>{{ $User->Role->name }}</td>
                                        <td>
                                            @if(Auth::id() !== $User->id)
                                                <a href="{{ route('editUser', [$User]) }}" class="btn btn-info btn-sm mt-2">Edit</a>
                                                {!! $User->render_delete_button('deleteUser') !!}
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
                        <a href="{{ route('newUser') }}" class="btn btn-success float-right">New User</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
