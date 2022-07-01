<div class="col s12">
    <div class="row">
        <a class="btn teal waves-effect waves-light right" href="{{ route('admin::new.product.quantity', ['id' => $product->id]) }}">Add New</a>
    </div>
</div>
@if (count($product->productQuantities) > 0)
<table class="responsive-table data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Created</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($product->productQuantities as $productQuantity)
        <tr>
            <td>{{ $productQuantity->id }}</td>
            <td>{{ $productQuantity->getTitle() }}</td>
            <td>{{ formatDate($productQuantity->created_at) }}</td>
            <td>
                <a href="{{ route('admin::view.product.quantity', ['id' => $productQuantity->product_id, 'quantityId' => $productQuantity->id]) }}" title="View">
                    <i class="material-icons teal-icon">pageview</i>
                </a>
                <form class="delete-form" action="{{ route('admin::delete.product.quantity', ['id' => $productQuantity->product_id, 'quantityId' => $productQuantity->id]) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn-delete" type="submit" title="Delete">
                        <i class="material-icons teal-icon">delete</i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>I don't have any records!</p>
@endif