<?php
$dir = 'resources/views/admin/reports/pdf/';
$files = glob($dir . '*.blade.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Replace logo box with the logoich.png image
    $content = preg_replace('/<td width="60"><div class="logo-box">.*?<\/div><\/td>/us', '<td width="80"><img src="{{ public_path(\'images/logoich.png\') }}" style="width:70px; height:70px; object-fit:contain;"></td>', $content);
    
    // Remove the KPI emojis completely
    $content = preg_replace('/<div class="kpi-icon.*?">.*?<\/div>/us', '', $content);
    
    // Remove emojis in h1 tags (for student summary and report card)
    $content = preg_replace('/<h1>(👨‍🎓|📝) /us', '<h1>', $content);

    // Some logos were set to width=60, update header table padding slightly
    $content = str_replace('<td width="60"><img', '<td width="80"><img', $content);

    file_put_contents($file, $content);
    echo "Updated $file\n";
}
