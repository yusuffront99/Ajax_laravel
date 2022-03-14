@extends('layouts.app')

@section('container')
    <div class="container mt-4">
        <div class="text-center">
            <h1>List User Data</h1>
        </div><br>
        <button class="btn btn-success btn-sm mb-4" id="show-modal"><i class="bi bi-cloud-plus-fill"></i> Add Data</button>
        <br>
        <table class="table table-dark table-striped mt-3" id="myTable">
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
            <form id="modal-user">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="text" class="form-control" id="age" placeholder="name@example.com">
                </div>
                <label for="age" class="form-label">Gender</label>
                <select class="form-select mb-3" aria-label="Default select example">
                    <option selected>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <button type="submit" class="btn btn-primary" value="create" id="#save">Save</button>
            </form>
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
        ajax: "{{route('index')}}",
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

        $('#show-modal').click(function(){
        $('#modal').modal('show')
        $('.modal-title').html('Add New Data');
        })
    });
    </script>
@endpush

