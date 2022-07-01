@foreach ($weeklyContests as $weeklyContest)
<tr>
    <td>{{ $weeklyContest->id }}</td>
    <td>{{ $weeklyContest->title }}</td>
    <td>{{ formatDate($weeklyContest->from_date) }}</td>
    <td>{{ formatDate($weeklyContest->to_date) }}</td>
    <td>{{ $weeklyContest->getStatus() }}</td>
    <td>{{ formatDate($weeklyContest->created_at) }}</td>
     <td>
        <a href="{{ route('admin::view.weekly.contest', ['id' => $weeklyContest->id]) }}" title="View">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.weekly.contest', ['id' => $weeklyContest->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit" title="Delete">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach