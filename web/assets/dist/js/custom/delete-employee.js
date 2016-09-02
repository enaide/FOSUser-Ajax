$(document).ready(function () {
    //data-keyboard="false"

    $('.btn-danger').click(function(e){
        e.preventDefault();

        var $row = $(this).parents('tr');
        var $id = $row.data('id');

        var $form = $('#form-delete');
        var $url = $form.attr('action').replace(':EMPLOYEE_ID', $id);
        var $data = $form.serialize();

        swal({
                title: 'Are you sure <i class="fa fa-trash-o"></i> ?',
                text: "Your will not be able to recover this imaginary file! ",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: false,
                html: true,
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        //url : "/master/ajax-form",
                        url: $url,
                        type: $form.attr('method'),
                        data : $data,
                        beforeSend: function() {
                            $('#mymodal').modal('show');
                            $('div.progress.progress-sm.active').removeClass('hidden');

                        },
                        error: function() {
                            swal("Cancelled", "Your imaginary file is safe :)", "error");
                        },
                        complete: function($response) {
                            $('div.progress.progress-sm.active').addClass('hidden');
                            $('#mymodal').modal('hide');

                            //var result = $response.responseJSON.estado;
                            //console.log(result);
                            if($response.responseJSON.removed == 1){
                                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                                $row.fadeOut();
                            }
                            else{
                                swal("Cancelled", "Your imaginary file is safe :)", "error");
                            }
                        }
                    });

                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
    });
});