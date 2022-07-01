@foreach ($menus as $menu)
  <tr>
    <td>{{ $menu->id }}</td>
    <td>{{ $menu->title }}</td>
    <td>{{ formatDate($menu->created_at) }}</td>
    <td>@if (!$menu->status) Disabled @else Enabled @endif</td>
    <td>
      <a href="{{ route('admin::view.menu', ['id' => $menu->id]) }}">
        <i class="material-icons teal-icon">menuview</i>
      </a>
      <form class="delete-form" action="{{ route('admin::delete.menu', ['id' => $menu->id]) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button class="btn-delete" type="submit">
          <i class="material-icons teal-icon">delete</i>
        </button>
      </form>
    </td>
  </tr>
@endforeach