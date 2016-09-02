/**
 * Created by ecfcode on 15/06/2016.
 */

$(document).ready(function () {
    //data-keyboard="false"

    $('.btn-add').click(function(e){
        e.preventDefault();

        var $col = $(this).parents('div.col-md-3');
        var $id = $col.data('id');
        //console.log($id);
        var $form = $('#form-cart');
        var $url = $form.attr('action').replace(':PRODUCT_ID', $id);
        var $data = $form.serialize();

        //alert($url);
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
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000
                    };
                    toastr.error('Responsive AtlanteIt', 'Error from ECFCODE');


                }, 1300);

            },
            complete: function($response) {
                $('div.progress.progress-sm.active').addClass('hidden');
                $('#mymodal').modal('hide');

                //var result = $response.responseJSON.estado;
                //console.log(result);
                if($response.responseJSON.removed == 1){
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000
                        };
                        toastr.success('Responsive AtlanteIt', 'Success from ECFCODE');


                    }, 1300);

                }
                else{
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000
                        };
                        toastr.error('Responsive AtlanteIt', 'Error from ECFCODE');


                    }, 1300);

                }
            }
        });
    });
});
