function ckeditor (name) {
    var editor = CKEDITOR.replace(name ,{
         skin : 'moono-lisa',
         extraPlugins : 'image2,youtube,codesnippet',
        //codeSnippet_languages : {
        //javascript: 'JavaScript',
        //php: 'PHP'
        //},
        codeSnippet_theme : 'pojoaque',
        youtube_width : '640',
        youtube_height : '480',
        youtube_related : true,
        youtube_older : false,
        youtube_privacy : false,
        uiColor : '#f7f7f7',
        language:'vi',
        filebrowserImageBrowseUrl : baseURL+'/plugin/ckfinder/ckfinder.html?Type=Images',
        filebrowserFlashBrowseUrl : baseURL+'/plugin/ckfinder/ckfinder.html?Type=Flash',
        filebrowserImageUploadUrl : baseURL+'/plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : baseURL+'/plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
        //toolbar:[
        //['Source','-','Save','NewPage','Preview','-','Templates'],
        //['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
        //['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        //['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'HiddenField'],
        //['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
        //['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
        //['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        //['Link','Unlink','Anchor'],
        //['Image','Flash', 'Youtube','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
        //['Styles','Format','Font','FontSize'],
        //['TextColor','BGColor'],
        //['Maximize', 'ShowBlocks','-','About']
        //]
        });
}