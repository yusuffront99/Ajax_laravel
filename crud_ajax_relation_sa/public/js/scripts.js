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
    })
});