<div class="col s12">
    <div class="row">
        <a class="btn teal waves-effect waves-light right" href="{{ route('admin::new.weight.branding.package.type.relation', ['id' => $weightBranding->id]) }}">Add New</a>
    </div>
</div>

@if (count($weightBranding->brandingPackages) > 0)
    <table class="responsive-table data-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Price</th>
            <th>Created</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($weightBranding->brandingPackages as $brandingPackage)
            <tr>
                <td>{{ $brandingPackage->id }}</td>
                <td>{{ $brandingPackage->package->title }}</td>
                <td>{{ $brandingPackage->price }}</td>
                <td>{{ formatDate($brandingPackage->created_at) }}</td>
                <td>
                    <a href="{{ route('admin::view.shipping.branding.package', ['id' => $brandingPackage->weight_branding_id, 'packageId' => $brandingPackage->package_type_id]) }}">
                        <i class="material-icons teal-icon">pageview</i>
                    </a>
                </td>
                <td>
                    <form class="delete-form" method="POST" action="{{ route('admin::delete.shipping.branding.package.type', ['id' => $brandingPackage->weight_branding_id, 'packageId' => $brandingPackage->package_type_id]) }}">
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