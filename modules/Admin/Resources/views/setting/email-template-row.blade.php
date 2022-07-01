@foreach ($templates as $template)
<tr>
    <td>{{ $template->id }}</td>
    <td>{{ $template->title }}</td>
    <td>{{ $template->subject }}</td>
    <td>{{ $template->action->title }}</td>
    <td>{{ formatDate($template->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.email.template', ['id' => $template->id]) }}">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.email.template', ['id' => $template->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach