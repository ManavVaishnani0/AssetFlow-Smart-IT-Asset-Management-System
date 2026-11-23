<?php
require 'config/db.php';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=assets-export.csv');
$out=fopen('php://output','w');
fputcsv($out,['Asset Tag','Name','Category','Serial Number','Purchase Date','Purchase Cost','Warranty Expiry','Status']);
$q=$pdo->query("SELECT asset_tag,name,category,serial_number,purchase_date,purchase_cost,warranty_expiry,status FROM assets");
while($row=$q->fetch(PDO::FETCH_NUM)) fputcsv($out,$row);
fclose($out);
