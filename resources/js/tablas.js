jQuery(document).ready(function() {
    function loadLibraries(value) {
        jQuery.ajax({
                url: '/api/libraries?book=' + value,
                type: 'GET',
                dataType: 'json'
            }).done(function(response) {
                jQuery('#libraries-table tbody').html('');
                response.forEach(function(item, i) {
                    jQuery('#libraries-table tbody').append('<tr><td>' + item.label + '</td><td>' + item.address + '</td></tr>');
                });
            })
            .fail(function(response) {
                addToast('An error has occurred, please review the information', 'danger');
            });

        var myModal = new bootstrap.Modal(document.getElementById('libraries-modal'));
        myModal.show();
    }

    function loadBook(id) {
        jQuery.ajax({
                type: 'GET',
                url: '/api/books/' + id
            }).done(function(response) {
                jQuery('#book_id').val(response.book.id);
                jQuery('#book-name').val(response.book.name);
                jQuery('#book-year').val(response.book.year);
                jQuery('#author-name').val(response.book.author.name);
                jQuery('#author-birth').val(response.book.author.birth_date);
                jQuery('#author-genre').val(response.book.author.genre);

                jQuery('#librarieslist').html('');

                response.book.libraries.forEach(function(item, i) {
                    jQuery('#librarieslist').append('<span id="library' + item.id + '"><input type="hidden" name="library[]" value="' + item.id + '">Library: ' + item.name + ', Address: ' + item.address + '<i class="fa-solid fa-circle-xmark" data-id="' + item.id + '"></i></span>');
                    jQuery('#libraries').val('');
                    jQuery('#librarieslist #library' + item.id + '  i').click(function(event) { jQuery('#librarieslist #library' + item.id).remove() });
                });

                var myModal = new bootstrap.Modal(document.getElementById('form-modal'));
                myModal.show();
            })
            .fail(function(response) {
                addToast('An error has occurred, please review the information', 'danger');
            });
    }

    function removeBook(id) {
        if (confirm('Are you sure?')) {
            jQuery.ajax({
                    type: 'DELETE',
                    url: '/api/books/' + id
                }).done(function(response) {
                    jQuery('#books-table').bootstrapTable('remove', {
                        field: 'book_id',
                        values: [id]
                    });

                    addToast('Book deleted successfully!', 'success');
                })
                .fail(function(response) {
                    addToast('An error has occurred, please review the information', 'danger');
                });
        }
    }

    window.booksFormatter = function(value, row, index) {
        return [
            '<a class="libraries" href="javascript:void(0)" title="See Libraries"><i class="fa-solid fa-book"></i> See libraries</a>',
            '<a class="edit" href="javascript:void(0)" title="Edit"><i class="fa-solid fa-pen"></i> Edit book</a>',
            '<a class="delete" href="javascript:void(0)" title="Delete"><i class="fa-solid fa-rectangle-xmark"></i> Delete book</a>'
        ].join('&nbsp;/&nbsp;')
    }

    window.librariesFormatter = function(value, row, index) {
        return '<a class="libraries" href="javascript:void(0)" title="See Libraries"><i class="fa-solid fa-book"></i> See libraries</a>';
    }

    window.booksEvents = {
        'click .libraries': function(e, value, row, index) {
            loadLibraries(value);
        },
        'click .delete': function(e, value, row, index) {
            removeBook(row.book_id)
        },
        'click .edit': function(e, value, row, index) {
            loadBook(row.book_id)
        }
    };

    var $table = jQuery('#books-table');
    $table.bootstrapTable();
});
