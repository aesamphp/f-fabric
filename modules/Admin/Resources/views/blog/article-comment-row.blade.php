@foreach ($comments as $comment)
<tr>
    <td>{{ $comment->id }}</td>
    <td>{{ str_limit($comment->content, 50) }}</td>
    <td>{{ $comment->user->getFullName() }}</td>
    <td>{{ formatDate($comment->created_at) }}</td>
    <td>
        <a class="ajax-content" href="{{ route('admin::view.blog.article.comment.content', ['id' => $comment->article->id, 'commentId' => $comment->id]) }}" title="View">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.blog.article.comment', ['id' => $comment->article->id, 'commentId' => $comment->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit" title="Delete">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach