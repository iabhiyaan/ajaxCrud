<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Starter Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
        </div>
    </nav>

    <main style="margin-top: 120px;" role="main" class="container">
        <div class="row">
            <div class="col-6 offset-lg-3">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <div class="card-title text-center py-3">
                            Todo List
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="tags" />
                        </div>
                        <div>
                            <a id="addIcon" data-toggle="modal" data-target="#ajaxModal">
                                <i class="fa fa-2x fa-plus-circle" aria-hidden="true"></i>
                            </a>
                            <!-- Modal -->
                            <div class="modal fade" id="ajaxModal" tabindex="-1" role="dialog"
                                aria-labelledby="ajaxModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ajaxModalTitle"></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="modalId">
                                            @csrf
                                            <input placeholder="Add item" id="addItem" type="text"
                                                class="form-control" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="delete" class="btn btn-danger"
                                                style="display: none;" data-dismiss="modal">Delete</button>
                                            <button type="submit" id="save" data-dismiss="modal" class="btn btn-success"
                                                style="display: none;">Save</button>
                                            <button type="submit" id="addList" class="btn btn-primary"
                                                data-dismiss="modal">Add Item</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="listUL">
                            @foreach($table as $t)
                            <li class="list-group-item ourItem" data-toggle="modal" data-target="#ajaxModal">
                                {{ $t->item }}
                                <input type="hidden" id="listId" value="{{ $t->id }}">
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </main><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
    $(document).ready(function() {
        $(document).on('click', '.ourItem', function() {
            var text = $(this).text();
            var text = $.trim(text);
            console.log(text);
            var grabId = $(this).find('#listId').val();
            console.log(grabId);
            $('#modalId').val(grabId);
            $('#addItem').val(text);
            $('#ajaxModalTitle').text('Edit Item');
            $('#delete').show();
            $('#save').show();
            $('#addList').hide();
        });
        $(document).on('click', '#addIcon', function() {
            $('#ajaxModalTitle').text('Add New Item');
            $('#addItem').val('');
            $('#delete').hide();
            $('#save').hide();
            $('#addList').show();
        })
        $('#addList').click(function() {
            var text = $('#addItem').val();
            if (text == '') {
                alert('please insert some data');
                console.log(text);
            } else {
                $.post(
                    'ajax', {
                        "item": text,
                        '_token': $("input[name='_token']").val()
                    },
                    function(data) {
                        console.log(data);
                        $('.card-body').load(location.href + ' #listUL');
                    }
                );
            }
        });
        $('#delete').click(function() {
            var grabmodalId = $('#modalId').val();
            console.log(grabmodalId);
            $.post('delete', {
                    "id": grabmodalId,
                    '_token': $("input[name='_token']").val()
                },
                function(data) {
                    console.log(data);
                    $('.card-body').load(location.href + ' #listUL');
                }
            )
        });
        $('#save').click(function() {
            var gradModalId = $('#modalId').val();
            var grabInputValue = $('#addItem').val();
            $.post('update', {
                "id": gradModalId,
                "item": grabInputValue,
                '_token': $(" input[name='_token'] ").val()
            }, function(data) {
                $('.card-body').load(location.href + ' #listUL');
                console.log(data);
            })
        });
        $(function() {
            $("#tags").autocomplete({
                source: '{{ route('search') }}'
            });
        });
    });
    </script>
</body>

</html>