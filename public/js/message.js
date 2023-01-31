const message = {
    get: async function(id) {
        return api.get(`message/user/${id}`);
    },

    getNews: async function() {
        return api.get(`message/user/${id}/news`);
    },

    send: async function(text, id) {
        return api.post('message', { text: text, receiver_id: id });
    },

    delete: async function(id) {
        return api.post(`message/${id}`, {}, 'delete');
    },

    populate: function(list, div, data) {
        if (list.find(`#message-${data.id}`).length == 0) {
            div.attr('id', `message-${data.id}`);
            div.addClass(!data.show_button ? 'deleted' : '');
            div.find('.text').text(data.text);
            div.find('.date').text(data.created_at);
            div.find('.type-user').addClass(authUser == data.receiver_id ? 'received' : 'sent');
            div.find('svg').attr('data-id', data.id);

            if (data.deleted_at) {
                div.find('.date').text('');
                div.find('.text').addClass('deleted');
            }

            list.append(div);
        }
    },
};
