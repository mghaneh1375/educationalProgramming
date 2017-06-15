
function generalChangeDegree(newDegree, lessonId, mode, selectedLesson, subjectId, mode2) {
    if(selectedLesson > 0) {
        $.ajax({
            type: 'post',
            url: 'getLessonsByChangingDegree',
            data: {
                degreeId: newDegree,
                mode: mode,
                selectedLesson : selectedLesson
            },
            success: function (response) {
                document.getElementById(lessonId).innerHTML = response;
                if(subjectId != '')
                    generalChangeLesson(document.getElementById(lessonId).value, subjectId, mode2);
            }
        });
    }
    else {
        $.ajax({
            type: 'post',
            url: 'getLessonsByChangingDegree',
            data: {
                degreeId: newDegree,
                mode: mode
            },
            success: function (response) {
                document.getElementById(lessonId).innerHTML = response;
                if(subjectId != '')
                    generalChangeLesson(document.getElementById(lessonId).value, subjectId, mode2);
            }
        });
    }
}

function generalChangeLesson(lessonId, subjectId, mode) {
    $.ajax({
        type: 'post',
        url: 'getSubjectsByChangingLesson',
        data: {
            lessonId : lessonId,
            mode : mode
        },
        success: function (response) {
            document.getElementById(subjectId).innerHTML = response;
        }
    });
}

function changeQuiz(newQuiz, stepId, subjectId) {
    $.ajax({
        type: 'post',
        url: 'getStepsByChangingQuiz',
        data: {
            quizId : newQuiz
        },
        success: function (response) {
            document.getElementById(stepId).innerHTML = response;
            if (subjectId != "")
                changeStage(newQuiz, document.getElementById(stepId).value, subjectId);
        }
    });
}

function changeStage(quizId, step, subjectId) {
    $.ajax({
        type: 'post',
        url: 'getSubjectsByChangingStep',
        data: {
            step : step,
            quizId : quizId
        },
        success: function (response) {
            response = JSON.parse(response);
            if(response.length == 0) {
                str = '<option value="-1">مبحثی موجود نیست</option>';
                document.getElementById(subjectId).innerHTML = str;
            }
            else {
                str = '';
                for (i = 0; i < response.length; i++) {
                    tmp = JSON.parse(response[i]);
                    str += '<div class="col-xs-12">';
                    str += "<span>" + tmp[0] + " (از صفحه ی  " + tmp[1] + " تا صفحه ی " + tmp[2] +  " )</span>";
                    str += '<button style="margin-right: 5px" onclick="deleteSelectedSubjectFromAssign(this.value, '+ quizId + ',' + step + ')" class="btn btn-danger"  value="' + tmp[3] + '" data-toggle="tooltip" title="حذف مبحث">';
                    str += '<span style="margin-left: 10%" class="glyphicon glyphicon-remove"></span>';
                    str += '</button>';
                    str += '</div>';
                }
                document.getElementById(subjectId).innerHTML = str;
            }
        }
    });
}

function deleteSelectedSubjectFromAssign(sid, quizId, step) {
    $.ajax({
        type: 'post',
        url: 'deleteSelectedSubjectFromAssign',
        data: {
            subjectId : sid,
            quizId : quizId,
            step : step
        },
        success: function (response) {
            changeStage(quizId, step, 'subjects');
        }
    });
}

function changeTag(subjectId, tagId, scheduleId, counter) {
    $.ajax({
        type: 'post',
        url: 'isThisTagProgrammable',
        data: {
            tagId : tagId,
            scheduleId : scheduleId,
            counter : counter
        },
        success: function (response) {
            if(response == 1) {
                document.getElementById(subjectId).style.visibility = "visible";
            }
            else
                document.getElementById(subjectId).style.visibility = "hidden";
        }
    });
}

function changeScheduleItem(subjectId, scheduleId, counter) {
    
    if(counter.length > 8)
        counter = counter.substr(8);


    $.ajax({
        type: 'post',
        url: 'changeScheduleItem',
        data: {
            scheduleId : scheduleId,
            counter : counter,
            subjectId : subjectId
        }
    });
}

function getDefaultValTagAndSubject(counter, scheduleId, level) {
    $.ajax({
        type: 'post',
        url: 'getDefaultTagAndSubject',
        data: {
            counter : counter,
            scheduleId : scheduleId,
            level : level
        },
        success: function (response) {
            tmp = JSON.parse(response);
            if(level == 1 || level == 2) {
                document.getElementById(counter).value = tmp[0];
                document.getElementById("subject_" + counter).value = tmp[1];
            }
            else if(level == 3) {
                document.getElementById(counter).innerHTML = tmp[0];
                document.getElementById("subject_" + counter).innerHTML = tmp[1];
                if(tmp[2] != 1) {
                    document.getElementById("subject_" + counter).innerHTML = "تعریف نشده";
                    document.getElementById("subject_" + counter).style.visibility = "visible";
                }
            }
            if(tmp[2] == 1) {
                document.getElementById("subject_" + counter).style.visibility = "visible";
            }
        }
    });
}

function addNewAssign(quiz, step, sid) {
    $.ajax({
        type: 'post',
        url: 'addNewAssign',
        data: {
            subjectId : sid,
            quizId : quiz,
            step : step
        },
        success: function (response) {
            document.getElementById('msg').innerHTML = '<center>' + response + '</center>';
        }
    });
}

function getMySchedules(userId, element, level) {
    $.ajax({
        type: 'post',
        url: 'getMySchedules',
        data: {
            userId : userId,
            level : level
        },
        success: function (response) {
            document.getElementById(element).innerHTML = response;
        }
    });
}

function createPDF(html) {
    $.ajax({
        type: 'post',
        url: 'createPDF',
        data: {
            html : html
        }
    });
}

function sendToTelegram(html, scheduleId) {
    $.ajax({
        type: 'post',
        url: 'sendToTelegram',
        data: {
            html : html,
            scheduleId : scheduleId
        },
        success: function(respose) {
            alert(respose);
        }
    });
}