@extends('layouts.app')
@section('title',Auth::user()->name.'的通知')
@section('content')
<div class="container">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-body">
                <h3 class="text-xs-center">
                    <i class="far fa-bell" aria-hidden="true"></i>我的通知
                </h3>
                <hr>
                @if($notifications->count())
                <div class="list-unstyled notification-list">
                    @foreach($notifications as $notification)
                    <li class="media @if ( ! $loop->last) border-bottom @endif">
                        <div class="media-left">
                            <a href="{{ route('users.show', $notification->data['user_id']) }}">
                                <img class="media-object img-thumbnail mr-3"
                                    alt="{{ $notification->data['user_name'] }}"
                                    src="{{ $notification->data['user_avatar'] }}" style="width:48px;height:48px;" />
                            </a>
                        </div>

                        <div class="media-body">
                            <div class="media-heading mt-0 mb-1 text-secondary">
                                <a href="{{ route('users.show', $notification->data['user_id']) }}">{{
                                    $notification->data['user_name']
                                    }}</a>
                                评论了
                                <a href="{{ $notification->data['topic_link'] }}">{{ $notification->data['topic_title']
                                    }}</a>

                                <!-- -- 回复删除按钮 -- -->
                                <span class="meta float-right" title="{{ $notification->created_at }}">
                                    <i class="far fa-clock"></i>
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <div class="reply-content">
                                {!! $notification->data['reply_content'] !!}
                            </div>
                        </div>
                    </li>
                    @endforeach
                </div>
                @else
                <div class="empty-block">没有消息通知.</div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="mt-5">
    {!!$notifications->render()!!}
</div>
@endsection