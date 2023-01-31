const chat = {
    getMessages: function(id) {
        message.get(id, offset).then(data => {
            $('.messages-wrapper').removeClass('hidden');
            chat.populate(id, data.read, '.read');
            chat.populate(id, data.unread,'.unread');
        });
    },

    sendMessage: function(div, text, id) {
        message.send(text,id).then(_ => {
            div.val('');
        });
    },

    populate: function(idUser, messages, classList) {
        $('.messages').addClass('hidden');
        let divMessages = $(`#messages-user-${idUser}`);
        let divMessagesModel = $('.messages-model');

        if (divMessages.length == 0) {
            let divMessage = divMessagesModel.clone();
            let list = divMessage.find(classList);
            let itemMessageModel = divMessage.find('.message-model');
            let loading = divMessage.find('.loading');

            divMessage.attr('id', `messages-user-${idUser}`);
            divMessage.removeClass('hidden');
            divMessage.removeClass('messages-model');
            divMessagesModel.after(divMessage);

            const items = new Promise((resolve) => {
                let count = 0;

                $.map(messages, function (message) {
                    let clone = itemMessageModel.clone();

                    chat.populateMessage(list, clone, message);
                    count++;
                });

                resolve(count);
            });

            items.then(result => {
                if (result == messages.length) {
                    loading.remove();
                    //divMessage.find('.message-model').remove();
                    divMessage.removeClass('hidden');
                    list.removeClass('hidden');
                    chat.scrollToBottom(idUser);
                    $('.input-text').attr('style', '');
                }
            });
        } else {
            let list = divMessages.find(classList);
            let itemMessageModel = divMessages.find('.message-model');

            $.map(messages, function (message) {
                let clone = itemMessageModel.clone();

                chat.populateMessage(list, clone, message);

            });

            if (classList == '.unread' && messages.length > 0) {
                divMessages.find('.separator-messages').removeClass('hidden');
            }

            divMessages.removeClass('hidden');
        }
    },

    populateMessage: function(list, div, data) {
        if (list.find(`#message-${data.id}`).length == 0) {
            message.populate(list, div, data);
            chat.removeClassesMessage(div);
        }
    },

    removeClassesMessage: function(div, classModel = 'message-model') {
        div.removeClass(classModel);
        div.removeClass('hidden');
    },

    removeClassesUser: function(div) {
        $('.messages-wrapper').removeClass('hidden');
        $('.users .user').removeClass('active');
        div.addClass('active');
        div.find('.pending').addClass('hidden');
    },

    notifyUsers: function(myUserId, selectedUserId, message) {
        if (myUserId == message.sender_id) {
            chat.simulateClickUser(message.receiver_id);
        } else if (myUserId == message.receiver_id && selectedUserId == message.sender_id) {
            chat.simulateClickUser(message.sender_id);
        } else {
            chat.addNotificationUser(message.sender_id);
        }
    },

    simulateClickUser: function(userId) {
        $(`#user-${userId}`).click();
    },


    addNotificationUser: function(userId) {
        let pending = $(`#user-${userId}`).find('.pending');

        if (pending.is(':visible')) {
            pending.text(parseInt(pending.text()) + 1);
        } else {
            pending.text(1);
            pending.removeClass('hidden');
        }
    },

    scrollToBottom: function(idUser) {
        let divMessages = $(`.messages-wrapper #messages-user-${idUser}`);

        divMessages.animate({
            scrollTop: divMessages.find('ul').height()
        }, 50);
    },

    deleteMessage: function(id) {
        alert.showConfirm({
            title: 'Você deseja apagar esta mensagem?'
        }).then((result) => {
            if (result.isConfirmed) {
                let div = $(`#message-${id}`);

                message.delete(id).then(() => {
                    div.find('.date').text('');
                    div.find('.text').addClass('deleted');
                    div.find('.text').text('Mensagem excluída');
                    div.addClass('deleted');
                    alert.show({
                        title: 'Sucesso',
                        text: 'Mensagem apagada!',
                        type: 'success'
                    });
                }).catch(() => {
                    alert.show({
                        title: 'Erro',
                        text: 'Erro ao apagar a mensagem. Tente novamente.',
                        type: 'error'
                    });
                });
            }
        });
    }
};
