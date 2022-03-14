@extends('layouts.app')

@section('container')
    <div class="container mt-4">
        <div class="text-center">
            <h1>List User Data</h1>
        </div><br>
        <button class="btn btn-success btn-sm mb-4" id="show-modal"><i class="bi bi-cloud-plus-fill"></i> Add Data</button>
        <br>
        <table class="table table-dark table-striped mt-4" id="myTable">
            <thead>
                <tr>
                    <td>#ID</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Age</td>
                    <td>Gender</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="labelModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="labelModal">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form name="form-user" id="form-user">
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="name" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com" required>
                </div>
                <div class="form-group">
                    <label for="age" class="form-label">Age</label>
                    <input name="age" type="text" class="form-control" id="age" placeholder="age" required>
                </div>
                <label for="age" class="form-label">Gender</label>
                <div class="form-group">
                    <select name="gender" id="gender" class="form-select" aria-label="Default select example" required> 
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" value="create" id="save">Save</button>
        </div>
    </div>
</div>
@endsection

@push('add-script')
    <script>
    $(function(){
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{route('user.index')}}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'age', name: 'age'},
                {data: 'gender', name: 'gender'},
                {data: 'action', name: 'action'},
            ]
        });
        //================= END TABLE

        //===== SHOW MODAL
        $('#show-modal').click(function(){
            $('#modal').modal('show');
            $('.modal-title').html('Add New Data');
            $('#id').val('');
            $('#form-user').trigger('reset');
        });

        //===== ADD USER
        $('#save').click(function(e){
            e.preventDefault();

            $.ajax({
                data: $('#form-user').serialize(),
                url: "{{route('user.store')}}",
                type: 'POST',
                dataType: 'json',
                
                success: function(data){
                    $(this).html('sending...');
                    $('#form-user').trigger("reset");
                    $('#modal').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil ditambahkan',
                        showConfirmButton: true,
                        timer: 1500
                    })
                    table.draw()
                },
                error: function(data){
                    console.error('Error ', data);
                }
            });
        });

        //=== EDIT
        $('.container').on('click', '.edit-data', function(){
                var id = $(this).data('id');
                $.get("{{route('user.index')}}" +'/' + id +'/edit', function(data){
                    $('#modalLabel').html("Edit User");
                    $('#modal').modal('show');
                    $('#save').val('edit-user');
                    
                    // //=== DATA OLD VALUE
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#age').val(data.age);
                    $('#gender').val(data.gender);
                    
            });
        });

        //=== DELETE
        $('.container').on('click', '.delete-data', function(){
            var id = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this",
                icon: "warning",
                showCancelButton: true,
                ConfirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                ConfirmButtonText: 'Yes, delete it!'
            }).then(function(e){
                if(e.isConfirmed === true){
                    $.ajax({
                        type: 'DELETE',
                        url: "{{route('user.store')}}"+"/"+id,
                        success: function(data){
                            if(data.success === true){
                                Swal.fire(
                                    'Deleted',
                                    'Your file has been deleted',
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
@endpush

