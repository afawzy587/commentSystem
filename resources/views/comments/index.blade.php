<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post and Comment Template</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="pull-right mt-3 space-y-1">

    <!-- Authentication -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-responsive-nav-link :href="route('logout')"
                               onclick="event.preventDefault();
                                        this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-responsive-nav-link>
    </form>
</div>
<div class="container bootstrap snippets bootdey">
    <h1>Add a New Comment</h1>

    <form id="postForm">
        <div class="mb-3">
            <div id="errorCommentMessages" class="alert alert-danger" style="display: none;"></div>
            <textarea class="form-control" id="postContent" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Post</button>
    </form>
        <div class="col-md-12">
            <div class="blog-comment">
                <h3 class="text-success">Comments</h3>
                <hr/>
                <div class="row" id="postsContainer">
                     @include('comments.partials.comments',['comments' => $comments])
                </div>
            </div>
    </div>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<!-- Custom JS -->
<script src="{{ asset('assets/js/script.js') }}"></script>

<div id="replyFormPopup" class="reply-form-popup">
    <div class="reply-form-container">
        <h4>Add a Reply</h4>
        <div id="errorMessages" class="alert alert-danger" style="display: none;"></div>
        <form id="replyForm">
            <input type="hidden" id="commentId" name="comment_id">
            <div class="mb-3">
                <textarea class="form-control" id="replyContent" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-secondary" id="closeReplyForm">Close</button>
        </form>
    </div>
</div>
</body>
</html>
