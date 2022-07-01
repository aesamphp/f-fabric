<div class="col s12">
    <div class="row">
        <a class="btn teal waves-effect waves-light right" href="{{ route('admin::new.carousel.slide', ['id' => $carousel->id]) }}">Add New</a>
    </div>
</div>
@if (count($carousel->slides) > 0)
<table class="responsive-table data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Sort</th>
            <th>Image</th>
            <th>Created</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($carousel->slides->sortBy('sort') as $slide)
        <tr>
            <td>{{ $slide->id }}</td>
            <td>{{ $slide->sort }}</td>
            <td>
                <img class="materialboxed" src="{{ asset($slide->image_path) }}" alt="Image" />
            </td>
            <td>{{ formatDate($slide->created_at) }}</td>
            <td>
                <a href="{{ route('admin::view.carousel.slide', ['id' => $slide->carousel_id, 'slideId' => $slide->id]) }}" title="View">
                    <i class="material-icons teal-icon">pageview</i>
                </a>
                <form class="delete-form" action="{{ route('admin::delete.carousel.slide', ['id' => $slide->carousel_id, 'slideId' => $slide->id]) }}" method="POST">
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