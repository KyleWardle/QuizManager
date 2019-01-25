@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body text-center">
                        @if($Quiz)
                            <h1>Edit Quiz</h1>
                        @else
                            <h1>Create Quiz</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <form action="{{ $formurl }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" type="text" id="title" name="title" placeholder="Title" value="{{ old('title') ?? $Quiz->title ?? null }}" required />
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="description">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" rows="5" id="description" name="description" placeholder="Description" required>{{ old('description') ?? $Quiz->description ?? null }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="pass_amount">How many correct questions are required for a pass? <span class="text-danger">*</span></label>
                                        <input class="form-control{{ $errors->has('pass_amount') ? ' is-invalid' : '' }}" type="text" id="pass_amount" name="pass_amount" placeholder="Pass Amount" value="{{ old('pass_amount') ?? $Quiz->pass_amount ?? null }}" required />
                                        @if ($errors->has('pass_amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('pass_amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
