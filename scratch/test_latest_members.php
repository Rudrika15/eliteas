<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Member;

$members = Member::with(['circle', 'user'])
    ->where('status', 'Active')
    ->whereHas('user', function ($q) {
        $q->where('status', 'Active');
    })
    ->orderBy('created_at', 'desc')
    ->take(4)
    ->get();

echo "=== Latest 4 Active Members ===\n";
foreach ($members as $m) {
    $cName = $m->circle ? $m->circle->circleName : 'Digital Member';
    echo "ID: {$m->id} | Name: " . optional($m->user)->firstName . " " . optional($m->user)->lastName . " | Type: {$m->membershipType} | Circle: {$cName} | Created: {$m->created_at}\n";
}
