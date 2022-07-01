@foreach ($discountCodes as $code)
<tr>
    <td>{{ $code->id }}</td>
    <td>{{ $code->code }}</td>
    <td>{{ $code->getUseType() }}</td>
    <td>{{ $code->getDateLimit() }}</td>
    <td>{{ $code->getValueWithSymbol() }}</td>
    <td>{{ $code->getUsedCount() }}</td>
    <td>{{ formatDate($code->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.discount.code', ['id' => $code->id]) }}" title="View">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.discount.code', ['id' => $code->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit" title="Delete">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach