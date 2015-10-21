<tr class="{{ $category->trashed() ? 'deleted' : '' }}">
    <td>
        <p class="{{ isset($titleClass) ? $titleClass : '' }}"><a href="{{ $category->route }}">{{ $category->title }}</a></p>
        @if ($category->trashed())
            <span class="label label-danger">{{ trans('forum::general.deleted') }}</span>
        @endif
        <span class="text-muted">{{ $category->subtitle }}</span>
    </td>
    <td>{{ $category->threadCount }}</td>
    <td>{{ $category->postCount }}</td>
    <td>
        @if ($category->newestThread)
            <a href="{{ $category->newestThread->route }}">
                {{ $category->newestThread->title }}
                ({{ $category->newestThread->authorName }})
            </a>
        @endif
    </td>
    <td>
        @if ($category->latestActiveThread)
            <a href="{{ $category->latestActiveThread->lastPost->url }}">
                {{ $category->latestActiveThread->title }}
                ({{ $category->latestActiveThread->lastPost->authorName }})
            </a>
        @endif
    </td>
</tr>
