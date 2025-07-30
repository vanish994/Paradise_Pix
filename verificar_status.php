<?php
$api_token = 'w5niNBvGrR7c1aLIH2OMhvLkyS07iz6o95CLwx5n01qIeBfkrQXJQUiVCGet';
$base_url = 'https://api.paradisepagbr.com/api/public/v1/transactions/';

$hash = trim(file_get_contents("hash.txt"));
if (!$hash) {
    echo "Hash não encontrado";
    exit;
}

$url = $base_url . urlencode($hash) . '?api_token=' . $api_token;

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200) {
    $data = json_decode($response, true);
    $status = $data['data']['status'] ?? 'indefinido';
    $valor = $data['data']['amount'] ?? 0;

    echo "Status: $status<br>Valor: R$ " . number_format($valor / 100, 2, ',', '.');
    if ($status === 'paid') {
        echo "<br>✅ Pagamento confirmado!";
    }
} else {
    echo "Erro ao consultar status. Código $http_code<br>$response";
}
?>