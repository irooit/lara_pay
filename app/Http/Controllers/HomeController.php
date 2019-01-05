<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * 用户中心
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['info']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * 前端 Ajax 获取用户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        if ($request->user()) {
            return response()->json(['username' => $request->user()->username, 'email' => $request->user()->email, 'is_signin' => true]);
        } else {
            return response()->json(['is_signin' => false]);
        }
    }
}
