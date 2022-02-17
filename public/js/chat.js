const chat = {
    getMessages: function(id) {
        $.ajax({
            type: 'get',
            url: `message/user/${id}`,
            success: function (data) {
                chat.populateMessages(data.messages);
            }
        });
    },

    sendMessage: function(div, text, id) {
        $.ajax({
            type: 'post',
            url: 'message',
            data: { text: text, receiver_id: id },
            cache: false,
            success: function () {
                div.val('');
            }
        })
    },

    populateMessages: function(messages) {
        let list = $('.messages ul'), divMessageModel = $('.message-model');

        list.find('li:not([class*="message-model"])').remove();

        $.map(messages, function (message) {
            let clone = divMessageModel.clone();

            chat.populateMessage(list, clone, message);
        });
    },

    populateMessage: function(list, div, message) {
        div.attr('id', `message-${message.id}`);
        div.find('.text').text(message.text);
        div.find('.date').text(message.created_at);
        div.find('.type_user').addClass(auth_user == message.receiver_id ? 'received' : 'sent');

        list.append(div);
        chat.removeClassesMessage(div);
        chat.scrollToBottom();
    },

    removeClassesMessage: function(div) {
        div.removeClass('message-model');
        div.removeClass('hidden');
    },

    removeClassesUser: function(div) {
        $('.messages-wrapper').removeClass('hidden');
        $('.users .user').removeClass('active');
        div.addClass('active');
        div.find('.pending').addClass('hidden');
    },

    notifyUsers: function(auth_user, selected_user, message) {
        if (auth_user == message.sender_id) {
            chat.simulateClickUser(message.receiver_id);
        } else if (auth_user == message.receiver_id && selected_user == message.sender_id) {
            chat.simulateClickUser(message.sender_id);
        } else {
            chat.addNotificationUser(message.sender_id);
        }
    },

    simulateClickUser: function(user_id) {
        $(`#user-${user_id}`).click();
    },


    addNotificationUser: function(user_id) {
        let pending = $(`#user-${user_id}`).find('.pending');

        if (pending.is(':visible')) {
            pending.text(parseInt(pending.text()) + 1);
        } else {
            pending.text(1);
            pending.removeClass('hidden');
        }
    },

    scrollToBottom: function() {
        let divMessages = $('.messages-wrapper .messages');

        divMessages.animate({
            scrollTop: divMessages.find('ul').height()
        }, 50);
    }
};
