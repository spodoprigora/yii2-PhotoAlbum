$(function() {



    $("#btn-add-image").click(function(e) {
        $("#upload-image-button").click();
    });

    $('#upload-image-button').on("change",  function (e) {
        e.preventDefault();
        var control = document.getElementById("upload-image-button");
        var id = $('#btn-add-image').attr('data-id');
        var count = $('#count').attr('data-count');
        var csrf = $('meta[name=csrf-token]').attr("content");
        var data = new FormData();
        $.each( control.files, function( key, value ){
            data.append( 'imageFiles['+ key + ']', value );
            count++;
        });
        data.append('id', id);
        data.append('count', count);
        data.append('_csrf', csrf);
        $.ajax({
            url: '/admin/image/upload-ajax-image',
            type: "POST",
            contentType: false, // важно - убираем форматирование данных по умолчанию
            processData: false, // важно - убираем преобразование строк по умолчанию
            data: data,
            dataType: 'html',
            success: function(data){
                $('#images').append(data);
                $('#count').attr('data-count', count);
            },
            error: function (xhr, str) {
                alert('error_upload');
            }

        });

    });

    $('body').on('click', '.img_delete', function(){
        var row = $(this).closest('.row');
        var csrf = $('meta[name=csrf-token]').attr("content");
        var file = row.find('img').attr('src');
        row.remove();
        $.ajax({
            url: '/admin/image/delete-ajax-image',
            type: "POST",
            data: {file : file, _csrf : csrf},
            dataType: 'html',
            success: function(data){},
            error: function (xhr, str) {
                alert('error_delete');
            }

        });
    });

    $('.img_delete-old').on('click', function(){
        var id = $(this).next('.delete-id').val();
        var csrf = $('meta[name=csrf-token]').attr("content");
        this.closest('.row').remove();
        $.ajax({
            url: '/admin/image/delete-old-ajax-image',
            type: "POST",
            data: {id : id, _csrf: yii.getCsrfToken()},
            success: function(data){},
            error: function (xhr, str) {
                alert('error_old_delete');
            }
        });
    });


    //валидация поля display  order
    $('body').on('change', 'input.int', function(){
        var value = $(this).val();
        var er_elem = $(this).next('.num_error');
        if (isNaN($(this).val())) { // введено не число
            // показать ошибку
            $(this).addClass('error');
            er_elem.empty();
            er_elem.append('Display order must be an integer.');
            $("button[type='submit']").attr("disabled", true);
        }
        else{
            $(this).removeClass('error');
            er_elem.empty();
            $("button[type='submit']").attr("disabled", false);
        }
    });


});