@extends('layouts.app')

@section('container')
    <div class="container mt-4">
        <h1>Hello Developer</h1>
        <hr>
        <div class="m-4">
            <div class="col-sm-6">
                <form action="{{route('image.store')}}" method="POST"  enctype="multipart/form-data" id="form-image">
                    @csrf
                    <div class="form-group">
                        <img id="preview-image" width="100px">
                        <label for="image">Image Upload</label>
                        <input type="file" name="image" id="image" class="form-control @error('image')is-invalid @enderror">
                    </div>
                    @error('image')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="url">Image Url</label>
                        <input type="text" name="url" id="url" class="form-control">
                    </div>
                    <div class="m-2 d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="save" value="create">Upload</button>
                    </div>
            </div>
            </form>
        </div>
        <div class="col-sm-8">
            <table class="table table-hovered">
                <thead>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Url</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td><img src="{{asset('storage/' . $item->image)}}" alt="" width="100px"></td>
                            <td>{{$item->url}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
            $('#save').click(function(e){
                e.preventDefault()

                $.ajax({
                    data: $('#form-image').serialize(),
                    // url: "{{route('image.store')}}",
                    type: "POST",
                    dataType: "JSON",
                    success: function(data){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'success',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function(data){
                        console.error('Error ', data)
                    }

                })
            });
        })
    </script>
@endpush