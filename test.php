<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$a = App\Models\Assessment::create([
    'class_id' => 3,
    'teacher_id' => 2,
    'title' => 'Test',
    'type' => 'Quiz',
    'start_date' => '2026-06-30',
    'is_published' => true,
    'is_open' => false
]);

echo "is_active: " . ($a->is_active ? 'true' : 'false') . "\n";
echo "is_upcoming: " . ($a->is_upcoming ? 'true' : 'false') . "\n";
