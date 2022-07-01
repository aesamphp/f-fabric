@foreach ($articles as $article)
<tr>
    <td>{{ $article->id }}</td>
    <td>{{ $article->title }}</td>
    <td>{{ $article->user->getFullName() }}</td>
    <td>{{ ($article->active) ? 'Yes' : 'No' }}</td>
    <td>{{ formatDate($article->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.blog.article', ['id' => $article->id]) }}" title="View">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <a href="{{ route('admin::view.blog.article.comments', ['id' => $article->id]) }}" title="View Comments">
            <i class="material-icons teal-icon font-22">comment</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.blog.article', ['id' => $article->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit" title="Delete">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach