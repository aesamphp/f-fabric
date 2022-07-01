@foreach ($users as $user)
<tr>
    <td>{{ $user->id }}</td>
    <td>{{ $user->friendly_id }}</td>
    <td>{{ $user->getFullName() }}</td>
    <td>{{ $user->username }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ formatDate($user->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.admin', ['id' => $user->id]) }}" title="View">
            <i class="material-icons teal-icon">pageview</i>
        </a>
    </td>
</tr>
@endforeach