@extends ('forum::master')

@section ('content')
    <div id="thread">
        <h2>
            @if ($thread->trashed())
                <span class="label label-danger">{{ trans('forum::general.deleted') }}</span>
            @endif
            @if ($thread->locked)
                <span class="label label-warning">{{ trans('forum::threads.locked') }}</span>
            @endif
            @if ($thread->pinned)
                <span class="label label-info">{{ trans('forum::threads.pinned') }}</span>
            @endif
            {{ $thread->title }}
        </h2>

        <hr>

        @can ('manageThreads', $category)
            <form action="{{ route('forum.thread.update', $thread->id) }}" method="POST" data-actions-form>
                {!! csrf_field() !!}
                {!! method_field('patch') !!}

                @include ('forum::thread.partials.actions')
            </form>
        @endcan

        @can ('reply', $thread)
            <div class="row">
                <div class="col-xs-4">
                    <div class="btn-group" role="group">
                        <a href="{{ $thread->replyRoute }}" class="btn btn-default">{{ trans('forum::general.new_reply') }}</a>
                        <a href="#quick-reply" class="btn btn-default">{{ trans('forum::general.quick_reply') }}</a>
                    </div>
                </div>
                <div class="col-xs-8 text-right">
                    {!! $thread->postsPaginated->render() !!}
                </div>
            </div>
        @endcan

        <table class="table {{ $thread->trashed() ? 'deleted' : '' }}">
            <thead>
                <tr>
                    <th class="col-md-2">
                        {{ trans('forum::general.author') }}
                    </th>
                    <th>
                        {{ trans_choice('forum::posts.post', 1) }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($thread->postsPaginated as $post)
                    @include ('forum::post.partials.list', compact('post'))
                @endforeach
            </tbody>
        </table>

        {!! $thread->postsPaginated->render() !!}

        @can ('reply', $thread)
            <h3>{{ trans('forum::general.quick_reply') }}</h3>
            <div id="quick-reply">
                <form method="POST" action="{{ route('forum.post.store', $thread->id) }}">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <textarea name="content" class="form-control">{{ old('content') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ trans('forum::general.reply') }}</button>
                </form>
            </div>
        @endcan
    </div>
@overwrite
