<div class="col s12">
    <div class="row">
        <a class="btn teal waves-effect waves-light right" href="{{ route('admin::new.shipping.zone.country', ['id' => $zone->id]) }}">Add New</a>
    </div>
</div>
@if (count($zone->countries) > 0)
<table class="responsive-table data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Code</th>
            <th>Created</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($zone->countries as $country)
        <tr>
            <td>{{ $country->id }}</td>
            <td>{{ $country->title }}</td>
            <td>{{ $country->code }}</td>
            <td>{{ formatDate($country->created_at) }}</td>
            <td>
                <form class="delete-form" action="{{ route('admin::delete.shipping.zone.country', ['id' => $country->zone_id, 'countryId' => $country->id]) }}" method="POST">
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