<?php

namespace Riari\Forum\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Riari\Forum\Http\Requests\CreatePostRequest;
use Riari\Forum\Models\Post;
use Riari\Forum\Models\Thread;

class PostController extends BaseController
{
    /**
     * Return the model to use for this controller.
     *
     * @return Post
     */
    protected function model()
    {
        return new Post;
    }

    /**
     * Return the translation file name to use for this controller.
     *
     * @return string
     */
    protected function translationFile()
    {
        return 'posts';
    }

    /**
     * GET: return an index of posts by thread ID.
     *
     * @param  Request  $request
     * @return JsonResponse|Response
     */
    public function index(Request $request)
    {
        $this->validate($request, ['thread_id' => 'integer|required|exists:forum_threads,id']);

        $posts = $this->model()->where('thread_id', $request->input('thread_id'))->get();

        return $this->response($posts);
    }

    /**
     * POST: create a new post.
     *
     * @param  CreatePostRequest  $request
     * @return JsonResponse|Response
     */
    public function store(CreatePostRequest $request)
    {
        $this->validate($request, ['thread_id' => 'required|exists:forum_threads,id', 'author_id' => 'required|integer']);

        $thread = Thread::find($request->input('thread_id'));
        $this->authorize('reply', $thread);

        $post = $this->model()->create($request->only(['thread_id', 'post_id', 'author_id', 'title', 'content']));
        $post->load('thread');

        return $this->response($post, $this->trans('created'), 201);
    }
}
