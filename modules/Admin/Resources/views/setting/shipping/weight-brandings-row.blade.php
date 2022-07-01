@foreach ($weightBrandings as $branding)
<tr>
    <td>{{ $branding->id }}</td>
    <td>{{ $branding->title }}</td>
    <td>{{ $branding->getType() }}</td>
    <td>{{ $branding->max_weight }}</td>
    <td>{{ formatDate($branding->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.shipping.weight.branding', ['id' => $branding->id]) }}">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.shipping.weight.branding', ['id' => $branding->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach