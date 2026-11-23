<?php require_once __DIR__ . '/functions.php'; ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>AssetFlow | IT Asset Management</title><link rel="stylesheet" href="assets/style.css"></head><body>
<header class="top"><a class="brand" href="index.php">AssetFlow</a><nav>
<a href="index.php">Dashboard</a><a href="assets.php">Assets</a><a href="employees.php">Employees</a><a href="maintenance.php">Maintenance</a>
</nav></header><main class="container">
<?php if ($msg = flash()): ?><div class="notice"><?= e($msg) ?></div><?php endif; ?>
