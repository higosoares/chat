let offset = 0;

$(document).ready(function() {
    let selectedUser;

    userOnClick();
    enableListenerEvent();
    sendMessageKeyUp();
    deleteMessageOnClick();

    function sendMessageKeyUp() {
        $(document).on('keyup', '.input-text input', function (e) {
            let text = $(this).val();

            if (e.keyCode == 13 && text != '' && selectedUser != '') {
                chat.sendMessage($(this), text, selectedUser);
            }
        });
    }

    function userOnClick() {
        $('.users .user').click(function() {
            let idUser = $(this).attr('id').split('user-')[1];

            if (selectedUser != idUser) {
                offset = 0;
            }

            selectedUser = idUser;

            chat.getMessages(selectedUser);
            chat.removeClassesUser($(this));
        });
    }

    function enableListenerEvent() {
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        let pusher = new Pusher('4076c735f96bdfd2f0cd', {
            cluster: 'us2'
        });

        let channel = pusher.subscribe('my-channel');

        channel.bind('my-event', function(data) {
            chat.notifyUsers(authUser, selectedUser, data.message);
        });
    }

    function deleteMessageOnClick() {
        $(document).on('click', '.messages-wrapper .messages ul li.message svg', function() {
            chat.deleteMessage($(this).attr('data-id'));
        });
    }
});
