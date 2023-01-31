$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const api = {
    get: async function(url) {
        return $.ajax({
            type: 'get',
            url: url,
        });
    },

    post: async function(url, data, type = 'post') {
        return $.ajax({
            type: type,
            url: url,
            data: data,
            cache: false
        });
    }
};
