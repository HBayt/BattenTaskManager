var parents = document.querySelectorAll('.picker');

parents.forEach(function(parent){
    var picker = new Picker({
        parent: parent,
        color: parent.previousElementSibling.value 
    });
    parent.style.backgroundColor = parent.previousElementSibling.value;
    picker.onChange = function(color) {
        parent.style.background = color.rgbaString;
        parent.previousElementSibling.value = color.hex;
    };
})
