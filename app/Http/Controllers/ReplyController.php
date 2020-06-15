<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Reply;
use App\Thread;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

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
     * @return LengthAwarePaginator
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
     * @param CreatePostRequest $request
     * @return Application|ResponseFactory|Response|Reply
     */
    public function store(string $channelSlug, Thread $thread, CreatePostRequest $request)
    {
        if ($thread->locked) {
            return response('Thread is locked.', 422);
        }
        return $thread->addReply([
            'user_id' => auth()->id(),
            'body' => request('body'),
        ])->load('owner');
    }

    /**
     * ОБновление текста комментария
     *
     * @param Reply $reply
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => 'required|spamfree']);

        $reply->update(request(['body']));
    }

    /**
     * Удаление комментария
     *
     * @param Reply $reply
     * @return ResponseFactory|RedirectResponse|Response
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
