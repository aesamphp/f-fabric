@foreach ($materials as $material)
<tr>
    <td>{{ $material->id }}</td>
    <td>{{ $material->title }}</td>
    <td>{{ $material->code }}</td>
    <td>{{ isset($material->category) ? $material->category->title : '' }}</td>
    <td>{{ $material->composition }}</td>
    <td>{{ $material->gsm }}</td>
    <td>{{ $material->max_width }}</td>
    <td>{{ formatDate($material->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.material', ['id' => $material->id]) }}" title="View">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.material', ['id' => $material->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit" title="Delete">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach