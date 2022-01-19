function addReplyBox(id) {

    form = document.getElementById("reply_form" + id)
    console.log(form.style.display)
    if (form.style.display == "none")
        form.style.display = "block"

    else form.style.display = "none"
}