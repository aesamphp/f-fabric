@foreach ($notificationBanners as $notificationBanner)
  <tr>
    <td>{{ $notificationBanner->id }}</td>
    <td>{{ $notificationBanner->text }}</td>
    <td>{{ $notificationBanner->enabled ? 'Yes' : 'No' }}</td>
    <td>{{ formatDate($notificationBanner->created_at) }}</td>
    <td>
      <a href="{{ route('admin::view.notification.banner', ['notificationBanner' => $notificationBanner->id]) }}">
        <i class="material-icons teal-icon">pageview</i>
      </a>
      <form class="delete-form" method="POST" 
        action="{{ route('admin::destroy.notification.banner', ['notificationBanner' => $notificationBanner->id]) }}" >
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button class="btn-delete" type="submit">
          <i class="material-icons teal-icon">delete</i>
        </button>
      </form>
    </td>
  </tr>
@endforeach