@foreach ($enquiries as $enquiry)
<tr>
    <td>{{ $enquiry->id }}</td>
    <td>{{ $enquiry->name }}</td>
    <td>{{ $enquiry->email }}</td>
    <td>{{ ($enquiry->phone) ? $enquiry->phone : 'N/A' }}</td>
    <td>{{ $enquiry->subject }}</td>
    <td>{{ formatDate($enquiry->created_at) }}</td>
    <td>
        <a class="ajax-content" href="{{ route('admin::view.enquiry.message', ['id' => $enquiry->id]) }}">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.enquiry', ['id' => $enquiry->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach