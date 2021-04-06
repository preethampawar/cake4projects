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

var userExam = {
    updateAnswer: function(userExamId, questionId, selectedOption) {
        let url = '/UserExams/updateAnswer'
        let dataType = 'json'
        let csrfToken = $( "input[name='_csrfToken']" ).val()
        let data = {
            userExamId: userExamId,
            examQuestionId: questionId,
            selectedOption: selectedOption,
            _csrfToken: csrfToken
        }
        let decodedQuestionId = atob(questionId)

        $('.examQuestion-'+decodedQuestionId).removeClass('text-success');
        $('.examQuestion-'+decodedQuestionId).removeClass('fw-bold');

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data, obj) {
                $('#examQuestion-'+decodedQuestionId+'-'+selectedOption).addClass('text-success fw-bold');

                $('#examQuestion-'+decodedQuestionId+'-'+selectedOption).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
            },
            dataType: dataType,
        });
    },

    checkExamDuration: function(examId) {
        userExam.getUserExamInfo(examId)

        setInterval(function() {
            userExam.getUserExamInfo(examId)
        }, (30000));
    },

    getUserExamInfo: function(examId) {
        $.ajax({
            type: "GET",
            url: '/UserExams/getUserExamInfo/'+examId,
            success: function (data, obj) {
                if (data && data.userExamInfo) {
                    let duration = data.userExamInfo.duration
                    let examId = data.userExamInfo.exam_id
                    let time = data.userExamInfo.time
                    let text = (duration - time) + ' mins';

                    if (time >= duration) {
                        userExam.clearUserExamSession(examId);
                    }

                    $('#examTimeDisplay')
                        .text(text)
                        .fadeIn(100).fadeOut(100)
                        .fadeIn(100).fadeOut(100)
                        .fadeIn(100).fadeOut(100)
                        .fadeIn(100)

                    console.log(data.userExamInfo);
                }
            },
            dataType: 'json',
        });
    },

    clearUserExamSession: function(examId) {
        $.ajax({
            type: "GET",
            url: '/UserExams/clearUserExamSession/'+examId,
            success: function (data, obj) {
                alert('Your exam time is over.')
                window.location = '/UserExams/myResult/'+btoa(examId)
            },
            dataType: 'json',
        });
    }

}

var subjects = {
    add: function () {
        let url = '/Subjects/add'
        let dataType = 'json'
        let csrfToken = $( "input[name='_csrfToken']" ).val()
        let data = {
            name: $('#addSubjectField').val().trim(),
            _csrfToken: csrfToken
        }

        $('#addSubjectErrorDiv').text('').addClass('d-none')

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data, obj) {
                console.log(data);
                if (data.error && data.error != null) {
                    $('#addSubjectErrorDiv').html(data.error).removeClass('d-none')
                } else {
                    if (data.subjectsDropDown != '') {
                        $('#subjectDivAddQuestionForm').html(data.subjectsDropDown)

                        $('#closeAddSubjectPopup').click()
                    }
                }

            },
            dataType: dataType,
        });
    }
}


var educationLevels = {
    add: function () {
        let url = '/EducationLevels/add'
        let dataType = 'json'
        let csrfToken = $( "input[name='_csrfToken']" ).val()
        let data = {
            name: $('#addEducationLevelField').val().trim(),
            _csrfToken: csrfToken
        }

        $('#addEducationLevelErrorDiv').text('').addClass('d-none')

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data, obj) {
                console.log(data);
                if (data.error && data.error != null) {
                    $('#addEducationLevelErrorDiv').html(data.error).removeClass('d-none')
                } else {
                    if (data.educationLevelsDropDown != '') {
                        $('#educationLevelDivAddQuestionForm').html(data.educationLevelsDropDown)

                        $('#closeAddEducationLevelPopup').click()
                    }
                }

            },
            dataType: dataType,
        });
    }
}


var tags = {
    add: function () {
        let url = '/Tags/add'
        let dataType = 'json'
        let csrfToken = $( "input[name='_csrfToken']" ).val()
        let data = {
            name: $('#addTagField').val().trim(),
            selectedTags: $('#tags').val(),
            _csrfToken: csrfToken
        }

        $('#addTagErrorDiv').text('').addClass('d-none')

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data, obj) {
                console.log(data);
                if (data.error && data.error != null) {
                    $('#addTagErrorDiv').html(data.error).removeClass('d-none')
                } else {
                    if (data.tagsDropDown != '') {
                        $('#tagsDivAddQuestionForm').html(data.tagsDropDown)

                        $('#tags').select2({
                            placeholder: 'Select an option'
                        });

                        $('#closeAddTagsPopup').click()
                    }
                }

            },
            dataType: dataType,
        });
    }
}

var social = {
    shareDialog: function(modalId, encodedUrl, encodedTitle) {
        if (navigator.share) {
            navigator.share({
                title: 'Share Online Test - ' + encodedTitle,
                url: encodedUrl
            }).then(() => {
                console.log('Thanks for sharing!');
            })
            .catch(console.error);
        } else {
            let myModal = new bootstrap.Modal(document.getElementById(modalId), {
                keyboard: false
            })
            myModal.show()
        }
    },

    share: function(media, encodedUrl, encodedTitle) {

        switch (media) {
            case 'facebook':
                shareUrl = 'http://www.facebook.com/sharer.php?u=' + encodedUrl
                break
            case 'twitter':
                shareUrl = 'http://twitter.com/share?text=' + encodedTitle + '&url=' + encodedUrl
                break
            case 'email':
                shareUrl = 'mailto:?subject=' + encodedTitle + '&body=Check out this online test ' + encodedUrl
                break
            case 'whatsapp':
                shareUrl = 'https://wa.me/?text=Online Test - ' + encodedTitle + ' ' + encodedUrl
                break
            default:
                shareUrl = ''
                break
        }

        window.open(shareUrl,'sharer','toolbar=0,status=0,width=500,height=400');
        return true;
    }
}

var copy = {
    text: function copyToClipboard(element) {
        let text = $(element).select();
        if(document.execCommand("copy")) {
            alert('Link copied')
        }
    }
}

