@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body text-center">
                        <h2>Take Quiz : {{ $Quiz->title }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body text-center">

                        <div id="question_area">
                            <strong id="question_text_area"></strong>

                            <div id="question_answers_area">


                            </div>

                        </div>


                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-success float-right" id="submitAnswerButton">Submit</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('customjavascript')

    <script>

        $(document).ready(function () {
            grabNextQuestion();

            function grabNextQuestion() {
                $('#question_text_area').html("");
                $('#question_answers_area').html("");

                $.ajax({
                    url: '{{ route('grabNextQuestion', [$Quiz->id, $QuizAttempt->id]) }}',
                    type: 'POST',
                })
                .done(function(data) {
                    var question = JSON.parse(data.question);
                    displayQuestion(question);
                })
                .fail(function(data) {
                    console.log("error");
                    console.log(data);
                });


            }

            function displayQuestion(question) {
                $('#question_text_area').data('question-id', question.id).html(question.question);
                var answers = question.answers;
                $.each(answers, function (index, element) {
                    var radio = generateRadioInput(element);
                    radio.appendTo('#question_answers_area');

                });
            }

            function generateRadioInput(element) {
                var form_check = $('<div>').addClass('form-check');
                var label = $('<label>').addClass('form-check-label').appendTo(form_check);
                var input = $('<input>').prop('type', 'radio').val(element.id).prop('name', 'radio_input').addClass('form-check-input').appendTo(label);
                var span = $('<span>').text(element.answer).appendTo(label);

                return form_check;
            }

            function saveAnswer() {
                var question_id = $('#question_text_area').data('question-id');
                var answer_id = $('input[type="radio"][name="radio_input"]:checked').val();

                $.ajax({
                    url: '{{ route('saveQuizAnswer', [$Quiz->id, $QuizAttempt->id]) }}',
                    type: 'POST',
                    data: {question_id, answer_id}
                })
                .done(function(data) {
                    if(data.quiz_finished) {
                        location = "{{ route('quizSummary', [$Quiz->id, $QuizAttempt->id]) }}";
                    } else {
                        grabNextQuestion();
                    }

                })
                .fail(function(data) {
                    console.log("error");
                    console.log(data);
                });
            }

            $('#submitAnswerButton').click(function () {
                saveAnswer();
            });

        });

    </script>

@endsection
