<?php
$api_token = 'w5niNBvGrR7c1aLIH2OMhvLkyS07iz6o95CLwx5n01qIeBfkrQXJQUiVCGet';
$endpoint = 'https://api.paradisepagbr.com/api/public/v1';

$products_url = $endpoint . "/products?api_token=" . $api_token;
$products = json_decode(file_get_contents($products_url), true);

if (!isset($products['data']) || empty($products['data'])) {
    echo "Nenhum produto encontrado ou token inválido.\n";
    exit;
}

foreach ($products['data'] as $product) {
    echo "📦 Produto: " . $product['title'] . "\n";
    echo "🔑 Product Hash: " . $product['hash'] . "\n";

    $offers_url = $endpoint . "/products/" . $product['hash'] . "/offers?api_token=" . $api_token;
    $offers = json_decode(file_get_contents($offers_url), true);

    if (!isset($offers['data']) || empty($offers['data'])) {
        echo "   ❌ Nenhuma oferta encontrada.\n\n";
        continue;
    }

    foreach ($offers['data'] as $offer) {
        echo "   💰 Oferta: " . $offer['title'] . " | 💲 " . number_format($offer['amount'] / 100, 2, ',', '.') . "\n";
        echo "   🔑 Offer Hash: " . $offer['hash'] . "\n";
    }

    echo "\n";
}
?>