<div class="col s12">
    <div class="row">
        <a class="btn teal waves-effect waves-light right" href="{{ route('admin::new.shipping.zone.weight.branding', ['id' => $zone->id]) }}">Add New</a>
    </div>
</div>
@if (count($zone->brandings) > 0)
<table class="responsive-table data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Max Weight</th>
            <th>Price</th>
            <th>Created</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($zone->brandings as $branding)
        <tr>
            <td>{{ $branding->id }}</td>
            <td>{{ $branding->branding->title }}</td>
            <td>{{ $branding->branding->max_weight }}</td>
            <td>{{ $branding->price }}</td>
            <td>{{ formatDate($branding->created_at) }}</td>
            <td>
                <a href="{{ route('admin::view.shipping.zone.weight.branding', ['id' => $branding->zone_id, 'weightBrandingId' => $branding->weight_branding_id]) }}">
                    <i class="material-icons teal-icon">pageview</i>
                </a>
                <form class="delete-form" action="{{ route('admin::delete.shipping.zone.weight.branding', ['id' => $branding->zone_id, 'weightBrandingId' => $branding->weight_branding_id]) }}" method="POST">
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