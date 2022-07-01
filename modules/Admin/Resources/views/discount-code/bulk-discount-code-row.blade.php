@foreach ($discountCodeGroups as $category)
<tr>
    <td>{{ $category->id }}</td>
    <td>{{ $category->prefix }}</td>
    <td>{{ $category->getUseType() }}</td>
    <td>{{ $category->getDateLimit() }}</td>
    <td>{{ $category->getValueWithSymbol() }}</td>
    <td>{{ $category->getUsedCount() }}</td>
    <td>{{ formatDate($category->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.group.discount.codes', ['group_id' => $category->id]) }}" title="View">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <a href="{{ route('admin::download.discount.codes.csv', ['id' => $category->id ]) }}" title="View">
            <i class="material-icons teal-icon">cloud_download</i>
        </a>
    </td>
</tr>
@endforeach