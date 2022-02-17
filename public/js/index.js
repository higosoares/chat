$(document).ready(function() {
    let selected_user;

    configureAjax();
    userOnClick();
    enableListenerEvent();

    $(document).on('keyup', '.input-text input', function (e) {
        let text = $(this).val();

        if (e.keyCode == 13 && text != '' && selected_user != '') {
            chat.sendMessage($(this), text, selected_user);
        }
    });

    function userOnClick() {
        $('.users .user').click(function(e) {
            selected_user = $(this).attr('id').split('user-')[1];

            chat.getMessages(selected_user);
            chat.removeClassesUser($(this));
        });
    }

    function configureAjax() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    function enableListenerEvent() {
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('4076c735f96bdfd2f0cd', {
            cluster: 'us2'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            chat.notifyUsers(auth_user, selected_user, data.message);
        });
    }
});
