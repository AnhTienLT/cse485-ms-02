<?php
require_once 'data.php';
require_once 'helpers.php';

// Lấy tham số danh mục từ URL
$categoryId = isset($_GET['category_id'])
    ? (int) $_GET['category_id']
    : null;

// Lọc sản phẩm theo danh mục
$filteredProducts = filterByCategory($products, $categoryId);

// Tính tổng giá trị kho và quy mô kho
$totalInventory = inventoryValue($filteredProducts);
$inventoryRank = rankInventory($totalInventory);

// Tạo map danh mục để hiển thị tên danh mục
$categoryMap = [];
foreach ($categories as $category) {
    $categoryMap[$category['id']] = $category['name'];
}

// Tính báo cáo theo danh mục bằng foreach
$categoryReport = [];
foreach ($categories as $category) {
    $categoryProducts = filterByCategory($products, (int) $category['id']);
    $categoryReport[] = [
        'name' => $category['name'],
        'count' => countByCategory($products, (int) $category['id']),
        'value' => inventoryValue($categoryProducts),
    ];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>MiniShop — Phiếu 02</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background: #eee; }
        .menu a { margin-right: 10px; }
    </style>
</head>
<body>

<h2>MiniShop — Phiếu 02</h2>

<h3>Menu lọc</h3>
<div class="menu">
    <a href="index.php">Tất cả</a>
    <a href="index.php?category_id=1">Bàn phím</a>
    <a href="index.php?category_id=2">Chuột</a>
    <a href="index.php?category_id=3">Màn hình</a>
</div>

<h3>Bảng sản phẩm</h3>
<table>
    <tr>
        <th>SKU</th>
        <th>Tên</th>
        <th>Danh mục</th>
        <th>Giá</th>
        <th>Qty</th>
        <th>Thành tiền</th>
        <th>Mức tồn</th>
    </tr>
    <?php renderProductRows($filteredProducts, $categoryMap); ?>
</table>

<h3>Tổng giá trị kho</h3>
<p><?php echo number_format($totalInventory, 0, ',', '.'); ?></p>

<h3>Quy mô kho</h3>
<p><?php echo htmlspecialchars($inventoryRank); ?></p>

<h3>Báo cáo theo danh mục</h3>
<table>
    <tr>
        <th>Danh mục</th>
        <th>Số sản phẩm</th>
        <th>Tổng giá trị</th>
    </tr>
    <?php foreach ($categoryReport as $report): ?>
        <tr>
            <td><?php echo htmlspecialchars($report['name']); ?></td>
            <td><?php echo (int) $report['count']; ?></td>
            <td><?php echo number_format((int) $report['value'], 0, ',', '.'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- MS_EXPECT inventory_value=41380000 rank=Lon -->

</body>
</html>