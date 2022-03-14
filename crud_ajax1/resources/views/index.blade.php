<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JQUERY</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="{{url('/js/sweat_alert.js')}}"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 m-2">
                <h1>CRUD AJAX</h1>
                <a class="btn btn-primary btn-sm m-2" id="create"><i class="bi bi-person-plus-fill"></i> create</a>
                <table class="table table-dark table-hover" id="table-user">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

{{-- MODAL --}}

<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form name="userForm" id="userForm">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <label for="name" class="col-sm-2">Name</label>
                <input class="form-control" type="text" name="name" id="name" placeholder="your name" required>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2">email</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="your email" required>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="save" value="create">Save</button>
    </div>
    </div>
</div>
</div>
{{--  --}}

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    {{-- jquery --}}
    <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#table-user').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('user.index')}}",
            columns: [
                {data: 'id', name:'id'},
                {data: 'name', name:'name'},
                {data: 'email', name:'email'},
                {data: 'action', name:'action'},
            ]
        });

        //=== show modal
        $('#create').click(function(){
            $('#id').val('');
            $('#userForm').trigger('reset');
            $('#modalLabel').html('Add User');
            $('#modal').modal('show');
        });

        //=== add user
        $('#save').click(function(e){
            e.preventDefault();

            $.ajax({
                data: $('#userForm').serialize(),
                url: "{{route('user.store')}}",
                type: "POST",
                dataType: 'json',
                    success: function(data){
                        $(this).html('sending...');
                        $('#userForm').trigger("reset");
                        $('#modal').modal("hide");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Success',
                            text: 'User Saved Successfully',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        table.draw();
                    },
                    error: function(data) {
                        console.error('error :', data);
                    }
                });
            });

            //=== EDIT
            $('body').on('click', '.edit-data', function(){
                var id = $(this).data('id');
                $.get("{{route('user.index')}}" +'/' + id +'/edit', function(data){
                    $('#modalLabel').html("Edit User");
                    $('#modal').modal('show');
                    $('#save').val('edit-user');
                    
                    //=== DATA OLD VALUE
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                });
            });

            //=== DELETE
            $('body').on('click', '.delete-data', function(){

                var id = $(this).data("id");
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then(function(e){
                            if(e.value === true){
                                $.ajax({
                                    type: "DELETE",
                                    url: "{{route('user.store')}}"+'/'+id,
                                    success: function(data){
                                        if(data.success === true){
                                            Swal.fire(
                                                'Deleted!',
                                                'Your file has been deleted.',
                                                'success'
                                            )
                                        }
                                        table.draw()
                                    },
                                    error: function(data){
                                        console.log('Error : ', data);
                                    }
                                });
                            }
                        });
                
            });
        });
    </script>
</html>