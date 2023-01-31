const alert = {
    showConfirm: function(options) {
        return Swal.fire({
            title: options.title,
            showCancelButton: true,
            confirmButtonText: 'Confirm',
        });
    },

    show: function(options) {
        Swal.fire(options.title, options.text, options.type);
    }
}
