var ajaxReady = true;

$(document).ready(function(){
    $('#jass-add-image').click(function(){
        $('#jass-image-file').val(null);
        $('#jass-image-upload').addClass('show');
    });
    $('#jass-image-cancel').click(function(){
        $('#jass-image-upload').removeClass('show');
    });

    $('#jass-image-file').on('change', function(){
        var file = $('#jass-image-file').prop('files')[0];
        var formData = new FormData();                  
        formData.append('file', file);
        formData.append('id', $(this).data('id'));
        if (ajaxReady == true) {
            ajaxReady = false;
            $.ajax({
                url: Routing.generate('new_picture'),
                type: 'POST',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: formData
            })
            .done(function(data){
                $('.jass-vehicles-images').append(data.html);
                $('#jass-image-upload').removeClass('show');
                ajaxReady = true;
            });
        }
    });

    $('.jass-remove-image').click(function(){
        var element = $(this);
        var id = $(this).data('id');
        var position = $(this).data('position');
        if (ajaxReady == true) {
            ajaxReady = false;
            $.ajax({
                url: Routing.generate('del_picture'),
                type: 'POST',
                data: {
                    'id': id,
                    'position': position
                }
            })
            .done(function(data){
                element.parent('.jass-vehicles-image').remove();
                ajaxReady = true;
            });
        }
    });
});
