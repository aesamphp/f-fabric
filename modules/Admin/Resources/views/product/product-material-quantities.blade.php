<div class="col s12">
    <div class="row">
        <a class="btn teal waves-effect waves-light right" href="{{ route('admin::new.product.material.quantity', ['id' => $productMaterial->id]) }}">Add New</a>
    </div>
</div>
@if (count($productMaterial->quantities) > 0)
<table class="responsive-table data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Created</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productMaterial->quantities as $quantity)
        <tr>
            <td>{{ $quantity->id }}</td>
            <td>{{ $quantity->quantity->getTitle() }}</td>
            <td>{{ $quantity->price }}</td>
            <td>{{ formatDate($quantity->created_at) }}</td>
            <td>
                <a href="{{ route('admin::view.product.material.quantity', ['id' => $quantity->product_material_id, 'quantityId' => $quantity->product_quantity_id]) }}" title="View">
                    <i class="material-icons teal-icon">pageview</i>
                </a>
                <form class="delete-form" action="{{ route('admin::delete.product.material.quantity', ['id' => $quantity->product_material_id, 'quantityId' => $quantity->product_quantity_id]) }}" method="POST">
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