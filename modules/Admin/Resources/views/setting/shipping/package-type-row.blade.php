@foreach ($packageTypes as $package)
<tr>
    <td>{{ $package->id }}</td>
    <td>{{ $package->title }}</td>
    <td>{{ formatDate($package->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.shipping.package.type', ['id' => $package->id]) }}">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.shipping.package.type', ['id' => $package->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach