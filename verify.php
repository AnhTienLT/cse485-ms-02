<?php
require 'data.php';
require 'helpers.php';

echo 'inventoryValue=' . inventoryValue($products) . PHP_EOL;
$skuProduct = findProductBySku($products, 'MN-02');
echo 'skuName=' . ($skuProduct['name'] ?? 'NOT FOUND') . PHP_EOL;
$filtered = filterByCategory($products, 2);
echo 'filterCount=' . count($filtered) . PHP_EOL;
foreach ($filtered as $p) {
    echo $p['sku'] . '|' . $p['name'] . '|' . $p['qty'] . '|' . stockLevel($p) . PHP_EOL;
}
echo 'report=';
foreach ($categories as $c) {
    $catProducts = filterByCategory($products, (int) $c['id']);
    echo $c['name'] . ':' . countByCategory($products, (int) $c['id']) . '/' . inventoryValue($catProducts) . ' , ';
}
echo PHP_EOL;
echo 'rank=' . rankInventory(inventoryValue($products)) . PHP_EOL;
?>
