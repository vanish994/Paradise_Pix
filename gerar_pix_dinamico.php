<?php
$access_token = 'w5niNBvGrR7c1aLIH2OMhvLkyS07iz6o95CLwx5n01qIeBfkrQXJQUiVCGet';
$offer_hash = 'hcctaeaqh9';
$product_hash = 'xhtuihze7n';
$api_url = 'https://api.paradisepagbr.com/api/public/v1/transactions?api_token=' . $access_token;

$amount = isset($_GET['valor']) ? intval($_GET['valor']) : 990;
$referencia = $_GET['ref'] ?? 'pix_' . time();

$payload = [
    "amount" => $amount,
    "offer_hash" => $offer_hash,
    "payment_method" => "pix",
    "customer" => [
        "name" => "Cliente Teste",
        "email" => "teste@email.com",
        "document" => "12345678900",
        "phone" => "11999999999"
    ],
    "cart" => [
        [
            "product_hash" => $product_hash,
            "title" => "Pagamento Ref: $referencia",
            "cover" => null,
            "price" => $amount,
            "quantity" => 1,
            "operation_type" => 1,
            "tangible" => false
        ]
    ],
    "installments" => 1,
    "expire_in_days" => 1
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

if ($http_code === 201) {
    $data = json_decode($response, true);
    $link = $data['data']['checkout_url'];
    echo "✅ Pix gerado com sucesso!<br>";
    echo "<strong>Referência:</strong> $referencia<br>";
    echo "<a href='$link' target='_blank'>$link</a>";
} else {
    echo "Erro ao gerar Pix:<br>" . $response;
}
?>