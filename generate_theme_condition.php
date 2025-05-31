<?php
/**
 * Tool để tự động tạo điều kiện theme cho module test
 * Quét thư mục admin và tạo ra đoạn code điều kiện
 */

function generateThemeCondition($moduleName = 'test', $adminPath = 'src/modules/test/admin/') {
    // Kiểm tra thư mục có tồn tại không
    if (!is_dir($adminPath)) {
        echo "Thư mục không tồn tại: $adminPath\n";
        return false;
    }
    
    // Lấy danh sách file PHP trong thư mục admin
    $files = scandir($adminPath);
    $phpFiles = [];
    
    foreach ($files as $file) {
        // Chỉ lấy file .php và bỏ qua index.html
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            // Lấy tên file không có extension
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $phpFiles[] = $fileName;
        }
    }
    
    // Sắp xếp theo thứ tự alphabet
    sort($phpFiles);
    
    if (empty($phpFiles)) {
        echo "Không tìm thấy file PHP nào trong thư mục admin\n";
        return false;
    }
    
    // Tạo chuỗi điều kiện
    $fileList = "'" . implode("', '", $phpFiles) . "'";
    
    $condition = "if ((\$module_info['module_file'] ?? '') == '$moduleName' and in_array(\$op, [$fileList])) {\n";
    $condition .= "        return \$new_theme;\n";
    $condition .= "    }";
    
    return [
        'condition' => $condition,
        'files' => $phpFiles,
        'count' => count($phpFiles)
    ];
}

// Chạy tool
echo "=== TOOL TẠO ĐIỀU KIỆN THEME CHO MODULE TEST ===\n\n";

$result = generateThemeCondition();

if ($result) {
    echo "Tìm thấy {$result['count']} file PHP trong thư mục admin:\n";
    echo "- " . implode("\n- ", $result['files']) . "\n\n";
    
    echo "Đoạn code điều kiện được tạo:\n";
    echo "```php\n";
    echo $result['condition'] . "\n";
    echo "```\n\n";
    
    echo "Copy đoạn code trên và paste vào file get_global_admin_theme.php\n";
} else {
    echo "Có lỗi xảy ra khi tạo điều kiện theme.\n";
}

// Tùy chọn: Lưu kết quả vào file
$outputFile = 'theme_condition_output.txt';
if ($result) {
    $output = "// Điều kiện theme cho module test\n";
    $output .= "// Tạo tự động từ " . count($result['files']) . " file PHP\n";
    $output .= "// Ngày tạo: " . date('Y-m-d H:i:s') . "\n\n";
    $output .= $result['condition'];
    
    file_put_contents($outputFile, $output);
    echo "Đã lưu kết quả vào file: $outputFile\n";
}
?>
