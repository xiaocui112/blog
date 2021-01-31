<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(): View
    {
        $notifications = Auth::user()->notifications()->paginate();
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
