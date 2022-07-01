@foreach ($faqs as $faq)
<tr>
    <td>{{ $faq->id }}</td>
    <td>{{ $faq->title }}</td>
    <td>{{ $faq->category->title }}</td>
    <td>{{ formatDate($faq->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.faq', ['id' => $faq->id]) }}">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.faq', ['id' => $faq->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach