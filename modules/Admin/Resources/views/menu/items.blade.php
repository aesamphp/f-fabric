<table class="responsive-table edit-menu-items-table">
  <thead>
  <tr>
    <th>Order</th>
    <th>Title</th>
    <th>Page</th>
    <th>Active</th>
    <th>Edit</th>
    <th>&nbsp;</th>
  </tr>
  </thead>
  <tbody>
  @foreach($menuItems as $item)
    <tr>
      <td>{{ $item->sort_order }}</td>
      <td>{{ $item->title }}</td>
      <td>{{ $item->route }}</td>
      <td>{{ $item->active }}</td>
      <td>
        <a href="{{ route('admin::view.menuitem', $item->id) }}" title="View">
          <i class="material-icons">pageview</i>
        </a>
      </td>
      <td>
        <form class="delete-form" action="{{ route('admin::delete.menuitem', ['id' => $item->id]) }}" method="POST">
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