<form method="POST" action="{{ route('admin::store.menuitem', ['id' => $menu->id]) }}">
  {{ csrf_field() }}
  <input type="hidden" name="menu_id" value="{{ $menu->id }}">

  <table class="responsive-table create-menu-item-table">
    <thead>
    <tr>
      <th>Order</th>
      <th>Title</th>
      <th>Page</th>
      <th>Section</th>
      <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    <tr>
      <td>
        <input type="text" name="sort_order" placeholder="#">
      </td>
      <td>
        <input type="text" name="title" placeholder="Enter Title">
      </td>
      <td>
        <select name="route" id="route" class="material-select validate">
          @foreach($routes as $label => $value)
            <option value="{{ $value }}">{{ $label }}</option>
          @endforeach
        </select>
      </td>
      <td>
        <select name="menu_section_id" class="material-select">
          <option value="">Select Section</option>

          @foreach($menu->menuSections as $id => $value)
            <option value="{{ $value->id }}">{{ $value->title }}</option>
          @endforeach
        </select>
      </td>
      <td>
        <button class="btn waves-effect waves-light" type="submit">Create</button>
      </td>
    </tr>
    </tbody>
  </table>
</form>