<ul class="comments">
    @foreach($comments as $k => $comment)
        <li class="clearfix">
            <div class="main-comment">
                <p class="meta">
                    {{$comment->created_at->format('d M Y')}}
                    <a href="#">{{$comment->user->name}}</a>
                    @if($comment->replies->count() < 5)
                        <i class="pull-right">
                            <a class="add_reply" href="#" id="{{encrypt($comment->id)}}" data-line-number="reply_{{$k}}">
                                <small>Add Reply</small>
                            </a>
                        </i>
                    @endif
                </p>
                <p>{{$comment->comment}}
                    <i class="pull-right">
                        {{$comment->replies->count()}} / 5 <b>Replies</b>
                    </i>
                </p>

                <ul class="comments replies" id="reply_{{$k}}">
                    @if($comment->replies)
                        @foreach($comment->replies as $reply)
                            <li class="reply">
                                <div class="post-replies">
                                    <p class="meta">{{$reply->created_at->format('d M Y')}} <a href="#">{{$reply->user->name}}</a></p>
                                    <p>{{$reply->reply_text}}</p>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </li>
    @endforeach
</ul>
<!-- Pagination Links -->
<div class="d-flex justify-content-center">
    {{ $comments->links('vendor.pagination.default') }}
</div>
