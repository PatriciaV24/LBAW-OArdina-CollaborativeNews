function report(type, tab, report_to_id) {
    if (type == "user") {
        var body = document.querySelector('#reportUser_' + report_to_id + ' textarea').value
    } else {
        var body = document.querySelector('#reportContent_' + report_to_id + '_' + tab + ' textarea').value
    }


    var params = {
        "body": body,
    }

    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "/" + type + "/" + report_to_id + "/report/");

    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    xhttp.setRequestHeader('X-CSRF-TOKEN', csrf);
    xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhttp.send(JSON.stringify(params));

    xhttp.onload = function() {
        let toast = document.getElementById('toast_' + report_to_id + '_' + tab);
        let message = document.getElementById('toast_' + report_to_id + '_' + tab + '_message');
        toast = new bootstrap.Toast(toast);
        switch (xhttp.status) {
            case 200:
                message.innerHTML = "<p class='text-dark'>Denúncia recebido com sucesso.</p>";
                toast.show();
                break;
            case 400:
                message.innerHTML = "<p class='text-primary'>Motivo inválido, tente novamente!</p>";
                toast.show();
                break;
        }
    }
}