window.onload = function () {

    var fileInput = [...document.getElementsByClassName('fileToUpload')];

    if (fileInput !== undefined && fileInput !== null) {
        fileInput.forEach(handler) 
     } 

}

function handler(value, index)
{
    let fileDisplayArea = document.querySelectorAll('#file-display-area');

    value.addEventListener('change', function () {
        let file = value.files[0];
        let reader = new FileReader();

            reader.onload = function () {
                fileDisplayArea[index].innerHTML = "";

                let img = new Image(225);
                img.style.objectFit = "contain";
                img.src = reader.result;

                fileDisplayArea[index].appendChild(img);
            }
            reader.readAsDataURL(file);
    });
}
