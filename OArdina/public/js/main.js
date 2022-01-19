const preventer = document.querySelector(".preventer");

preventer.addEventListener("click", (e) => {
    e.stopPropagation();
    e.preventDefault();
    return false;
});

const tagforminput = document.getElementById("News-modal-tags");
if (tagforminput !== undefined && tagforminput !== null) {
    tagforminput.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            let parentTags = document.getElementById("parentTags");
            let span = document.createElement("span")
            span.className = "badge badge-primary";
            span.append(tagforminput.value)
            parentTags.append(span)
            tagforminput.value = '';
        }
    });
}

// Tolltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})