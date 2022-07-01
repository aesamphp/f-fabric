@foreach ($rows as $row)
    <tr>
        <td>{{ $row->id }}</td>
        <td>{{ $row->title }}</td>
        <td>
            @if ($row->status == App\Models\Row::ENABLE)
                Enabled
            @else
                Disabled
            @endif
        </td>
        <td>
            @if ($row->type == App\Models\Row::ROW_TYPE_DEFAULT)
                Default
            @elseif($row->type == App\Models\Row::ROW_TYPE_LABEL)
                Label
            @elseif($row->type == App\Models\Row::ROW_TYPE_DESIGNER)
                Designer
            @elseif($row->type == App\Models\Row::ROW_TYPE_DESIGN)
                Designs
            @endif
        </td>
        <td>
            @if ($row->type == App\Models\Row::ROW_TYPE_DEFAULT)
                @if ($row->data == App\Models\Row::DEFAULT_ROW_TYPE_POPULAR_PRODUCTS)
                    Popular Products
                @elseif($row->data == App\Models\Row::DEFAULT_ROW_TYPE_OUR_TOP_SELLERS)
                    Top Seller
                @elseif($row->data == App\Models\Row::DEFAULT_ROW_TYPE_RECENTLY_ADDED)
                    Recently Added
                @endif
            @elseif($row->type == App\Models\Row::ROW_TYPE_LABEL && $row->label())
                {{ $row->label()->title }}
            @elseif($row->type == App\Models\Row::ROW_TYPE_DESIGNER && $row->studio())
                {{ $row->studio()->getFullName() }}
            @elseif($row->type == App\Models\Row::ROW_TYPE_DESIGN && $row->designs)
                @foreach($row->designs as $design)
                    <p>{{ $design->title }}</p>
                @endforeach
            @endif
        </td>
        <td>{{ formatDate($row->created_at) }}</td>
        <td>
            <a href="{{ route('admin::view.row', ['id' => $row->id]) }}">
                <i class="material-icons teal-icon">pageview</i>
            </a>
            <form class="delete-form" action="{{ route('admin::delete.row', ['id' => $row->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn-delete" type="submit">
                    <i class="material-icons teal-icon">delete</i>
                </button>
            </form>
        </td>
    </tr>
@endforeach