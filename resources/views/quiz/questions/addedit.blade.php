@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body text-center">
                        @if($Question)
                            <h1>Edit Question</h1>
                        @else
                            <h1>Create Question</h1>
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
                                        <label for="question">Question <span class="text-danger">*</span></label>
                                        <input class="form-control{{ $errors->has('question') ? ' is-invalid' : '' }}" type="text" id="question" name="question" placeholder="Question" value="{{ old('question') ?? $Question->question ?? null }}" required />
                                        @if ($errors->has('question'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('question') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <button type="button" class="btn btn-primary float-right mb-2 addAnswerButton">Add Answer</button>

                                        <table class="table table-bordered table-hover" id="answerTable">
                                            <thead>
                                                <tr>
                                                    <th>Answer</th>
                                                    <th>Correct</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="no_rows_row">
                                                    <td colspan="3" class="text-center">
                                                        <strong>No Answers</strong>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            @if ($errors->has('answer'))
                                <div class="row mb-5">
                                    <div class="col-sm-12">
                                        <span class="alert alert-danger" role="alert">
                                            <strong>{{ $errors->first('answer') }}</strong>
                                        </span>
                                    </div>
                                </div>
                            @endif


                            @if ($errors->has('correct'))
                                <div class="row mb-5">
                                    <div class="col-sm-12">
                                        <span class="alert alert-danger" role="alert">
                                            <strong>{{ $errors->first('correct') }}</strong>
                                        </span>
                                    </div>
                                </div>
                            @endif


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

    <script>

        var col_count = 0;

        function addAnswer(value = null, correct = null) {
            $('#no_rows_row').hide();
            col_count++;

            var row = $('<tr>').appendTo('#answerTable thead');

            var question_col = $('<td>').appendTo(row);
            var question_input = $('<input />')
            .prop('type', 'text')
            .prop('name', 'answer['+ col_count +']')
            .prop('required', true)
            .addClass('form-control')
            .val(value)
            .appendTo(question_col);

            var correct_col = $('<td>').appendTo(row);

            var correct_div = $('<div>').addClass('form-check').appendTo(correct_col);
            var correct_input = $('<input />')
            .prop('type', 'checkbox')
            .prop('name', 'correct['+ col_count +']')
            .addClass('form-check-input')
            .prop('checked', correct)
            .appendTo(correct_div);

            var options_col = $('<td>').appendTo(row);
            var deleteButton = $('<button>')
            .addClass('deleteAnswerButton btn btn-danger')
            .text('Delete')
            .prop('type', 'button')
            .appendTo(options_col);
        }

        @if (old('answer'))
            @foreach(old('answer') as $key => $value)
                addAnswer('{{ $value }}', {{ old('correct')[$key] == "on" ? 1 : 0 }});
            @endforeach
        @endif

        @if($Question && $Question->Answers)
            @foreach($Question->Answers as $Answer)
                addAnswer('{{ $Answer->answer }}', {{ $Answer->is_correct }});
            @endforeach
        @endif

        $(document).ready(function () {
            $('.addAnswerButton').click(function () {
                addAnswer();
            });
        });

        $(document).on('click', '.deleteAnswerButton', function () {
            var row = $(this).closest('tr').remove();
            col_count--;

            if (col_count == 0) {
                $('#no_rows_row').show();
            }
        });

    </script>
@endsection
