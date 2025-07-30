<?php
$offer_hash    = 'HASH_DO_PRODUTO';
$access_token  = 'w5niNBvGrR7c1aLIH2OMhvLkyS07iz6o95CLwx5n01qIeBfkrQXJQUiVCGet';
$api_url       = 'https://api.paradisepagbr.com/api/public/v1/transactions?api_token=' . $access_token;

$cliente = [
    'name'   => 'Lucas Souza',
    'email'  => 'lucas@email.com',
    'cpf'    => '12345678900',
    'phone'  => '11999999999',
    'amount' => 990
];

$payload = [
    "amount" => $cliente['amount'],
    "offer_hash" => $offer_hash,
    "payment_method" => "pix",
    "customer" => [
        "name" => $cliente['name'],
        "email" => $cliente['email'],
        "document" => $cliente['cpf'],
        "phone" => $cliente['phone']
    ]
];

$ch = curl_init($api_url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($payload)
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);
if ($http_code === 201 && isset($data['data']['hash'])) {
    $hash = $data['data']['hash'];
    file_put_contents("hash.txt", $hash);
    echo "Pix gerado com sucesso! Hash: $hash";
} else {
    echo "Erro ao gerar Pix: $response";
}
?>