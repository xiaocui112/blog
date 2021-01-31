@include('shared._error')
<div class="reply-box">
    <form action="{{route('replies.store')}}" method="post">
        @csrf
        <input type="hidden" name="topic_id" value="{{$topic->id}}">
        <div class="form-group">
            <textarea name="content" id="" class="form-control" rows="3" placeholder="分享你的见解."></textarea>
        </div>
        <button type="submit" class="btn btn-primary form-control">
            <i class="fa fa-share mr-1"></i>回复
        </button>
    </form>
</div>