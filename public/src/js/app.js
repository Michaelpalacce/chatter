$(document).ready(function(){
    Dropzone.options.addImages={
        maxFilesize:2,
        acceptedFiles:'image/*',
        success: function (file,response) {
            var imgSrc=baseUrl+response.file_path;
            $('#gallery-images ul').innerHTML="";
            $('#gallery-images ul').append('<li><a href="'+imgSrc+'"><img src="'+imgSrc+'"></a></li>');
        }
    };
});