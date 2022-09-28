<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Books Store</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.13.1/bootstrap-table.min.css">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">


        <!-- Styles -->
        <style type="text/css">
            .ui-autocomplete {
                z-index: <?php echo PHP_INT_MAX; ?>;
            }
        </style>
    </head>
    <body>


        <div class="container">
            <div class="row">
                <div class="col-12 py-5">
                    <a href="#" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#form-modal">Add Book</a>
                    <br>
                    <br>
                    <table id="books-table" data-url="<?php echo url('/api/books'); ?>"  data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th data-field="book_name">Book Name</th>
                                <th data-field="book_year">Book Year</th>
                                <th data-field="author_name">Author Name</th>
                                <th data-field="author_genre">Author Genre</th>
                                <th data-field="book_id_b" data-formatter="librariesFormatter" data-events="booksEvents">Library name</th>
                                <th data-field="book_id_c" data-formatter="librariesFormatter" data-events="booksEvents">Library address</th>
                                <th data-field="book_id" data-formatter="booksFormatter" data-events="booksEvents">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="form-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="save-book-form">
                            <div class="alert alert-success d-none" role="alert">
                            </div>
                            <div class="alert alert-danger d-none" role="alert">
                            </div>
                            <input type="hidden" id="book_id" name="book_id">
                            <div class="mb-3">
                                <label for="book-name" class="form-label">Book Name</label>
                                <input type="text" class="form-control" id="book-name" aria-describedby="book-name" name="book-name">  
                            </div>
                            <div class="mb-3">
                                <label for="book-year" class="form-label">Book Year</label>
                                <input type="number" min="0" max="<?php echo date('Y'); ?>" value="<?php echo date('Y'); ?>" step="1" class="form-control" id="book-year" name="book-year">
                            </div>
                            <div class="mb-3">
                                <label for="author-name" class="form-label">Author Name</label>
                                <input type="text" class="form-control" name="author-name" id="author-name">
                            </div>
                            <div class="mb-3">
                                <label for="author-birth" class="form-label">Author Birth Date</label>
                                <input type="date" class="form-control" id="author-birth" name="author-birth" format="yyyy-mm-dd">
                            </div>
                            <div class="mb-3">
                                <label for="author-genre" class="form-label">Author Genre</label>
                                <input type="text" class="form-control" name="author-genre" id="author-genre">
                            </div>
                            <div class="mb-3 border-top pt-1">
                                <label for="libraries" class="form-label">Libraries</label>
                                <input type="text" class="form-control" name="libraries" id="libraries">
                                <div id="librarieslist">
                                    
                                </div>
                                <a href="#" id="link_new_library" class="btn btn-link">+ Add library</a>
                            </div>
                            <div class="mb-3" id="new_library">
                                <div class="w-50 float-start pe-1">
                                    <label for="author-genre" class="form-label">Library name</label>
                                    <input type="text" class="form-control" id="library-name">
                                </div>
                                <div class="w-50 float-end ps-1">
                                    <label for="author-genre" class="form-label">Library address</label>
                                    <input type="text" class="form-control" id="library-address">
                                </div>
                                <div class="w-25 float-end pt-1 text-end">
                                    <a href="#" class="btn btn-primary" id="save_library"> + </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="save_form_button" class="btn btn-primary">Save Book</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="libraries-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table data-toggle="table" data-search="false" id="libraries-table">
                            <thead>
                                <tr>
                                    <th>Library name</th>
                                    <th>Library address</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
       
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.13.1/bootstrap-table.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
