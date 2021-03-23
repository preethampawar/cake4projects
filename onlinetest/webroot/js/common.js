var exams = {
    loadSelectedExamQuestions: function(examId) {
        let url = '/exams/loadSelectedExamQuestions/' + examId
        let dataType = 'html'

        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                $('#examSelectedQuestions').html(data)
            },
            dataType: dataType,
        });
    },

    addExamQuestion: function(examId, questionId) {
        console.log(examId, questionId)

        let url = '/exams/addSelectedQuestion'
        let dataType = 'json'
        let csrfToken = $( "input[name='_csrfToken']" ).val();
        let data = {
            exam_id: examId,
            question_id:questionId,
            _csrfToken: csrfToken
        }

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data, obj) {
                if (data.error && data.error.length > 0) {
                    alert(data.error)
                } else {
                    exams.loadSelectedExamQuestions(examId)
                }
            },
            dataType: dataType,
        });
    },

    deleteSelectedExamQuestion: function(examId, examQuestionId) {
        let result = confirm('Are you sure you want to remove this question from this exam?')

        if (result) {
            let url = '/exams/deleteSelectedExamQuestion'
            let dataType = 'json'
            let csrfToken = $( "input[name='_csrfToken']" ).val();
            let data = {
                examQuestionId: examQuestionId,
                _csrfToken: csrfToken
            }

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function (data, obj) {
                    // exams.loadSelectedExamQuestions(examId)
                    location.reload();
                },
                dataType: dataType,
            });
        }
    },

    disableAddButtonInQuestionBank: function(questionId) {
        console.log(questionId)
        $("#addQuestionButton"+questionId).hide()
        $("#addQuestionRow"+questionId).addClass('disabledElement')
    },
}

