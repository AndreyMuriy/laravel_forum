<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Exception;
use Illuminate\Support\Facades\Gate;

class ReplyController extends Controller
{
    /**
     * ReplyController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Получение всех связанных комментариев
     *
     * @param $channelId
     * @param Thread $thread
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(5);
    }

    /**
     * Сохранение комментария поста
     *
     * @param string $channelSlug
     * @param Thread $thread
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\RedirectResponse
     */
    public function store(string $channelSlug, Thread $thread)
    {
        if (Gate::denies('create', Reply::class)) {
            return response(
                'You are posting too frequently. Please take a break. :)', 429
            );
        }

        try {
            $this->validate(request(), ['body' => 'required|spamfree']);

            $reply = $thread->addReply([
                'user_id' => auth()->id(),
                'body' => request('body'),
            ]);
        } catch (Exception $exception) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }

        return $reply->load('owner');
    }

    /**
     * ОБновление текста комментария
     *
     * @param Reply $reply
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            $this->validate(request(), ['body' => 'required|spamfree']);
            $reply->update(request(['body']));
        } catch (Exception $exception) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }

    }

    /**
     * Удаление комментария
     *
     * @param Reply $reply
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws Exception
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted.']);
        }

        return back();
    }
}
