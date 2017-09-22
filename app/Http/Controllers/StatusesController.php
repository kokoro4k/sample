<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 微博新建 跳转和保存
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'info' => 'required|max:140'
        ]);

        Auth::user()->statuses()->create([
           'info' => $request->info
        ]);

        return redirect()->back();
    }

    /**
     * 微博删除
     * @param Status $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }
}
