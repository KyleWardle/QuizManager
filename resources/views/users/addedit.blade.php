@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body text-center">
                        <h1>@if(isset($User)) Edit @else Create @endif User</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <form action="{{ $formurl }}" method="POST">
                    @csrf
                    @method(isset($User) ? 'patch' : 'post')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" id="name" name="name" placeholder="Name" value="{{ old('name') ?? $User->name ?? null }}" required />
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @if(!isset($User))

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" id="email" name="email" placeholder="Email" value="{{ old('email') ?? $User->email ?? null }}" required />
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="role_id">Role <span class="text-danger">*</span></label>
                                        <select class="form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}" id="role_id" name="role_id" required>
                                            <option value=""></option>
                                            @foreach($Roles as $Role)
                                                <option
                                                        @if(old('role_id'))
                                                            @if(old('role_id') == $Role->id)
                                                                selected
                                                            @endif
                                                        @else
                                                            @if(isset($User) && $User->role_id === $Role->id)
                                                                selected
                                                            @endif
                                                        @endif
                                                        value="{{ $Role->id }}">{{ $Role->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('role_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('role_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(!isset($User))

                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password">Password <span class="text-danger">*</span></label>
                                            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" id="password" name="password" placeholder="Password" required />
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password<span class="text-danger">*</span></label>
                                            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required />
                                            @if ($errors->has('password_confirmation'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            @else
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-danger">
                                            To change a password, the user must go through the 'Forgot Password' flow!
                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ url()->previous() }}" class="btn btn-warning">Back</a>
                                    <button class="btn btn-success float-right" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
