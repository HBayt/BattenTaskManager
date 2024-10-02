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
    selector: '.editor'
});