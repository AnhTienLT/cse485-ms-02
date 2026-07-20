<?php

declare(strict_types=1);

/**
 * Tính thành tiền của một dòng sản phẩm.
 */
function lineTotal(array $product): int
{
    return $product['price'] * $product['qty'];
}

/**
 * Tính tổng giá trị của toàn bộ kho hàng.
 */
function inventoryValue(array $products): int
{
    $totalValue = 0;

    foreach ($products as $product) {
        $totalValue += lineTotal($product);
    }

    return $totalValue;
}

/**
 * Tìm sản phẩm theo SKU.
 */
function findProductBySku(array $products, string $sku): ?array
{
    foreach ($products as $product) {
        if ($product['sku'] === $sku) {
            return $product;
        }
    }

    return null;
}

/**
 * Đếm số sản phẩm thuộc một danh mục cụ thể.
 */
function countByCategory(array $products, int $categoryId): int
{
    $count = 0;

    foreach ($products as $product) {
        if ((int) $product['category_id'] === $categoryId) {
            $count++;
        }
    }

    return $count;
}

/**
 * Xác định mức tồn kho theo quy tắc đã cho.
 */
function stockLevel(array $product): string
{
    if ($product['qty'] >= 5) {
        return 'Du';
    } elseif ($product['qty'] >= 2) {
        return 'Sap het';
    } else {
        return 'Can nhap';
    }
}

/**
 * Lọc sản phẩm theo danh mục.
 */
function filterByCategory(array $products, ?int $categoryId): array
{
    $filteredProducts = [];

    foreach ($products as $product) {
        if ($categoryId === null || $categoryId === 0) {
            $filteredProducts[] = $product;
        } elseif ((int) $product['category_id'] === $categoryId) {
            $filteredProducts[] = $product;
        }
    }

    return $filteredProducts;
}

/**
 * Xác định quy mô kho theo giá trị tồn kho.
 */
function rankInventory(int $totalValue): string
{
    if ($totalValue < 15000000) {
        return 'Nho';
    } elseif ($totalValue < 35000000) {
        return 'Trung binh';
    } else {
        return 'Lon';
    }
}

/**
 * Render toàn bộ hàng sản phẩm ra bảng HTML.
 */
function renderProductRows(array $products, array $categoryMap): void
{
    foreach ($products as $product) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars((string) $product['sku']) . '</td>';
        echo '<td>' . htmlspecialchars((string) $product['name']) . '</td>';
        echo '<td>' . htmlspecialchars((string) $categoryMap[(int) $product['category_id']]) . '</td>';
        echo '<td>' . number_format((int) $product['price'], 0, ',', '.') . '</td>';
        echo '<td>' . (int) $product['qty'] . '</td>';
        echo '<td>' . number_format(lineTotal($product), 0, ',', '.') . '</td>';
        echo '<td>' . htmlspecialchars(stockLevel($product)) . '</td>';
        echo '</tr>';
    }
}
