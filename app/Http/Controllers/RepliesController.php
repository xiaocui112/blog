<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reply;

class RepliesController extends Controller
{
    public function __contruct()
    {
        $this->middleware('auth');
    }
    public function store(ReplyRequest $request, Reply $reply)
    {
        $reply->content = $request->content;
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->topic_id;
        $reply->save();
        return redirect()->back()->with('success', '评论创建成功.');
    }
    public function destroy(Reply $reply)
    {
        $this->authorize("authReply", $reply);
        $reply->delete();
        return redirect()->back()->with("success", "评论删除成功.");
    }
}
