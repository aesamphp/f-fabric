<div class="col s12">
    <div class="row">
        <a class="btn teal waves-effect waves-light right" href="{{ route('admin::new.product.material', ['id' => $product->id]) }}">Add New</a>
    </div>
</div>
@if (count($product->productMaterials) > 0)
<table class="responsive-table data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Material</th>
            <th>Price</th>
            <th>Created</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($product->productMaterials as $productMaterial)
        <tr>
            <td>{{ $productMaterial->id }}</td>
            <td>{{ ($productMaterial->material) ? $productMaterial->material->title : 'N/A' }}</td>
            <td>{{ $productMaterial->price }}</td>
            <td>{{ formatDate($productMaterial->created_at) }}</td>
            <td>
                <a href="{{ route('admin::view.product.material', ['id' => ($productMaterial->material_id) ? $productMaterial->product_id : $productMaterial->id, 'materialId' => ($productMaterial->material_id) ? $productMaterial->material_id : 'none']) }}" title="View">
                    <i class="material-icons teal-icon">pageview</i>
                </a>
                <form class="delete-form" action="{{ route('admin::delete.product.material', ['id' => ($productMaterial->material_id) ? $productMaterial->product_id : $productMaterial->id, 'materialId' => ($productMaterial->material_id) ? $productMaterial->material_id : 'none']) }}" method="POST">
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