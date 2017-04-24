var setidImage = "";
var setUrlImage = "";
var slider = 0;
function showPopupImage(sid, surl, _slider) {
    setUrlImage = surl;
    setidImage = sid;
    slider = _slider;
    $.ajax({
        url:  _linkHost+"/posts/images/getimage",
        type: "POST",
        success: function (data)
        {
            $('.listImage').html(data);
            $('.img-upload-my').click();
        },
    });
};
$('#exampleModal').on('hidden.bs.modal', function () {
    $('.image-view').removeClass("img-bordered");
    $('#select-image').addClass("disabled");
    $('.div-details-image').hide();
})
$("#uploadForm").on('submit', (function (e) {

    e.preventDefault();
    $.ajax({
        url:  _linkHost+"/posts/images/postimages",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (data)
        {
            jQuery('#myTab a:last').tab('show');
            $('.listImage').prepend(data);
            document.getElementById('uploadForm').reset();
        },
    });
}));
$(document).delegate(".delete-attachment", "click", function () {
    if (confirm("Bạn có xóa ảnh này?")) {
        var tid = $(this).parent().find('.id-image').val();
        $.ajax({
            url: _linkHost+"/posts/images/delete?id=" + tid,
            type: "POST",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data)
            {
                $('.image-view' + data).remove();
                $('.div-details-image').hide();
            },
            error: function ()
            {
            }
        });
    }
});
$(document).delegate(".img-upload", "click", function (event) {
    console.log(macKeys.cmdKey + ' ' + event.ctrlKey);
    if ((!event.ctrlKey && !macKeys.cmdKey) || slider == 0) {
        console.log('co voa day' + slider);
        $('.imageContainer .img-chon').addClass("img-chon-e");
        $('.imageContainer').removeClass("img-chon");
    }

    $(this).parent().parent().addClass("img-chon");
    $('.details-image').attr('src', $(this).attr('src'));
    var details = JSON.parse($(this).parent().find('.details').val());
    var title = $(this).parent().find('.name').val();
    $('.details-div-images .filename').html(title);
    $('.details-div-images .uploaded').html($(this).parent().find('.datetime').val());
    $('.details-div-images .dimensions').html(details['width'] + " x " + details['height']);
    $('.details-div-images .file-size').html(details['size']);
    $('.details-div-images .id-image').val($(this).parent().find('.id-image').val());
    $('.div-details-image').show();
    $('#input-title-image').val($(this).parent().find('.title-image').val());
    $('#input-id-image').val($(this).parent().find('.id-image').val());
    $('#input-alt-image').val($(this).parent().find('.alt-image').val());
    $('#input-description-image').val($(this).parent().find('.description-image').val());
    $('#select-image').removeClass("disabled");
});
$('#select-image').click(function () {
    var arrId = [];
    if (slider != 0) {
        $.each($('.img-chon .imageCenterer'), function (key, value) {
            arrId.push($(value).find('.id-image').val());
        });
    }
    $.ajax({
        url:  _linkHost+"/posts/images/saveimage",
        type: "POST",
        data: {title_image: $('#input-title-image').val(), alt_image: $('#input-alt-image').val(), id_image: $('#input-id-image').val(), description_image: $('#input-description-image').val(),
            listID: arrId, slider: slider
        },
        success: function (data)
        {
            var json = JSON.parse(data);
            console.log(json.count);
            if (json != null) {
                if (slider != 2) {
                    if (json.status == 'i') {
                        $(setUrlImage).attr('src', json.urlimage);
                        $(setidImage).val(json.id);
                        $('#chonanh').hide();
                        $('#xoaanh').show();
                    } else {
                        $('.listSlider').html(json.html);
                    }
                } else {
                    var img = CKEDITOR.instances.editor.getData();
                    json.forEach(function (item, index) {
                        console.log(item);
                        img += "<img src='" + item + "'/>";
                    });
                    CKEDITOR.instances.editor.setData(img);
                }
                $('#btn-close-upimage').click();
            }
        },
    });
});
$(document).delegate(".delete i", "click", function (e) {
    $(this).parent().parent().remove();
});
var countFiles = 0;
var fileUploaded = 0;
var count = 0;
$(document).ready(function () {
    function sendFileToServer(formData) {
        $.ajax({
            url:  _linkHost+"/posts/images/postimages",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data)
            {
                jQuery('#myTab a:last').tab('show');
                $('.listImage').prepend(data);
                document.getElementById('uploadForm').reset();
            },
        });
    }
    function checkImage(file) {
        var match = ["image/jpeg", "image/png", "image/jpg"];
        return match.indexOf(file.type) > -1;
    }
    function handleFileUpload(files)
    {
        countFiles = files.length;
        fileUploaded = 0;
        count = 0;
        var _files = [];
        for (var i = 0; i < countFiles; i++) {
            if (checkImage(files[i])) {
                _files.push(files[i]);
            }
        }
        countFiles = _files.length;
           for (var i = 0; i < countFiles; i++)
           {
                    var fd = new FormData();
            var type = files[i].type;
            fd.append('userImage', _files[i]);
                    sendFileToServer(fd);
           }
    }
    var obj = $("#dragandrophandler");
    obj.on('dragenter', function (e)
    {
            e.stopPropagation();
            e.preventDefault();
            $(this).css('border', '2px solid #0B85A1');
    });
    obj.on('dragover', function (e)
    {
             e.stopPropagation();
             e.preventDefault();
    });
    obj.on('drop', function (e)
    {
			 
             $(this).css('border', '2px dotted #0B85A1');
             e.preventDefault();
             var files = e.originalEvent.dataTransfer.files;
			 
             //We need to send dropped files to Server
             handleFileUpload(files);
    });
    $(document).on('dragenter', function (e)
    {
            e.stopPropagation();
            e.preventDefault();
    });
    $(document).on('dragover', function (e)
    {
          e.stopPropagation();
          e.preventDefault();
          obj.css('border', '2px dotted #0B85A1');
    });
    $(document).on('drop', function (e)
    {
            e.stopPropagation();
            e.preventDefault();
    });
    $('#img-preview .del-it').unbind('click').click(function () {
        delImage($(this));
    });

    $('input[type="file"]').bind('change', function () {
        handleFileUpload(this.files);
    });
});
 var string = $("#seo_title").val();
        var leng = string.length;
        $("#leng_seotitle").html(leng);
        var string = $("#seo_description").val();
        var leng = string.length;
        $("#lengseo_description").html(leng);
        $("#seo_title").bind('keyup keypress keydown load',function () {
        
        var string = $("#seo_title").val();
        var leng = string.length;
        $("#leng_seotitle").html(leng);
    });
     $("#seo_description").bind('keyup keypress keydown load',function () {
        
        var string = $("#seo_description").val();
        var leng = string.length;
        $("#lengseo_description").html(leng);
    });