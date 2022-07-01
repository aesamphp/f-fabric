@foreach ($pages as $page)
    <tr>
        <td>{{ $page->id }}</td>
        <td>{{ $page->title }}</td>
        <td>{{ formatDate($page->created_at) }}</td>
        <td>@if (!$page->status) Disabled @else Enabled @endif</td>
        <td>
            <a href="{{ route('admin::show.page', ['id' => $page->id]) }}">
                <i class="material-icons teal-icon">pageview</i>
            </a>
            <form class="delete-form" action="{{ route('admin::destroy.page', ['id' => $page->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn-delete" type="submit">
                    <i class="material-icons teal-icon">delete</i>
                </button>
            </form>

        </td>
    </tr>
@endforeach