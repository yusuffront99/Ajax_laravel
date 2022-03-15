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
        <form name="form-score" id="form-score">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <div class="form-group">
                    <select name="users_id" id="users_id" class="form-select" aria-label="Default select example" required> 
                        <option value="">Select name</option>
                        @foreach ($items as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="score" class="form-label">Score</label>
                <input name="score" type="score" class="form-control" id="score" placeholder="00.0" required>
            </div>
            <label for="gender" class="form-label">Grade</label>
            <div class="form-group">
                <select name="grade" id="grade" class="form-select" aria-label="Default select example" required> 
                    <option value="">Select Grade</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
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
                //=== RELATIONSHIP TABLES
                {data: 'users', name: 'users.name'},
                {data: 'score', name: 'score'},
                {data: 'grade', name: 'grade'},
                {data: 'action', name: 'action'},
            ]
        });

        //=== SHOW MODAL
        $('#show-modal').click(function(){
            $('#modal').modal('show')
        })

        //=== SAVE
        $('#save').click(function(e){
            e.preventDefault();

            $.ajax({
                data: $('#form-score').serialize(),
                url: "{{route('score.store')}}",
                type: "POST",
                dataType: 'json',

                success: function(data){
                    $(this).html('sending...');
                    $('#form-score').trigger("reset");
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
            })
        })
    });
    </script>
@endpush