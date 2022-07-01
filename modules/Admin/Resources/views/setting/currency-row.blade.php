@foreach ($currencies as $currency)
<tr>
    <td>{{ $currency->id }}</td>
    <td>{{ $currency->title }}</td>
    <td>{{ $currency->code }}</td>
    <td>{{ formatPrice($currency->exchange_rate) }}</td>
    <td>{{ formatDate($currency->created_at) }}</td>
    <td>
        @if (!$currency->isDefault())
        <a href="{{ route('admin::view.currency', ['id' => $currency->id]) }}">
            <i class="material-icons teal-icon">pageview</i>
        </a>
        @endif
    </td>
</tr>
@endforeach