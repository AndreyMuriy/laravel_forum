<?php
/** @noinspection PhpUnusedParameterInspection */

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;

class ReplyController extends Controller
{
    /**
     * ReplyController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Сохранение комментария поста
     *
     * @param string $channelSlug
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(string $channelSlug, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required',
        ]);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => request('body'),
        ]);

        return back()->with('flash', 'Your reply has been left.');
    }

    /**
     * Удаление комментария
     *
     * @param Reply $reply
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        return back();
    }
}
