<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$settings = \App\Models\TeacherAttendanceSetting::all();
foreach($settings as $s) {
    echo "Setting " . $s->id . " days: ";
    print_r($s->days);
    echo " is_active: " . $s->is_active . "\n";
}
