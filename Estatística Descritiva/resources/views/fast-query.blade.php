<h2>Consulta Rápida (Com Cache)</h2>
<p>Tempo: {{ number_format($time, 5) }} segundos</p>
<p>Registros: {{ count($orders) }}</p>
<table>
    <tr>
        <th>Cliente</th>
        <th>Total Pedidos</th>
        <th>Total Itens</th>
        <th>Total Gasto</th>
        <th>Média Ticket</th>
    </tr>
    @foreach($orders as $order)
        <tr>
            <td>{{ $order['customer'] }}</td>
            <td>{{ $order['total_orders'] }}</td>
            <td>{{ $order['total_items'] }}</td>
            <td>{{ $order['total_spent'] }}</td>
            <td>{{ $order['avg_ticket'] }}</td>
        </tr>
    @endforeach
</table>
