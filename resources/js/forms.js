jQuery('#save_form_button').click(function(event) {
    event.preventDefault();
    if ((jQuery('#book-name').val() == '') || (jQuery('#book-year').val() == '')) {
        addToast('Please fill al fields', 'danger');
    } else if (jQuery('#book_id').val() == '') {
        jQuery.ajax({
                url: '/api/books',
                data: jQuery('#save-book-form').serialize(),
                type: 'json',
                method: 'POST'
            })
            .done(function(response) {
                addToast('Book saved successfully!', 'success');
            })
            .fail(function(response) {
                message = response.responseJSON;
                addToast('An error has occurred, please review the information: ' + message.message, 'danger');
            });
    } else {
        jQuery.ajax({
                url: '/api/books/' + jQuery('#book_id').val(),
                data: jQuery('#save-book-form').serialize(),
                type: 'json',
                method: 'PUT'
            })
            .done(function(response) {
                addToast('Book saved successfully!', 'success');
            })
            .fail(function(response) {
                message = response.responseJSON;
                addToast('An error has occurred, please review the information: ' + message.message, 'danger');
            });
    }

    jQuery('#books-table').bootstrapTable('refresh');
});

jQuery("#author-name").autocomplete({
    source: "/api/authors/autocomplete",
    minLength: 2,
    select: function(event, ui) {
        $("#author-birth").val(ui.item.date);
    }
});

jQuery("#libraries").autocomplete({
    source: "/api/libraries/autocomplete",
    minLength: 2,
    select: function(event, ui) {
        jQuery('#librarieslist').append('<span id="library' + ui.item.id + '"><input type="hidden" name="library[]" value="' + ui.item.id + '">Library: ' + ui.item.label + ', Address: ' + ui.item.address + '<i class="fa-solid fa-circle-xmark" data-id="' + ui.item.id + '"></i></span>');
        jQuery('#libraries').val('');
        jQuery('#librarieslist #library' + ui.item.id + '  i').click(function(event) { jQuery('#librarieslist #library' + ui.item.id).remove() });
    }
});

jQuery('#link_new_library').click(function(event) {
    event.preventDefault();

    jQuery('#new_library').slideToggle();
});

jQuery('#save_library').click(function(event) {
    event.preventDefault();

    jQuery.ajax({
            url: '/api/libraries',
            data: 'name=' + jQuery('#library-name').val() + '&address=' + jQuery('#library-address').val(),
            type: 'json',
            method: 'POST'
        })
        .done(function(response) {
            addToast('Library saved successfully!', 'success');

            jQuery('#new_library').slideToggle();

            jQuery('#librarieslist').append('<span id="library' + response.id + '"><input type="hidden" name="library[]" value="' + response.id + '">Library: ' + jQuery('#library-name').val() + ', Address: ' + jQuery('#library-address').val() + '<i class="fa-solid fa-circle-xmark" data-id="' + response.id + '"></i></span>');
            jQuery('#libraries').val('');
            jQuery('#librarieslist #library' + response.id + '  i').click(function(event) { jQuery('#librarieslist #library' + response.id).remove() });
        })
        .fail(function(response) {
            message = response.responseJSON;
            addToast('An error has occurred, please review the information: ' + message.message, 'danger');
        });
});
