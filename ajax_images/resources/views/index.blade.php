@extends('layouts.app')

@section('container')

<div class="container mt-4">

<div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add</button></div>
<div class="card">
    <div class="card-header text-center font-weight-bold">
    <h2>Laravel 8 Ajax Book CRUD with DataTable Example Tutorial</h2>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="datatable-ajax-crud">
            <thead>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>URl</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
    <!-- boostrap add and edit book model -->
    <div class="modal fade" id="ajax-book-model" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="ajaxBookModel"></h4>
        </div>
        <div class="modal-body">
            <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id">
                <div class="form-group">
                <label class="col-sm-2 control-label">Book Image</label>
                <div class="col-sm-6 pull-left">
                <input type="file" class="form-control" id="image" name="image" required="">
                </div>               
                <div class="col-sm-6 pull-right">
                <img id="preview-image"
                        alt="preview image" style="max-height: 50px;">
                </div>
            </div>
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Save changes
                </button>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            
        </div>
        </div>
    </div>
    </div>
<!-- end bootstrap model -->
@endsection

@push('add-script')
    <script>
        $(document).ready( function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#image').change(function(){
           
    let reader = new FileReader();
    reader.onload = (e) => { 
      $('#preview-image').attr('src', e.target.result); 
    }
    reader.readAsDataURL(this.files[0]); 
  
   });
    $('#datatable-ajax-crud').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{route('image-index') }}",
           columns: [
                    {data: 'id', name: 'id'},
                    { data: 'image', name: 'image' , orderable: false},
                    { data: 'url', name: 'url' , orderable: false},
                    {data: 'action', name: 'action', orderable: false},
                 ],
          order: [[0, 'desc']]
    });
    $('#addNewBook').click(function () {
       $('#addEditBookForm').trigger("reset");
       $('#ajaxBookModel').html("Add Book");
       $('#ajax-book-model').modal('show');
       $("#image").attr("required", "true");
       $('#id').val('');
       $('#preview-image').attr('src', '');
    });
 
    // $('body').on('click', '.edit', function () {
    //     var id = $(this).data('id');
         
    //     // ajax
    //     $.ajax({
    //         type:"POST",
    //         url: "{{ url('edit-book') }}",
    //         data: { id: id },
    //         dataType: 'json',
    //         success: function(res){
    //           $('#ajaxBookModel').html("Edit Book");
    //           $('#ajax-book-model').modal('show');
    //           $('#id').val(res.id);
    //           $('#title').val(res.title);
    //           $('#code').val(res.code);
    //           $('#author').val(res.author);
    //           $('#image').removeAttr('required');
    //        }
    //     });
    // });
    // $('body').on('click', '.delete', function () {
    //    if (confirm("Delete Record?") == true) {
    //     var id = $(this).data('id');
         
    //     // ajax
    //     $.ajax({
    //         type:"POST",
    //         url: "{{ url('delete-book') }}",
    //         data: { id: id },
    //         dataType: 'json',
    //         success: function(res){
    //           var oTable = $('#datatable-ajax-crud').dataTable();
    //           oTable.fnDraw(false);
    //        }
    //     });
    //    }
    // });
   $('#addEditBookForm').submit(function(e) {
     e.preventDefault();
  
     var formData = new FormData(this);
  
     $.ajax({
        type:'POST',
        url: "{{route('image-store')}}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
          $("#ajax-book-model").modal('hide');
          var oTable = $('#datatable-ajax-crud').dataTable();
          oTable.fnDraw(false);
          $("#btn-save").html('Submit');
          $("#btn-save"). attr("disabled", false);
        },
        error: function(data){
           console.log(data);
         }
       });
   });
});
    </script>
@endpush