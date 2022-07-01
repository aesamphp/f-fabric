@foreach ($carousels as $carousel)
    <tr>
        <td>{{ $carousel->id }}</td>
        <td>{{ $carousel->title }}</td>
        <td>{{ formatDate($carousel->created_at) }}</td>
        <td>
            <a href="{{ route('admin::view.carousel', ['id' => $carousel->id]) }}">
                <i class="material-icons teal-icon">pageview</i>
            </a>
        </td>
    </tr>
@endforeach