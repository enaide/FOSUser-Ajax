<?php

namespace MiCocinaBundle\Twig\Extension;

class ToastrExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('flashbag' , array($this, 'fashBagFilter', ))) ;
    }

    public function fashBagFilter($flashbag){

        $flashbag = json_encode($flashbag);

        $html = <<<EOJ
            <script type="text/javascript">

                $(document).ready(function(){

                    var messages = $flashbag;

                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 10000
                        };

                    $.each(messages, function(k, v){
                        //console.log(v.message);
                        if(!v.title){
                            toastr.success(v[0], k);
                        }
                        else{
                         toastr[k](v.message, v.title);
                        }

                    });

                    }, 1300);

                    /*toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 0,
                    };

                    $.each(messages, function(k, v){
                        //console.log(v.message);
                        if(!v.title){
                            toastr.success(v[0], k);
                        }
                        else{
                         toastr[k](v.message, v.title);
                        }

                    });*/

                });
            </script>
EOJ;
        return $html;
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'toastr_extension';
    }
}
