var forms = document.querySelectorAll('.task');
//
forms.forEach((form) => {
    form.addEventListener("submit", (evt) => {
        var formData = new FormData(form)
        if(! formData.get('weekdays[]') || ! formData.get('idGroup[]'))
            evt.preventDefault()
    })
})



tinymce.init({
    selector: "#textarea_mail",// change this value according to your HTML
    license_key: 'gpl', 
    plugins: "anchor autosave autolink charmap codesample directionality emoticons help image insertdatetime link linkchecker lists media nonbreaking pagebreak save searchreplace table visualblocks visualchars wordcount",
    toolbar: "undo redo | bold italic underline forecolor backcolor | link image | alignleft aligncenter alignright alignjustify lineheight | checklist numlist indent outdent | removeformat",
    // height: "700px",  
    spellchecker_language: "en",
    spellchecker_active: false,
    setup: function(editor) {
        editor.on('change', function(e) {
            tinymce.triggerSave();  // Sauvegarde le contenu dans la <textarea>
        });
    }
  });


/*

tinymce.init({selector: '#mail'});




*/ 
