@foreach ($products as $product)
<tr>
    <td>{{ $product->id }}</td>
    <td>{{ $product->title }}</td>
    <td>{{ $product->category->title }}</td>
    <td>{{ formatDate($product->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.cms.product', ['id' => $product->id]) }}">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.cms.product', ['id' => $product->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach