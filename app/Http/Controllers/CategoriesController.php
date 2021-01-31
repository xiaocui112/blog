<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\View\View;

class CategoriesController extends Controller
{
    /**
     * 显示特定帖子类型
     *
     * @param Category $category
     * @return View
     */
    public function show(Request $request, Category $category): View
    {
        $active_users = (new User)->getActiveUsers();
        $topics = Topic::with(['user', 'category'])->withOrder($request->order)->where("category_id", $category->id)->paginate();
        return view('topics.index', compact('topics', 'category', 'active_users'));
    }
}
