<h2>Consulta Lenta (Sem Cache)</h2>
<p>Tempo: {{ number_format($time, 5) }} segundos</p>
<p>Registros: {{ $orders->count() }}</p>
<table>
    <tr>
        <th>Pedido</th>
        <th>Cliente</th>
        <th>Produto</th>
        <th>Qtd</th>
        <th>Total</th>
    </tr>
    @foreach($orders->take(50) as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->name }}</td>
            <td>{{ $order->product_name }}</td>
            <td>{{ $order->quantity }}</td>
            <td>{{ $order->total_amount }}</td>
        </tr>
    @endforeach
</table>
