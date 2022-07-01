<div class="col s12">
    <div class="row">
        <a class="btn teal waves-effect waves-light right" href="{{ route('admin::new.product.package.type', ['id' => $product->id]) }}">Add New</a>
    </div>
</div>
@if (count($product->packageTypes) > 0)
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
        @foreach ($product->packageTypes as $packageType)
        <tr>
            <td>{{ $packageType->id }}</td>
            <td>{{ $packageType->packageType->title }}</td>
            <td>{{ formatDate($packageType->created_at) }}</td>
            <td>
                <form class="delete-form" action="{{ route('admin::delete.product.package.type', ['id' => $packageType->product_id, 'packageTypeId' => $packageType->package_type_id]) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn-delete" type="submit">
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