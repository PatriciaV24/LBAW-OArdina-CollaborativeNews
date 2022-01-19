let select = document.getElementById("sort-select");
let allNews = document.getElementById("posts-result");
select.addEventListener("change", function() {
    window.location.replace("/search?sortBy=" + select.value + "&search=" + js_query)
});
let sort = document.querySelectorAll("option");
let users = document.querySelector("#search-users-tab");
let news = document.querySelector("#search-news-tab");

users.addEventListener('click', function() {
    for (let i = 0; i < sort.length; i += 1) {
        if (sort[i].innerHTML == "New" || sort[i].innerHTML == "Trending") {
            sort[i].hidden = true
        }
        if (sort[i].selected == true && sort[i].innerHTML != "Relevance") {
            sort[i].selected = false
        }
        if (sort[i].innerHTML == "Relevance") {
            sort[i].selected = true
        }
    }
});

news.addEventListener('click', function() {
    for (let i = 0; i < sort.length; i += 1) {
        sort[i].hidden = false;
        if (sort[i].selected == true && sort[i].innerHTML != "Relevance") {
            sort[i].selected = false
        }
        if (sort[i].innerHTML == "Relevance") {
            sort[i].selected = true
        }
    }
});