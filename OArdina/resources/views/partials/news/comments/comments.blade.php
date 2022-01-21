

<div class="container-xl p-3 bg-light">
    @each('partials.news.comments.single_comment', $news->getParentComments, "comment", "partials.news.comments.no_comments")
</div>
