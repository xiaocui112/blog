<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\TopicRequest;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * 显示首页
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $topics = Topic::with('user', 'category')->withOrder($request->order)->paginate();
        $active_users = (new User)->getActiveUsers();
        return view("topics.index", compact('topics', 'active_users'));
    }
    /**
     * 创建话题
     *
     * @return View
     */
    public function create(Topic $topic): View
    {
        return view('topics.create_and_edit', compact("topic"));
    }
    /**
     * 存储用户创建的话题
     *
     * @param TopicRequest $request
     * @param Topic $topic
     * @return void
     */
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
        return redirect()->to($topic->link())->with("success", "创建帖子成功.");
    }
    /**
     * 展示帖子
     *
     * @param Topic $topic
     * @return View
     */
    public function show(Topic $topic): View
    {
        return view('topics.show', compact('topic'));
    }
    /**
     * 保存文章图片
     *
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return array
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        if ($file = $request->upload_file) {
            $result = $uploader->save($file, 'topics');
            if ($result) {
                $data['file_path'] = Storage::url($result['path']);
                $data['msg'] = '上传成功';
                $data['success'] = true;
            }
        }
        return $data;
    }
    /**
     * 编辑帖子
     *
     * @param Topic $topic
     * @return View
     */
    public function edit(Topic $topic): View
    {
        $this->authorize('update', $topic);
        return view('topics.create_and_edit', compact('topic'));
    }
    /**
     * 更新帖子
     *
     * @param TopicRequest $request
     * @param Topic $topic
     * @return void
     */
    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());
        return redirect()->to($topic->link())->with('success', '更新成功.');
    }
    public function destroy(Topic $topic)
    {
        $this->authorize("update", $topic);
        $topic->delete();
        return redirect()->route('topics.index')->with('success', "成功删除.");
    }
}
