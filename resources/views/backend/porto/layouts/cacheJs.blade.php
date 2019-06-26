<script src="{{ Helper::backend('javascripts/theme.js') }}" ></script>
<script src="{{ Helper::backend('javascripts/theme.init.js') }}"></script>
<script>
    $(function() {
        tinymce.init({
              selector     : "#editor",
              plugins      : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste responsivefilemanager"],
              toolbar      : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager",
              image_advtab : true,
              relative_urls: false, 
              external_filemanager_path:"{!! str_finish(asset('/system/public/files/filemanager/'),'/') !!}",
              filemanager_title        :"{{ config('website_name') }} File Manager" ,
              external_plugins         : { "filemanager" : "{{ Helper::backend('vendor/tinymce4/plugins/responsivefilemanager/plugin.min.js') }}"} 
        }); 

        tinymce.init({
              selector  : "#simple",
              menubar   : false
        }); 
    });
</script>