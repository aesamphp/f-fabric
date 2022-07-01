@foreach ($zones as $zone)
<tr>
    <td>{{ $zone->id }}</td>
    <td>{{ $zone->title }}</td>
    <td>{{ formatDate($zone->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.shipping.zone', ['id' => $zone->id]) }}">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.shipping.zone', ['id' => $zone->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach