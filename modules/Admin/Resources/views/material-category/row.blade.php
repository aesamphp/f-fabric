@foreach ($materialCategories as $materialCategory)
    <tr class="sort" data-action="{{ route('admin::sort.material-category', ['id' => $materialCategory->id]) }}">
        <td>{{ $materialCategory->id }}</td>
        <td>{{ $materialCategory->title }}</td>
        <td>{{ formatDate($materialCategory->created_at) }}</td>
        <td>
            <a href="{{ route('admin::edit.material-category', ['id' => $materialCategory->id]) }}" title="View">
                <i class="material-icons teal-icon">pageview</i>
            </a>
        </td>
    </tr>
@endforeach