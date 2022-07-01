@foreach ($products as $product)
<tr>
    <td>{{ $product->id }}</td>
    <td>{{ $product->title }}</td>
    <td>{{ $product->category->title }}</td>
    <td>{{ $product->sku }}</td>
    <td>{{ ($product->width) ? $product->width : $product->width_text }}</td>
    <td>{{ ($product->height) ? $product->height : $product->height_text }}</td>
    <td>{{ $product->weight }}</td>
    <td>{{ formatDate($product->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.product', ['id' => $product->id]) }}" title="View">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.product', ['id' => $product->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit" title="Delete">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach