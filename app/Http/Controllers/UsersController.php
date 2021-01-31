<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
    /**
     * 显示个人用户
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }
    /**
     * 显示编辑页面
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    /**
     * 更新个人文档
     *
     * @param UserRequest $request
     * @param User $user
     * @param ImageUploadHandler $uploader
     * @return void
     */
    public function update(UserRequest $request, User $user, ImageUploadHandler $uploader)
    {
        $this->authorize('update', $user);
        $data = $request->all();
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, "avatars", Auth::id());
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->update($data);
        return redirect()->route('users.show', Auth::id())->with('success', "个人资料更新成功.");
    }
}
