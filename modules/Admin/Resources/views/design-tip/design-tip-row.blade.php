@foreach ($designTips as $designTip)
<tr>
    <td>{{ $designTip->id }}</td>
    <td>{{ $designTip->title }}</td>
    <td>{{ $designTip->category->title }}</td>
    <td>{{ formatDate($designTip->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.design.tip', ['id' => $designTip->id]) }}">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.design.tip', ['id' => $designTip->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach