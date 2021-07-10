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
