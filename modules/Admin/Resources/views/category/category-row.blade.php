@foreach ($categories as $category)
<tr>
    <td>{{ $category->id }}</td>
    <td>{{ $category->title }}</td>
    <td>{{ ($category->manipulate) ? 'Yes' : 'No' }}</td>
    <td>{{ formatDate($category->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.category', ['id' => $category->id]) }}" title="View">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.category', ['id' => $category->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit" title="Delete">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach