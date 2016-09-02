
/**
 * Created by ecfcode on 24/07/2016.
 */
$(document).ready(function () {
    //data-keyboard="false"
    //$action = $form.attr('action').replace(':ID', $row.data('id'));
    //$form.find( ':input' ).val('');
    var $row, $action;
    var $form = $('#form-medida');
    var $default_action = $form.attr('action');

    $('.btn-warning').click(function(e){
        e.preventDefault();

        $row = $(this).parents('tr');
        editAction($row);

    });

    $('.btn-update').click(function(e){
        e.preventDefault();

        //console.log($row.find('td'));

        $('#progress-medida').removeClass('hidden');
        $('div.form-group').addClass('hidden');

        $form = $('#form-medida');

        $.post($form.attr('action'),$form.serialize())
            .done(function (data) {
                if (typeof data.message !== 'undefined') {
                    $('div.form-group').removeClass('hidden').addClass('fadeIn animate animated');
                    $('#progress-medida').addClass('hidden');
                    $('#myModal').modal('hide');
                    if($('.btn-update').data('id') == 0){
                        setTimeout(function() {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 10000
                            };

                            toastr['success'](data.message, 'Success Action');

                        }, 100);

                        var $tr = $('<tr></tr>');
                        var $tdActions = $('<td class="text-right"></td>');
                        var $tdNombre = $('<td></td>');
                        $tdNombre.text(data.nombre);
                        var $tdCantidad = $('<td></td>');
                        $tdCantidad.text(data.cantidad)
                        var $btnGroup = $('<div class="btn-group"></div>');
                        var $btnEdit = $('<button class="btn-warning btn btn-xs">Edit</button>');
                        var $btnDelete = $('<button class="btn-danger btn btn-xs">Delete</button>');


                        $btnGroup.append($btnEdit);
                        $btnGroup.append($btnDelete);
                        $tdActions.append($btnGroup);
                        $tr.append($tdNombre);
                        $tr.append($tdCantidad);
                        $tr.append($tdActions);
                        $($tr).data('id', data.id);

                        $btnDelete.click(function(e){
                            e.preventDefault();
                            deleteAction($tr);
                        });
                        $btnEdit.click(function(e){
                            e.preventDefault();
                            editAction($tr);
                        });

                        $('tbody').eq(0).append($tr).addClass('flash animate animated');

                        $row = $tr;
                    }

                    $row.find('td').eq(0).text(data.nombre);
                    $row.find('td').eq(1).text(data.cantidad);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (typeof jqXHR.responseJSON !== 'undefined') {
                    if (jqXHR.responseJSON.hasOwnProperty('form')){

                        $form.html(jqXHR.responseJSON.form);
                        $('div.form-group').removeClass('hidden').addClass('fadeIn animate animated');
                    }
                    //('.form_error').html(jqXHR.responseJSON.message);

                } else {
                    alert(errorThrown);
                }
            });

        /*
         $.post($form.attr('action'), $form.serialize(), function(data){
         if(data.status == 'success'){
         var $newTd = $('<td></td>').text(data.nombre_post).addClass('flash animate animated');
         $row.find('td')[0].remove();
         $row.prepend($newTd);
         $('#myModal').modal('hide');
         //$('form#form-medida input#medida_nombre').val($result.nombre_post);
         }
         else{

         $('#progress-medida').addClass('hidden');
         //$form.html($result);
         $('#test form').remove();
         $('#test').html(data.form);
         }

         }).done(function(data, textStatus, jqXHR){
         $('#progress-medida').addClass('hidden');
         });
         */
    });

    $('.btn-new').click(function(e){
        e.preventDefault();
        newAction();
    });

    $('.btn-danger').click(function(e){
        e.preventDefault();

        $row = $(this).parents('tr');
        deleteAction($row);
    });

    $('#myModal').on('hidden.bs.modal', function (e) {
        $form.attr('action', $default_action);
    });

    function newAction(){

        $('#progress-medida').removeClass('hidden');
        $('div.form-group').addClass('hidden');
        $('#myModal').modal('show');

        $.get(Routing.generate('medidas_new'), function(data) {
            $('#test form').remove();
            $('#test').html(data.form);

        })
            .done(function(data, textStatus, jqXHR){
                $('div.form-group').removeClass('hidden').addClass('fadeIn animate animated');
                $('#progress-medida').addClass('hidden');
                $('.btn-update').data('id', 0);
            });
    }
    function deleteAction($row){
        var $form_delete = $('#form-delete');

        $action = Routing.generate('medidas_delete', {id:$row.data('id')});

        swal({
                title: 'Are you sure <i class="fa fa-trash-o"></i> ?',
                text: "Your will not be able to recover this imaginary file! ",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d9230f",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: true,
                html: true,
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.post($action, $form_delete.serialize())
                        .done(function(data, textStatus, jqXHR){
                            setTimeout(function() {
                                toastr.options = {
                                    closeButton: true,
                                    progressBar: true,
                                    showMethod: 'slideDown',
                                    timeOut: 10000
                                };
                                $row.fadeOut();
                                toastr['success'](data.message, 'Success Delete Action');


                            }, 100);
                        });

                } else {
                    //swal("Cancelled", "Your imaginary file is safe :)", "error");
                    toastr['info']("Cancelled", 'Success Cancelled Action');
                }
            });

    }
    function editAction($row){
        $('#progress-medida').removeClass('hidden');
        $('div.form-group').addClass('hidden');
        $('#myModal').modal('show');

        $action = Routing.generate('medidas_edit', {id:$row.data('id')});

        $.get($action, $form.serialize(), function(data){
            $('#test form').remove();
            $('#test').html(data);

        })
            .done(function(data, textStatus, jqXHR){
                $('div.form-group').removeClass('hidden').addClass('fadeIn animate animated');
                $('#progress-medida').addClass('hidden');
                $('.btn-update').data('id', $row.data('id'));
            });
    }
    //function update
});