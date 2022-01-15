function openSearchBar(){
    let search_bar = document.getElementById('search-bar-mobile');
    if (search_bar.style.display === "none") {
        search_bar.style.display = "block";
    } else {
        search_bar.style.display = "none";
    }
}