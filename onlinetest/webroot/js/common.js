var fullScreenElement = document.documentElement;
var fullScreen = {
    open: function() {
        if (fullScreenElement.requestFullscreen) {
            fullScreenElement.requestFullscreen();
        } else if (fullScreenElement.webkitRequestFullscreen) { /* Safari */
            fullScreenElement.webkitRequestFullscreen();
        } else if (fullScreenElement.msRequestFullscreen) { /* IE11 */
            fullScreenElement.msRequestFullscreen();
        }
    },
    close: function () {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) { /* Safari */
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { /* IE11 */
            document.msExitFullscreen();
        }
    }
}

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
                    popup.alert('#', '', data.error, '')
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


    moveSelectedExamQuestion: function(questionId, oldExamId, newExamId, testName) {
        let result = confirm('Are you sure you want to move this question to a different test "' + testName + '"')

        if (result) {
            let url = '/Exams/moveQuestion/' + questionId + '/' + oldExamId + '/' + newExamId

            console.log(url)

            let dataType = 'json'

            $.ajax({
                type: "GET",
                url: url,
                success: function (data, obj) {
                    console.log(data.error);
                    exams.loadSelectedExamQuestions(oldExamId)

                    if (data.error) {
                        popup.alert('#', '', data.error)
                    } else {
                        // popup.alert('#', '', data.success)
                    }

                    // exams.loadSelectedExamQuestions(examId)
                    //location.reload();
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
    updateAnswer: function(userExamId, questionId, selectedOption, examId) {
        let url = '/UserExams/updateAnswer'
        let dataType = 'json'
        let csrfToken = $( "input[name='_csrfToken']" ).val()
        let data = {
            userExamId: userExamId,
            examQuestionId: questionId,
            selectedOption: selectedOption,
            examId: examId,
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

                $('#examQuestion-'+decodedQuestionId+'-'+selectedOption).fadeOut(100)
                    .fadeIn(100).fadeOut(100)
                    .fadeIn(100);
            },
            dataType: dataType,
        });
    },

    checkExamDuration: function(examId) {
        userExam.getUserExamTimeInfo(examId)

        setInterval(function() {
            userExam.getUserExamTimeInfo(examId)
        }, (30000));
    },

    getUserExamTimeInfo: function(examId) {
        $.ajax({
            type: "GET",
            url: '/UserExams/getUserExamTimeInfo/'+examId,
            success: function (data, obj) {
                if (data && data.userExamInfo) {
                    let duration = data.userExamInfo.duration
                    let examId = data.userExamInfo.exam_id
                    let time = data.userExamInfo.time
                    let text = (duration - time)

                    if (time >= duration) {
                        userExam.finishTest(examId);
                    }

                    $('#examTimeDisplay')
                        .text(text)
                        .fadeIn(100).fadeOut(100)
                        .fadeIn(100).fadeOut(100)
                        .fadeIn(100).fadeOut(100)
                        .fadeIn(100)

                    console.log(data.userExamInfo);
                }

                if (data && !data.userExamInfo) {
                    popup.endSession()
                }
            },
            dataType: 'json',
        });
    },


    getUserExamQAInfo: function(examId, questionNo) {
        if (!questionNo) {
            questionNo = '1'
        }

        $.ajax({
            type: "GET",
            url: '/UserExams/getUserExamQAInfo/'+examId+'/'+questionNo,
            success: function (data, obj) {
                $('#testInProgressDetails').html(data)

                console.log(data.userExamInfo);
            },
            dataType: 'html',
        });
    },

    finishTest: function(examId) {
        let url = '/UserExams/finishTest/'+btoa(examId)
        popup.alert(url, 'Time up!', 'Your exam time is over', '')
    },

    clearUserExamSession: function(examId) {
        $.ajax({
            type: "GET",
            url: '/UserExams/clearUserExamSession/'+examId,
            success: function (data, obj) {
                console.log('User previous session is cleared')
                // alert('Your exam time is over.')
                // window.location = '/UserExams/finishTest/'+btoa(examId)
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

var popup = {
    confirm: function(url, title = '', content = '', okText = '') {
        let confirmPopup;

        title = title ? title : '';
        content = content ? content : 'Are you sure?';
        okText = okText ? okText : 'Ok';

        $("#confirmPopup .modal-content .modal-header .modal-title").html(title);
        $("#confirmPopup .modal-content .modal-body .content").html(content);
        $("#confirmPopup .modal-footer .ok").html(okText);

        $("#confirmPopup .modal-content .modal-header").show();
        if (title == '') {
            $("#confirmPopup .modal-content .modal-header").hide();
        }

        if ('#' !== url) {
            $("#confirmPopup .modal-content .actionLink").attr('href', url);
            $("#confirmPopup .modal-content .actionLink").removeClass('d-none');
            $("#confirmPopup .modal-content .cancelButton").removeClass('d-none');
            $("#confirmPopup .modal-content .actionLinkButton").addClass('d-none');
        } else {
            $("#confirmPopup .modal-content .actionLink").addClass('d-none');
            $("#confirmPopup .modal-content .cancelButton").addClass('d-none');
            $("#confirmPopup .modal-content .actionLinkButton").removeClass('d-none');
        }

        confirmPopup = new bootstrap.Modal(document.getElementById('confirmPopup'), {
            keyboard: false,
            backdrop: 'static'
        });

        confirmPopup.show();
    },

    alert: function(url, title = '', content = '', okText = '') {
        let alertPopup;

        title = title ? title : '';
        content = content ? content : '...';
        okText = okText ? okText : 'Ok';

        $("#alertPopup .modal-content .modal-header .modal-title").html(title);
        $("#alertPopup .modal-content .modal-body .content").html(content);
        $("#alertPopup .modal-footer .ok").html(okText);

        $("#alertPopup .modal-content .modal-header").show();
        if (title == '') {
            $("#alertPopup .modal-content .modal-header").hide();
        }

        if ('#' !== url) {
            $("#alertPopup .modal-content .actionLink").attr('href', url);
            $("#alertPopup .modal-content .actionLink").removeClass('d-none');
            $("#alertPopup .modal-content .actionLinkButton").addClass('d-none');
        } else {
            $("#alertPopup .modal-content .actionLink").addClass('d-none');
            $("#alertPopup .modal-content .actionLinkButton").removeClass('d-none');
        }

        alertPopup = new bootstrap.Modal(document.getElementById('alertPopup'), {
            keyboard: false,
            backdrop: 'static'
        });

        alertPopup.show();
    },

    endSession: function () {
        popup.alert('/Users/logout', 'Session Timeout!', 'Your session has timed out.', '')
        setInterval(function() {
            window.location = '/Users/logout'
        }, (5000));
    }
}


