@foreach ($commissions as $commission)
<tr>
    <td>
        @if (!$commission->isPaid())
        <input id="sales-{{ $commission->id }}" type="checkbox" class="filled-in" name="sales[]" value="{{ $commission->id }}" />
        <label for="sales-{{ $commission->id }}">&nbsp;</label>
        @endif
    </td>
    <td>{{ $commission->id }}</td>
    <td>
        <a href="{{ route('admin::view.contributor', ['id' => $commission->user->id]) }}" title="View">{{ $commission->user->friendly_id }}</a>
    </td>
    <td>{{ $commission->user->getFullName() }}</td>
    <td>
        <a href="{{ route('admin::view.order', ['id' => $commission->orderItem->order->id]) }}" title="View">{{ $commission->orderItem->order->friendly_id }}</a>
    </td>
    <td>&pound;{{ formatPrice($commission->amount) }}</td>
    <td>{{ $commission->getPaymentMethodTitle() }}</td>
    <td>{{ $commission->getType() }}</td>
    <td>{{ $commission->getStatus() }}</td>
    <td>{{ formatDate($commission->created_at) }}</td>
    <td>
        @if (!$commission->isPaid() && $commission->user->hasPaymentDetails())
        <form action="{{ route('admin::pay.commission', ['id' => $commission->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <button class="btn-material-icon" type="submit" title="Pay">
                <i class="material-icons teal-icon">payment</i>
            </button>
        </form>
        @endif
    </td>
</tr>
@endforeach