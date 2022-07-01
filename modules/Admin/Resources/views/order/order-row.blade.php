@foreach ($orders as $order)
<tr>
    <td>{{ $order->friendly_id }}</td>
    <td>{{ $order->user->friendly_id }}</td>
    <td>{{ $order->user->getFullName() }}</td>
    <td>{{ formatPrice($order->getTotalAmount()) }}</td>
    <td>{{ $order->currency }}</td>
    <td @if (!$order->isDispatched()) class="text-red" @endif>{{ $order->getStatus() }}</td>
    <td>{{ formatDate($order->created_at) }}</td>
    <td>
        <a href="{{ route('admin::view.order', ['id' => $order->id]) }}" title="View">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        <form class="delete-form" action="{{ route('admin::delete.order', ['id' => $order->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn-delete" type="submit" title="Delete">
                <i class="material-icons teal-icon">delete</i>
            </button>
        </form>
    </td>
</tr>
@endforeach
