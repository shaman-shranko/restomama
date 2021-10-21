<script src="{{ asset('admin/js/tinymce/tinymce.min.js') }}"></script>
<script>
    @foreach(config('app.locales') as $key => $lang)
    tinymce.init({
        selector:'#content_{{$lang}}',
        menubar: 'file edit view insert format tools table tc help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor removeformat | fullscreen | image pageembed template link anchor code',
        plugins: 'fullpage importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons code',
        height: 500
    });
    @endforeach
</script>
