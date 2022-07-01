@foreach ($categories as $category)
<tr>
    <td>{{ $category->id }}</td>
    <td>{{ $category->title }}</td>
    <td>{{ formatDate($category->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.design.tip.category', ['id' => $category->id]) }}">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.design.tip.category', ['id' => $category->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach