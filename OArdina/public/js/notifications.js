function deleteNotification(notification, type){
    var params = {
        notification,
        "type": type
    }

    let xhttp = new XMLHttpRequest();
    xhttp.open("DELETE", "/notifications");

    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    xhttp.setRequestHeader('X-CSRF-TOKEN', csrf);   
    xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhttp.send(JSON.stringify(params));  

    xhttp.onload = function() {
        let response = JSON.parse(this.responseText);
        console.log(response);
        if (response.success === true){
            switch(type){
                case 'comment':
                    removeCommentNotification(notification);
                    break;
                case 'follow':
                    removeFollowNotification(notification);
                    break;
                case 'vote':
                    removeVoteNotification(notification);
                    break;
            }         
        }
    }
}

function removeCommentNotification(notification){
    let el = document.getElementById('comment-' + notification.users_id + '-' + notification.comment_id);
    el.remove(); 
}

function removeFollowNotification(notification){
    let el = document.getElementById('follow-' + notification.id);
    el.remove(); 
}

function removeVoteNotification(notification){
    let el = document.getElementById('vote-' + notification.voter_id + '-' + notification.content_id + '-' + notification.author_id);
    el.remove(); 
}
