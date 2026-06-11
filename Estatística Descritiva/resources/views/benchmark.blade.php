<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Benchmark</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; }
        table { border-collapse: collapse; width: 100%; margin-top: 1rem; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: center; }
        th { background: #f5f5f5; }
        .destaque { font-weight: bold; background: #eaffea; }
    </style>
</head>
<body>
<h1>Benchmark — Cache vs Sem Cache</h1>
<h2>Resumo</h2>
<table>
    <tr>
        <th>Métrica</th>
        <th>Sem Cache</th>
        <th>Com Cache</th>
    </tr>
    <tr>
        <td>Média (s)</td>
        <td>{{ number_format($slowAvg, 5) }}</td>
        <td class="destaque">{{ number_format($fastAvg, 5) }}</td>
    </tr>
    <tr>
        <td>Fator de melhoria</td>
        <td colspan="2" class="destaque">{{ number_format($speedup, 1) }}× mais rápido com cache</td>
    </tr>
</table>
<h2>Execuções individuais</h2>
<table>
    <tr>
        <th>#</th>
        <th>Sem Cache (s)</th>
        <th>Com Cache (s)</th>
        <th>Fator</th>
    </tr>
    @foreach($slowTimes as $i => $slow)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ number_format($slow, 5) }}</td>
            <td>{{ number_format($fastTimes[$i], 5) }}</td>
            <td>{{ number_format($slow / $fastTimes[$i], 1) }}×</td>
        </tr>
    @endforeach
</table>
</body>
</html>
