<?php
require 'config/db.php'; require 'includes/functions.php';
$pageTitle = 'Dashboard';
$counts = [];
foreach (['assets','employees','maintenance_records'] as $table) {
    $counts[$table] = (int)$pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
}
$warranty = (int)$pdo->query("SELECT COUNT(*) FROM assets WHERE warranty_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)")->fetchColumn();
$recent = $pdo->query("SELECT a.*, e.name AS employee_name FROM assets a LEFT JOIN employees e ON e.id=a.assigned_to ORDER BY a.id DESC LIMIT 6")->fetchAll();
$activity = $pdo->query("SELECT m.*, a.asset_tag FROM maintenance_records m JOIN assets a ON a.id=m.asset_id ORDER BY m.id DESC LIMIT 5")->fetchAll();
require 'includes/header.php';
?>
<h1>Dashboard</h1><p class="muted">A quick overview of your organization's IT equipment.</p>
<section class="stats">
<div class="stat"><span>Total assets</span><strong><?= $counts['assets'] ?></strong></div>
<div class="stat"><span>Employees</span><strong><?= $counts['employees'] ?></strong></div>
<div class="stat"><span>Maintenance records</span><strong><?= $counts['maintenance_records'] ?></strong></div>
<div class="stat"><span>Warranty expiring (30 days)</span><strong><?= $warranty ?></strong></div>
</section>
<div class="grid"><section class="panel"><h2>Recent assets</h2><div class="table-wrap"><table><tr><th>Tag</th><th>Name</th><th>Status</th><th>Assigned to</th></tr>
<?php foreach($recent as $a): ?><tr><td><?=e($a['asset_tag'])?></td><td><?=e($a['name'])?></td><td><?=e($a['status'])?></td><td><?=e($a['employee_name'] ?: '—')?></td></tr><?php endforeach; ?>
</table></div><a class="button" href="assets.php">Manage assets</a></section>
<section class="panel"><h2>Recent maintenance</h2><?php if(!$activity): ?><p class="muted">No maintenance activity yet.</p><?php endif; ?>
<?php foreach($activity as $m): ?><p><strong><?=e($m['asset_tag'])?></strong> · <?=e($m['description'])?><br><small><?=e($m['status'])?> · <?=e($m['created_at'])?></small></p><?php endforeach; ?>
<a class="button" href="maintenance.php">View maintenance</a></section></div>
<?php require 'includes/footer.php'; ?>
