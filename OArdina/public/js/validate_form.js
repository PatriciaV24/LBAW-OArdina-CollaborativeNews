(function() {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
});

function toggleEye(x) {
    x.children[0].classList.toggle("fa-eye-slash");
    if (x.previousElementSibling.children[0].type === "password") {
        x.previousElementSibling.children[0].type = "text"
    } else {
        x.previousElementSibling.children[0].type = "password"
    }
}