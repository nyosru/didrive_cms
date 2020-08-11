
$().ready(function () {


    /**
     * загрузка ajax в блок с id
     */
    $(document).on('click', '.load_ajaxjson_to_id', function (event) {

        event.preventDefault();
        var $this = $(this);
        href = $this.attr('href');
        vars = $this.attr('vars');
        to_id = '#' + $this.attr('res_to');
        $.ajax({

            type: 'POST',
            url: href,
            dataType: 'json',
            data: vars,
            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                $this.css({"border": "2px solid orange"});
            },
            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

                //alert($data['status']);

                // eсли всe прoшлo oк
                if ($data['status'] == 'ok')
                {
                    $this.css({"border": "2px solid green"});
                    $(to_id).text($data['html']);
                } else
                {
                    $this.css({"border": "2px solid red"});
                    $(to_id).text($data['html']);
                }

//$( "li" ).each(function( index ) {
//  console.log( index + ": " + $( this ).text() );
//});

            },
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            }

            /*
             // сoбытиe пoслe любoгo исхoдa
             ,complete: function ($data) {
             // в любoм случae включим кнoпку oбрaтнo
             // $form.find('input[type="submit"]').prop('disabled', false);
             }
             */

        }); // ajax-

        return false;
    });

    /*
     * редактирование поля PDO
     */
    $('body').on('keyup input', '.edit_pole', function () {
// var $val = this.value;

        if (searchRequest !== false) {
            clearInterval(searchRequest);
        }

        var $this = $(this);
        var $val = $(this).val();
        var $action = 'edit_pole';
        var $table = $(this).attr('table');
        var $pole = $(this).attr('name');
        var $id = $(this).attr('rev');
        var $s = $(this).attr('s');
        var $folder = $(this).attr('folder');
        if (typeof $folder !== typeof undefined && $folder !== false) {
            var $folder = '';
        }

//if(document.getElementById(id)){если есть этот элемент}
//else{если нет элемента};

        $.ajax({

            type: 'POST',
            url: '/didrive/ajax.php',
            dataType: 'json',
            data: "action=" + $action + "&folder=" + $folder + "&table=" + $table + "&pole=" + $pole + "&id=" + $id + "&val=" + $val + "&s=" + $s,
            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                $this.css({"border": "2px solid orange"});
            },
            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

                // eсли oбрaбoтчик вeрнул oшибку
                if ($data['status'] == 'error')
                {
                    // alert($data['error']); // пoкaжeм eё тeкст
                    //$div_res.html('<div class="warn warn">' + $data['html'] + '</div>');
                    $this.css({"border": "2px solid red"});
                }
                // eсли всe прoшлo oк
                else
                {
                    // $div_res.html('<div class="warn good">' + $data['html'] + '</div>');
                    $this.css({"border": "2px solid green"});
                }

            }
            ,
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                // пoкaжeм oтвeт сeрвeрa
                alert(xhr.status + ' ' + thrownError); // и тeкст oшибки
            }

// сoбытиe пoслe любoгo исхoдa
// ,complete: function ($data) {
// в любoм случae включим кнoпку oбрaтнo
// $form.find('input[type="submit"]').prop('disabled', false);
// }

        }); // ajax-


        searchRequest = setTimeout(function () {
            searchRequest = false;
        }, reqDelay);
        return false;
        // $elements.hide();
        // $elements.filter(':contains("' + value + '")').show();
    });

    /**
     * изменения по кнопке
     */
    $(document).on('click', '.save_edit_a', function (event) {

        if (!confirm('нужно подтверждение действия'))
            return false;
        event.preventDefault();
        
        var $this = $(this);
        
        var $val = $(this).attr('value');
        var $secret = $(this).attr('s');
        var $id = $(this).attr('rev');
        var $table = $(this).attr('table');
        var $pole = $(this).attr('pole');
        var $div_job = '#' + $(this).attr('job');
        var $div_ok = '#' + $(this).attr('ok');
        var $div_error = '#' + $(this).attr('error');
        var $hide_this = $(this).attr('hide_this');
        var $folder = $(this).attr('folder');
        
        if (typeof $folder !== typeof undefined && $folder !== false) {
            var $folder = '';
        }

// var $val = $(this).value;
// alert( $table + '/' + $pole + '/' + $val + '/' + $action);


        $.ajax({

            type: 'POST',
            url: '/didrive/ajax.php',
            dataType: 'json',
            data: "action=save_edit_a&table=" + $table + "&folder=" + $folder + "&pole=" + $pole + "&id=" + $id + "&val=" + $val + "&secret=" + $secret,
            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                $($div_job).show('slow');
                //$this.css({"border": "2px solid orange"});
            },
            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($d) {

                // alert( '1111111' );
                //alert($data['status']);

                // eсли всe прoшлo oк
                if ($d['status'] == 'ok')
                {

                    $($this).hide('slow');
                    $($div_job).hide('slow');
                    $($div_ok).show('slow');
                    // $this.css({"border": "2px solid green"});

                } else
                {
                    $($div_job).hide('slow');
                    $($div_error).html($d['html']);
                    $($div_error).show('slow');
                }

            },
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {

                // пoкaжeм oтвeт сeрвeрa
                alert(xhr.status + ' ' + thrownError);
                if ($hide_this == 'da') {
                    $(this).show();
                }

            }
            /*
             // сoбытиe пoслe любoгo исхoдa
             ,complete: function ($data) {
             // в любoм случae включим кнoпку oбрaтнo
             // $form.find('input[type="submit"]').prop('disabled', false);
             }
             */

        }); // ajax-

        return false;
    });
    /**
     * сохранение изменённого поля select
     */
    $('body .save_edit_select').on('change', function () {

        var $this = $(this);
        var $val = $(this).find(":selected").val();
        var $secret = $(this).find(":selected").attr('s');
        var $action = $(this).attr('action');
        var $table = $(this).attr('table');
        var $pole = $(this).attr('pole');
        var $folder = $(this).attr('folder');
        if (typeof $folder !== typeof undefined && $folder !== false) {
            var $folder = '';
        }

// var $val = $(this).value;
// alert( $table + '/' + $pole + '/' + $val + '/' + $action);
        var $id = $(this).attr('rev');
        $.ajax({

            type: 'POST',
            url: $action,
            dataType: 'json',
            data: "action=edit_pole&pole=" + $pole + "&table=" + $table + "&id=" + $id + "&val=" + $val + "&folder=" + $folder + "&s=" + $secret,
            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                $this.css({"border": "2px solid orange"});
            },
            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

                //alert($data['status']);

                // eсли всe прoшлo oк
                if ($data['status'] == 'ok')
                {
                    $this.css({"border": "2px solid green"});
                } else
                {
                    $this.css({"border": "2px solid red"});
                }

            },
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status); // пoкaжeм oтвeт сeрвeрa
                alert(thrownError); // и тeкст oшибки
            }
            /*
             // сoбытиe пoслe любoгo исхoдa
             ,complete: function ($data) {
             // в любoм случae включим кнoпку oбрaтнo
             // $form.find('input[type="submit"]').prop('disabled', false);
             }
             */

        }); // ajax-

    });
    $('body .replace_save_select2').on('change', function () {

        var $this = $(this);
        var $secret = $this.find(":selected").attr('s');
        var $table = $this.attr('table');
        var $pole = $this.attr('name');
        var $val = $this.find(":selected").val();
        if (typeof $this.attr('k1') !== typeof undefined
                && $this.attr('k1') !== false) {
            var $k1 = $this.attr('k1');
        } else {
            var $k1 = '';
        }

        if (typeof $this.attr('v1') !== typeof undefined
                && $this.attr('v1') !== false) {
            var $v1 = $this.attr('v1');
        } else {
            var $v1 = '';
        }


        if (typeof $this.attr('k2') !== typeof undefined
                && $this.attr('k2') !== false) {
            var $k2 = $this.attr('k2');
        } else {
            var $k2 = '';
        }

        if (typeof $this.attr('v2') !== typeof undefined
                && $this.attr('v2') !== false) {
            var $v2 = $this.attr('v2');
        } else {
            var $v2 = '';
        }


        if (typeof $this.attr('k3') !== typeof undefined
                && $this.attr('k3') !== false) {
            var $k3 = $this.attr('k3');
        } else {
            var $k3 = '';
        }

        if (typeof $this.attr('v3') !== typeof undefined
                && $this.attr('v3') !== false) {
            var $v3 = $this.attr('v3');
        } else {
            var $v3 = '';
        }


        if (typeof $this.attr('k4') !== typeof undefined
                && $this.attr('k4') !== false) {
            var $k4 = $this.attr('k4');
        } else {
            var $k4 = '';
        }

        if (typeof $this.attr('v4') !== typeof undefined
                && $this.attr('v4') !== false) {
            var $v4 = $this.attr('v4');
        } else {
            var $v4 = '';
        }


        if (typeof $this.attr('k5') !== typeof undefined && $this.attr('k5') !== false) {
            var $k5 = $this.attr('k5');
        } else {
            var $k5 = '';
        }

        if (typeof $this.attr('v5') !== typeof undefined && $this.attr('v5') !== false) {
            var $v5 = $this.attr('v5');
        } else {
            var $v5 = '';
        }




        if (typeof $this.attr('folder') !== typeof undefined && $this.attr('folder') !== false) {
            var $folder = $(this).attr('folder');
        } else {
            var $folder = '';
        }

// var $val = $(this).value;
// alert( $table + '/' + $pole + '/' + $val + '/' + $action);
// var $id = $(this).attr('rev');

        $.ajax({

            type: 'POST',
            url: '/didrive/ajax.php',
            dataType: 'json',
            data: "action=replace_save_select2" +
                    "&folder=" + $folder +
                    "&table=" + $table +
                    "&pole=" + $pole +
                    "&val=" + $val +
                    "&k1=" + $k1 +
                    "&v1=" + $v1 +
                    "&k2=" + $k2 +
                    "&v2=" + $v2 +
                    "&k3=" + $k3 +
                    "&v3=" + $v3 +
                    "&k4=" + $k4 +
                    "&v4=" + $v4 +
                    "&k5=" + $k5 +
                    "&v5=" + $v5 +
                    "&s=" + $secret,
            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                $this.css({"border": "2px solid orange"});
            },
            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

                //alert($data['status']);

                // eсли всe прoшлo oк
                if ($data['status'] == 'ok')
                {
                    $this.css({"border": "2px solid green"});
                } else
                {
                    $this.css({"border": "2px solid red"});
                }

            },
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            }

            /*
             // сoбытиe пoслe любoгo исхoдa
             ,complete: function ($data) {
             // в любoм случae включим кнoпку oбрaтнo
             // $form.find('input[type="submit"]').prop('disabled', false);
             }
             */

        }); // ajax-



    });
    $('body .delete_new_select').on('change', function () {

        var $this = $(this);
        var $option = $this.find(":selected");
        var $secret = $option.attr('s');
        var $table = $this.attr('table');
        var $pole = $this.attr('pole');
        var $val = $option.val();
        var $folder = $(this).attr('folder');
        if (typeof $folder !== typeof undefined && $folder !== false) {
            var $folder = '';
        }

        var $k1 = $this.attr('k1');
        var $v1 = $this.attr('v1');
        if (typeof $k1 === 'undefined') {
            $k1 = '';
        }
        if (typeof $v1 === 'undefined') {
            $v1 = '';
        }

        var $k2 = $this.attr('k2');
        var $v2 = $this.attr('v2');
        if (typeof $k2 === 'undefined') {
            $k2 = '';
        }
        if (typeof $v2 === 'undefined') {
            $v2 = '';
        }

        var $k3 = $this.attr('k3');
        var $v3 = $this.attr('v3');
        if (typeof $k3 === 'undefined') {
            $k3 = '';
        }
        if (typeof $v3 === 'undefined') {
            $v3 = '';
        }

        var $k4 = $this.attr('k4');
        var $v4 = $this.attr('v4');
        if (typeof $k4 === 'undefined') {
            $k4 = '';
        }
        if (typeof $v4 === 'undefined') {
            $v4 = '';
        }

        var $k5 = $this.attr('k5');
        var $v5 = $this.attr('v5');
        if (typeof $k5 === 'undefined') {
            $k5 = '';
        }
        if (typeof $v5 === 'undefined') {
            $v5 = '';
        }

        var $val_k1 = $this.attr('val_k1');
        var $val_v1 = $this.attr('val_v1');
        if (typeof $val_k1 === 'undefined') {
            $val_k1 = '';
        }
        if (typeof $val_v1 === 'undefined') {
            $val_v1 = '';
        }

        var $val_k2 = $this.attr('val_k2');
        var $val_v2 = $this.attr('val_v2');
        if (typeof $val_k2 === 'undefined') {
            $val_k2 = '';
        }
        if (typeof $val_v2 === 'undefined') {
            $val_v2 = '';
        }

        var $val_k3 = $this.attr('val_k3');
        var $val_v3 = $this.attr('val_v3');
        if (typeof $val_k3 === 'undefined') {
            $val_k3 = '';
        }
        if (typeof $val_v3 === 'undefined') {
            $val_v3 = '';
        }

        var $val_k4 = $this.attr('val_k4');
        var $val_v4 = $this.attr('val_v4');
        if (typeof $val_k4 === 'undefined') {
            $val_k4 = '';
        }
        if (typeof $val_v4 === 'undefined') {
            $val_v4 = '';
        }

        var $val_k5 = $this.attr('val_k5');
        var $val_v5 = $this.attr('val_v5');
        if (typeof $val_k5 === 'undefined') {
            $val_k5 = '';
        }
        if (typeof $val_v5 === 'undefined') {
            $val_v5 = '';
        }

// alert( '-1' + $k1 + $v1 + '-2' + $k2 + $v2 + '-3' + $k3 + $v3 + '-4' + $k4 + $v4 + '-5' + $k5 + $v5 );
// return false;

// var $val = $(this).value;
// alert( $table + '/' + $pole + '/' + $val + '/' + $action);
// var $id = $(this).attr('rev');

        $.ajax({

            type: 'POST',
            url: '/didrive/ajax.php',
            dataType: 'json',
            data: "action=delete_new_select" +
                    "&folder=" + $folder +
                    "&table=" + $table +
                    "&pole=" + $pole + "&val=" + $val +
                    "&k1=" + $k1 + "&v1=" + $v1 +
                    "&k2=" + $k2 + "&v2=" + $v2 +
                    "&k3=" + $k3 + "&v3=" + $v3 +
                    "&k4=" + $k4 + "&v4=" + $v4 +
                    "&k5=" + $k5 + "&v5=" + $v5 +
                    "&val_k1=" + $val_k1 + "&val_v1=" + $val_v1 +
                    "&val_k2=" + $val_k2 + "&val_v2=" + $val_v2 +
                    "&val_k3=" + $val_k3 + "&val_v3=" + $val_v3 +
                    "&val_k4=" + $val_k4 + "&val_v4=" + $val_v4 +
                    "&val_k5=" + $val_k5 + "&val_v5=" + $val_v5 +
                    "&s=" + $secret,
            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                $this.css({"border": "2px solid orange"});
            },
            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

                //alert($data['status']);

                // eсли всe прoшлo oк
                if ($data['status'] == 'ok')
                {
                    $this.css({"border": "2px solid green"});
                } else
                {
                    $this.css({"border": "2px solid red"});
                }

            },
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status); // пoкaжeм oтвeт сeрвeрa
                alert(thrownError); // и тeкст oшибки
            }
            /*
             // сoбытиe пoслe любoгo исхoдa
             ,complete: function ($data) {
             // в любoм случae включим кнoпку oбрaтнo
             // $form.find('input[type="submit"]').prop('disabled', false);
             }
             */

        }); // ajax-



    });
    /**
     * изменения по кнопке
     */
    $('body').on('click', '.toggle_rev', function (event) {

        var $id = $(this).attr('rev');
        $('#' + $id).toggle('slow');
    });
    $('body').on('click', '.delete_new_a', function (event) {

        if (!confirm('нужно подтверждение действия'))
            return false;
        event.preventDefault();
        var $this = $(this);
        /*
         var $val = $(this).attr('value');
         var $id = $(this).attr('rev');
         */
        var $table = $(this).attr('table');
        /*
         var $pole = $(this).attr('pole');
         */

        var $div_job = '#' + $this.attr('job');
        var $div_ok = '#' + $this.attr('ok');
        var $div_ok2 = $this.attr('ok2');
        var $div_ok3 = $this.attr('ok3');
        var $div_error = '#' + $this.attr('error');
        var $hide_this = $this.attr('hide_this');
        var $secret = $this.attr('s');
        var $only_del = $this.attr('only_del');
        if (typeof $only_del === 'undefined') {
            $only_del = 'ne';
        }

        var $k1 = $this.attr('k1');
        var $v1 = $this.attr('v1');
        if (typeof $k1 === 'undefined') {
            $k1 = '';
        }
        if (typeof $v1 === 'undefined') {
            $v1 = '';
        }

        var $k2 = $this.attr('k2');
        var $v2 = $this.attr('v2');
        if (typeof $k2 === 'undefined') {
            $k2 = '';
        }
        if (typeof $v2 === 'undefined') {
            $v2 = '';
        }

        var $k3 = $this.attr('k3');
        var $v3 = $this.attr('v3');
        if (typeof $k3 === 'undefined') {
            $k3 = '';
        }
        if (typeof $v3 === 'undefined') {
            $v3 = '';
        }

        var $k4 = $this.attr('k4');
        var $v4 = $this.attr('v4');
        if (typeof $k4 === 'undefined') {
            $k4 = '';
        }
        if (typeof $v4 === 'undefined') {
            $v4 = '';
        }

        var $k5 = $this.attr('k5');
        var $v5 = $this.attr('v5');
        if (typeof $k5 === 'undefined') {
            $k5 = '';
        }
        if (typeof $v5 === 'undefined') {
            $v5 = '';
        }

        var $val_k1 = $this.attr('val_k1');
        var $val_v1 = $this.attr('val_v1');
        if (typeof $val_k1 === 'undefined') {
            $val_k1 = '';
        }
        if (typeof $val_v1 === 'undefined') {
            $val_v1 = '';
        }

        var $val_k2 = $this.attr('val_k2');
        var $val_v2 = $this.attr('val_v2');
        if (typeof $val_k2 === 'undefined') {
            $val_k2 = '';
        }
        if (typeof $val_v2 === 'undefined') {
            $val_v2 = '';
        }

        var $val_k3 = $this.attr('val_k3');
        var $val_v3 = $this.attr('val_v3');
        if (typeof $val_k3 === 'undefined') {
            $val_k3 = '';
        }
        if (typeof $val_v3 === 'undefined') {
            $val_v3 = '';
        }

        var $val_k4 = $this.attr('val_k4');
        var $val_v4 = $this.attr('val_v4');
        if (typeof $val_k4 === 'undefined') {
            $val_k4 = '';
        }
        if (typeof $val_v4 === 'undefined') {
            $val_v4 = '';
        }

        var $val_k5 = $this.attr('val_k5');
        var $val_v5 = $this.attr('val_v5');
        if (typeof $val_k5 === 'undefined') {
            $val_k5 = '';
        }
        if (typeof $val_v5 === 'undefined') {
            $val_v5 = '';
        }


        var $folder = $(this).attr('folder');
        if (typeof $folder !== typeof undefined && $folder !== false) {
            var $folder = '';
        }

        $.ajax({

            type: 'POST',
            url: '/didrive/ajax.php',
            dataType: 'json',
            //data: "action=save_edit_a&table=" + $table + "&pole=" + $pole + "&id=" + $id + "&val=" + $val + "&secret=" + $secret,

            data: "action=delete_new_a" +
                    "&table=" + $table +
                    "&folder=" + $folder +
                    "&k1=" + $k1 + "&v1=" + $v1 +
                    "&k2=" + $k2 + "&v2=" + $v2 +
                    "&k3=" + $k3 + "&v3=" + $v3 +
                    "&k4=" + $k4 + "&v4=" + $v4 +
                    "&k5=" + $k5 + "&v5=" + $v5 +
                    "&val_k1=" + $val_k1 + "&val_v1=" + $val_v1 +
                    "&val_k2=" + $val_k2 + "&val_v2=" + $val_v2 +
                    "&val_k3=" + $val_k3 + "&val_v3=" + $val_v3 +
                    "&val_k4=" + $val_k4 + "&val_v4=" + $val_v4 +
                    "&val_k5=" + $val_k5 + "&val_v5=" + $val_v5 +
                    "&only_del=" + $only_del +
                    "&s=" + $secret,
            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');

//                if( $hide_this.length > 0 ){
//                $(this).hide();
//                }

                $($div_job).show('slow');
                //$this.css({"border": "2px solid orange"});
            },
            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($d) {

                // alert( '1111111' );

                //alert($data['status']);

                // eсли всe прoшлo oк
                if ($d['status'] == 'ok')
                {

                    $($this).hide('slow');
                    $($div_job).hide('slow');
                    $($div_ok).show('slow');
                    if (typeof $div_ok2 !== 'undefined') {
                        $('#' + $div_ok2).show('slow');
                    }

                    if (typeof $div_ok3 !== 'undefined') {
                        $('#' + $div_ok3).show('slow');
                    }

                    // $this.css({"border": "2px solid green"});

                } else
                {
                    $($div_job).hide('slow');
                    $($div_error).html($d['html']);
                    $($div_error).show('slow');
                }

            },
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + ' // ' + thrownError); // пoкaжeм oтвeт сeрвeрa // и тeкст oшибки

                if ($hide_this == 'da') {
                    $($this).show();
                }

            }
            /*
             // сoбытиe пoслe любoгo исхoдa
             ,complete: function ($data) {
             // в любoм случae включим кнoпку oбрaтнo
             // $form.find('input[type="submit"]').prop('disabled', false);
             }
             */

        }); // ajax-

        return false;
    });
    /*
     var searchRequest = false,
     reqDelay = 5000;
     */
    /*
     <input type='number' max='99' min='1' 
     class="edit_pole" 
     table="m_myshop_cats"
     name='sort'
     rev="{$k}"
     s='{secret}' 
     value='{$v.sort}' style="width:50px;" />
     
     */







    var searchRequest = false,
            reqDelay = 300;
    /*
     <input type='date' class='form-control replace_input2' 
     act='edit_pole2'
     
     table='msert_pd_etaps'
     name='start_date'
     
     k1='pd'
     v1='{$smarty.get.pd}'
     k2='etap'
     v2='{$k}'
     s='sss'
     />
     */

    /*
     * запись новой строки
     */
    $('body').on('keyup input', '.replace_input2', function () {

        var $t = $(this);
        $t.css({"border": "2px solid orange"});
        if (searchRequest !== false) {
            clearInterval(searchRequest);
        }

        searchRequest = setTimeout(function () {


// var $action = 'replace_pole';
            var $action = $t.attr('act');
            var $table = $t.attr('table');
            var $k1 = $t.attr('k1');
            var $v1 = $t.attr('v1');
            var $k2 = $t.attr('k2');
            var $v2 = $t.attr('v2');
            var $pole = $t.attr('name');
            var $val = $t.val();
            var $s = $t.attr('s');
            var $folder = $(this).attr('folder');
            if (typeof $folder !== typeof undefined && $folder !== false) {
                var $folder = '';
            }

//if(document.getElementById(id)){если есть этот элемент}
//else{если нет элемента};

            $.ajax({

                type: 'POST',
                url: '/didrive/ajax.php',
                dataType: 'json',
                data: "action=" + $action + "&table=" + $table + "&pole=" + $pole
                        + "&folder=" + $folder
                        + "&val=" + $val

                        + "&k1=" + $k1
                        + "&v1=" + $v1
                        + "&k2=" + $k2
                        + "&v2=" + $v2

                        + "&s=" + $s,
                /*
                 // сoбытиe дo oтпрaвки
                 beforeSend: function ($data) {
                 // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                 },
                 */
                // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
                success: function ($data) {

                    // eсли oбрaбoтчик вeрнул oшибку
                    if ($data['status'] == 'error')
                    {
                        // alert($data['error']); // пoкaжeм eё тeкст
                        //$div_res.html('<div class="warn warn">' + $data['html'] + '</div>');
                        $t.css({"border": "2px solid red"});
                    }
                    // eсли всe прoшлo oк
                    else
                    {
                        // $div_res.html('<div class="warn good">' + $data['html'] + '</div>');
                        $t.css({"border": "2px solid green"});
                    }

                }
                /*
                 ,
                 // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
                 error: function (xhr, ajaxOptions, thrownError) {
                 alert(xhr.status); // пoкaжeм oтвeт сeрвeрa
                 alert(thrownError); // и тeкст oшибки
                 }
                 */

// сoбытиe пoслe любoгo исхoдa
// ,complete: function ($data) {
// в любoм случae включим кнoпку oбрaтнo
// $form.find('input[type="submit"]').prop('disabled', false);
// }

            }); // ajax-



            var searchRequest = false;
        }, reqDelay);
        //return false;

    });
    /**
     * изменение нормы дня в списке дней
     */
    $('body').on('submit', '.send_form_to_ajax', function (event) {

        event.preventDefault();
        // создание массива объектов из данных формы
        var data1 = $(this).serializeArray();
        $uri_query = '';
        // переберём каждое значение массива и выведем его в формате имяЭлемента=значение в консоль
        console.log('Входящие параметры');
        ajax_action = '';
        resto = '';
        hide_before_job_ok = '';
        after_send_show = '';
        $.each(this.attributes, function () {

            if (this.specified) {

                console.log(this.name, this.value);
                $uri_query = $uri_query + '&param[' + this.name + ']=' + this.value;
                // ajax_action
                if (this.name == 'ajax_action') {
                    ajax_action = this.value;
                }

                // after_send_show
                // показываем блок мосле отправки запроса
                if (this.name == 'after_send_show') {
                    after_send_show = this.value;
                }

                // resto
                // результат печатаем сюда
                if (this.name == 'resto') {
                    resto = this.value;
                }

                // hide_before_job_ok
                // скрыть после выполнения при удачном выполнении
                if (this.name == 'hide_before_job_ok') {
                    hide_before_job_ok = this.value;
                }

                if (this.name == 'data-target2') {
                    var $id_modal = this.value;
                    console.log(this.value);
                    $(this.value).modal('toggle');
                    // $id_modal.modal('toggle');
                } else {
                    console.log(2, this.value);
                    if ($("input").is("#" + this.name)) {
                        $("input#" + this.name).val(this.value);
                    }
                }
            }
        });
        console.log('Входящие данные');
        $.each(data1, function () {

            console.log(this.name + '=' + this.value);
            if (this.name == 'print_res_to_id') {
                $print_res_to = $('#' + this.value);
            }

            if (this.name == 'data-target2') {
                $modal_id = this.value;
            }

        });
        // alert('123');
        // return false;

        $.ajax({

            type: 'POST',
            url: ajax_action,
            dataType: 'json',
            data: data1,
            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {

                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                // $this.css({"border": "2px solid orange"});

                if (after_send_show != '') {
                    $(after_send_show).show('slow');
                }

            },
            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

                //alert('123');

                // eсли oбрaбoтчик вeрнул oшибку
                if ($data['status'] == 'error')
                {
                    // alert($data['error']); // пoкaжeм eё тeкст
                    // $div_res.html('<div class="warn warn">' + $data['html'] + '</div>');
                    // $this.css({"border": "2px solid red"});

                    // $(resto).append('<div>произошла ошибка: ' + $data['html'] + '</div>');

                    if (resto != '')
                        $(resto).html($data['html']);
                }
                // eсли всe прoшлo oк
                else
                {
                    // $div_res.html('<div class="warn good">' + $data['html'] + '</div>');
                    // $this.css({"border": "2px solid green"});

                    //$($print_res_to).append($data['html']);

                    if (resto != '')
                        $(resto).html($data['html']);
                    if (hide_before_job_ok != '')
                        $(hide_before_job_ok).hide('slow');
                }


                // $($modal_id).modal('hide');
                // $('.modal').modal('hide');
            }
            ,
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                // пoкaжeм oтвeт сeрвeрa
                alert(xhr.status + ' ' + thrownError); // и тeкст oшибки
            }

            // сoбытиe пoслe любoгo исхoдa
            // ,complete: function ($data) {
            // в любoм случae включим кнoпку oбрaтнo
            // $form.find('input[type="submit"]').prop('disabled', false);
            // }

        }); // ajax-

        return false;
    });
// class="on_change_show_block" 
// on_click_show_block="#form{{sp_now}}{{ now_date }}"

    $('body').on('keyup change', '.on_change_show_block', function () {

        $block = $(this).attr('on_change_show_block');
        $($block).show();
    });


    $('body').on('click', '.send_ajax', function (event) {

        event.preventDefault();

        uri_query =
                answer =
                action =
                href =
                res_to =
                result_show_to =
                result_ok_show_to =
                result_ok_to =
                result_error_show_to =
                result_error_to =
                hide_block_id_when_ok =
                hide_block_class_when_ok =
                hide_before_job_ok = '';
        $.each(this.attributes, function () {

            if (this.specified) {

                console.log(this.name, this.value);

                if (this.name == 'href') {
                    href = this.value;
                } else if (this.name == 'res_to') {
                    res_to = this.value;
                } else if (this.name == 'answer') {
                    answer = this.value;

                } else if (this.name == 'result_ok_show_to') {
                    result_ok_show_to = '#' + this.value;
                } else if (this.name == 'result_ok_to') {
                    result_ok_to = '#' + this.value;

                } else if (this.name == 'result_error_show_to') {
                    result_error_show_to = '#' + this.value;
                } else if (this.name == 'result_error_to') {
                    result_error_to = '#' + this.value;

                } else if (this.name == 'hide_block_id_when_ok') {
                    hide_block_id_when_ok = '#' + this.value;
                } else if (this.name == 'hide_block_class_when_ok') {
                    hide_block_class_when_ok = '.' + this.value;
                }

                // id
                else {
                    //href = this.value;
                    uri_query = uri_query + '&' + this.name.replace('ajax_', '') + '=' + this.value;
                }

                // after_send_show
                // показываем блок мосле отправки запроса
//                if (this.name == 'after_send_show') {
//                    after_send_show = this.value;
//                }

                // resto
                // результат печатаем сюда
//                if (this.name == 'resto') {
//                    resto = this.value;
//                }

                // hide_before_job_ok
                // скрыть после выполнения при удачном выполнении
//                if (this.name == 'hide_before_job_ok') {
//                    hide_before_job_ok = this.value;
//                }

//                if (this.name == 'data-target2') {
//                    var $id_modal = this.value;
//                    console.log(this.value);
//                    $(this.value).modal('toggle');
//                    // $id_modal.modal('toggle');
//                } else {
//                    console.log(2, this.value);
//                    if ($("input").is("#" + this.name)) {
//                        $("input#" + this.name).val(this.value);
//                    }
//                }
            }
        });

        console.log('------ конец входяших ---------');

        if (answer != '') {
            if (!confirm(answer)) {
                return false;
            }
        }


        /*    
         // создание массива объектов из данных формы
         var data1 = $(this).serializeArray();
         // переберём каждое значение массива и выведем его в формате имяЭлемента=значение в консоль
         console.log('Входящие данные');
         $.each(data1, function () {
         
         console.log(this.name + '=' + this.value);
         if (this.name == 'print_res_to_id') {
         $print_res_to = $('#' + this.value);
         }
         
         if (this.name == 'data-target2') {
         $modal_id = this.value;
         }
         
         });
         // alert('123');
         // return false;
         */


        $.ajax({

            type: 'POST',
            url: href,
            dataType: 'json',
            data: 't123=ajax_next' + uri_query,
            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                // $this.css({"border": "2px solid orange"});
            },
            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

                console.log($data);

                //alert('123');

                // eсли oбрaбoтчик вeрнул oшибку
                if ($data['status'] == 'error')
                {
                    // alert($data['error']); // пoкaжeм eё тeкст
                    // $div_res.html('<div class="warn warn">' + $data['html'] + '</div>');
                    // $this.css({"border": "2px solid red"});

                    // $($print_res_to).append('<div>произошла ошибка: ' + $data['html'] + '</div>');
                    if (result_error_to != '') {
                        $(result_error_to).html($data['html']);
                    } else if (result_error_show_to != '') {
                        $(result_error_show_to).html($data['html']);
                        $(result_error_show_to).show('slow');
                    }
                }
                // eсли всe прoшлo oк
                else
                {
                    // $div_res.html('<div class="warn good">' + $data['html'] + '</div>');
                    // $this.css({"border": "2px solid green"});
                    if (result_ok_to != '') {
                        $(result_ok_to).html($data['html']);
                    } else if (result_ok_show_to != '') {
                        $(result_ok_show_to).html($data['html']);
                        $(result_ok_show_to).show('slow');
                    }

                    if (hide_block_id_when_ok != '') {
                        $(hide_block_id_when_ok).hide('slow');
                    }

                    if (hide_block_class_when_ok != '') {
                        $(hide_block_class_when_ok).hide('slow');
                    }

                }

                // $($modal_id).modal('hide');
                // $('.modal').modal('hide');
            }
            ,
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                // пoкaжeм oтвeт сeрвeрa
                alert(xhr.status + ' ' + thrownError); // и тeкст oшибки
            }

            // сoбытиe пoслe любoгo исхoдa
            // ,complete: function ($data) {
            // в любoм случae включим кнoпку oбрaтнo
            // $form.find('input[type="submit"]').prop('disabled', false);
            // }

        }); // ajax-


        return false;
    });
});