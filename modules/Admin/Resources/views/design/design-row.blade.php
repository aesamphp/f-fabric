@foreach ($designs as $design)
<tr>
    <td>{{ $design->id }}</td>
    <td>
        <img class="materialboxed" src="{{ asset($design->getThumbnailImagePath()) }}" alt="Image" />
    </td>
    <td>{{ $design->title }}</td>
    <td>{{ $design->user->username }}</td>
    <td class="{{ ($design->isApproved() && $design->isDispatchApproved()) ? 'text-green' : 'text-red' }}">{{ ($design->isApproved() && $design->isDispatchApproved()) ? 'Approved' : 'Disapproved' }}</td>
    @if ($design->isPublic())
    <td class="text-green">Public</td>
    @elseif ($design->isPrivate())
    <td class="text-red">Private</td>
    @else
    <td class="text-orange">Display Only</td>
    @endif
    <td>{{ formatDate($design->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.design', ['id' => $design->id]) }}" title="View">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <a href="{{ route('admin::download.design.file', ['id' => $design->id]) }}" title="Download File">
            <i class="material-icons teal-icon">play_for_work</i>
        </a>
        <a href="{{ route('admin::view.design.comments', ['id' => $design->id]) }}" title="View Comments">
            <i class="material-icons teal-icon font-22">comment</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.design', ['id' => $design->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit" title="Delete">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
        @if (!$design->isShoppable())
        <form class="activate-form" action="{{ route('admin::update.design', ['id' => $design->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <input type="hidden" name="private" value="0" />
            <input type="hidden" name="public" value="1" />
            <input type="hidden" name="swatch_purchased" value="1" />
            <input type="hidden" name="dispatch_approved" value="1" />
            <input type="hidden" name="approved" value="1" />
            <button class="btn-material-icon" type="submit" title="Activate">
                <i class="material-icons teal-icon">lock_open</i>
            </button>
        </form>
        @endif
    </td>
</tr>
@endforeach