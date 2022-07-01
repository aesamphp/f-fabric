@foreach ($blocks as $block)
<tr>
    <td>{{ $block->id }}</td>
    <td>{{ $block->title }}</td>
    <td>
        <img class="materialboxed" src="{{ asset($block->image_path) }}" alt="Image" />
    </td>
    <td>{{ formatDate($block->created_at) }}</td>
    <td>{{ $block->display_type }}</td>
    <td>
        <a href="{{ route('admin::view.block', ['id' => $block->id]) }}">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.block', ['id' => $block->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach