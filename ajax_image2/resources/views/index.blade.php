@extends('layouts.app')

@section('container')
    <div class="container m-4">
        <div class="row">
            <div class="col-sm-4">
                <form name="image-upload" method="POST" enctype="multipart/form-data" id="image-upload" action="javascript:void(0)" >
                    @csrf
                    <div id="preview-file">
                        <img width="100px" alt="" id="img">
                    </div>
                    <div class="form-group">
                        <label for="file">Upload File</label>
                        <input type="file" name="file" id="file" placeholder="Upload File">
                    </div>
                    <div class="d-grid mt-2">
                        <button type="submit" class="btn btn-primary" id="submit" value="upload">upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('add-script')
    <script>
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#file').change(function(){
                var reader = new FileReader();
                reader.onload = (e) => {
                    $('#img').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0])
            });

            $('#image-upload').submit(function(e){
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    data: formData,
                    type:'POST',
                    url: '{{route("file.store")}}',
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        alert(data.message)
                    },
                    error: function(data){
                        console.log(data);
                    }
                })
            })

        })
    </script>
@endpush