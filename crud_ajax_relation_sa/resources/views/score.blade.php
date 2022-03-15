@extends('layouts.app')

@section('container')
<div class="container mt-4">
    <div class="text-center">
        <h1>List User Data</h1>
    </div><br>
    <button class="btn btn-success btn-sm mb-4" id="show-modal"><i class="bi bi-cloud-plus-fill"></i> Add Score</button>
    <br>
    <table class="table table-dark table-striped mt-4" id="myTable">
        <thead>
            <tr>
                <td>#ID</td>
                <td>Name</td>
                <td>Score</td>
                <td>Grade</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($data as $dt)
                <tr>
                    <td>{{$dt->id}}</td>
                    <td>{{$dt->user->name}}</td>
                    <td>{{$dt->score}}</td>
                    <td>{{$dt->grade}}</td>
                    
                </tr>
            @endforeach --}}
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
                <label for="name" class="form-label"></label>
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
        ajax: "{{route('score.index')}}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'users', name: 'users.name'},
                {data: 'score', name: 'score'},
                {data: 'grade', name: 'grade'},
                {data: 'action', name: 'action'},
            ]
        });
    });
    </script>
@endpush