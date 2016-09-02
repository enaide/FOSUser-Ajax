/**
 * Created by ecfcode on 07/06/2016.
 */

$(document).ready(function () {

    var $notify ;

    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.success('Responsive Admin Theme', 'Welcome to ECFCODE');


    }, 1300);

});