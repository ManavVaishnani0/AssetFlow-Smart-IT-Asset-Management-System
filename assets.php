<?php
require 'config/db.php'; require 'includes/functions.php';
verify_csrf();
$categories=['Laptop','Desktop','Monitor','Printer','Networking','Other'];
$statuses=['Available','Assigned','Under Maintenance','Retired'];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $action=post('action');
    if($action==='delete'){ $s=$pdo->prepare("DELETE FROM assets WHERE id=?"); $s->execute([(int)post('id')]); flash('Asset deleted.'); redirect('assets.php'); }
    if($action==='save'){
        $id=(int)post('id'); $tag=post('asset_tag'); $name=post('name'); $category=post('category'); $serial=post('serial_number');
        $purchase=post('purchase_date') ?: null; $cost=(float)post('purchase_cost', '0'); $warranty=post('warranty_expiry') ?: null;
        $status=post('status'); $assigned=post('assigned_to') !== '' ? (int)post('assigned_to') : null;
        if(!in_array($category,$categories,true)||!in_array($status,$statuses,true)||$tag===''||$name===''){ flash('Please enter valid required fields.'); redirect('assets.php'); }
        if($status!=='Assigned') $assigned=null;
        if($id){$q=$pdo->prepare("UPDATE assets SET asset_tag=?,name=?,category=?,serial_number=?,purchase_date=?,purchase_cost=?,warranty_expiry=?,status=?,assigned_to=? WHERE id=?");$q->execute([$tag,$name,$category,$serial,$purchase,$cost,$warranty,$status,$assigned,$id]);}
        else {$q=$pdo->prepare("INSERT INTO assets(asset_tag,name,category,serial_number,purchase_date,purchase_cost,warranty_expiry,status,assigned_to) VALUES(?,?,?,?,?,?,?,?,?)");$q->execute([$tag,$name,$category,$serial,$purchase,$cost,$warranty,$status,$assigned]);}
        flash('Asset saved successfully.'); redirect('assets.php');
    }
}
$employees=$pdo->query("SELECT id,name FROM employees WHERE active=1 ORDER BY name")->fetchAll();
$edit=null;if(isset($_GET['edit'])){$q=$pdo->prepare("SELECT * FROM assets WHERE id=?");$q->execute([(int)$_GET['edit']]);$edit=$q->fetch();}
$assets=$pdo->query("SELECT a.*,e.name employee_name FROM assets a LEFT JOIN employees e ON e.id=a.assigned_to ORDER BY a.id DESC")->fetchAll();
$pageTitle='Assets';require 'includes/header.php';
?>
<h1>Asset inventory</h1><section class="panel"><h2><?= $edit?'Edit asset':'Add an asset' ?></h2>
<form method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?=e($edit['id']??'')?>">
<div class="formgrid">
<label>Asset tag *<input required name="asset_tag" value="<?=e($edit['asset_tag']??'')?>"></label>
<label>Asset name *<input required name="name" value="<?=e($edit['name']??'')?>"></label>
<label>Category<select name="category"><?php foreach($categories as $v):?><option <?=($edit['category']??'Laptop')===$v?'selected':''?>><?=e($v)?></option><?php endforeach;?></select></label>
<label>Serial number<input name="serial_number" value="<?=e($edit['serial_number']??'')?>"></label>
<label>Purchase date<input type="date" name="purchase_date" value="<?=e($edit['purchase_date']??'')?>"></label>
<label>Purchase cost<input type="number" step="0.01" min="0" name="purchase_cost" value="<?=e($edit['purchase_cost']??'0')?>"></label>
<label>Warranty expiry<input type="date" name="warranty_expiry" value="<?=e($edit['warranty_expiry']??'')?>"></label>
<label>Status<select name="status"><?php foreach($statuses as $v):?><option <?=($edit['status']??'Available')===$v?'selected':''?>><?=e($v)?></option><?php endforeach;?></select></label>
<label>Assign employee<select name="assigned_to"><option value="">Unassigned</option><?php foreach($employees as $emp):?><option value="<?=$emp['id']?>" <?=($edit['assigned_to']??'')==$emp['id']?'selected':''?>><?=e($emp['name'])?></option><?php endforeach;?></select></label>
</div><button>Save asset</button> <?php if($edit):?><a href="assets.php">Cancel</a><?php endif;?></form></section>
<section class="panel"><h2>All assets</h2><div class="table-wrap"><table><tr><th>Tag</th><th>Name</th><th>Category</th><th>Status</th><th>Employee</th><th>Actions</th></tr>
<?php foreach($assets as $a):?><tr><td><?=e($a['asset_tag'])?></td><td><?=e($a['name'])?></td><td><?=e($a['category'])?></td><td><?=e($a['status'])?></td><td><?=e($a['employee_name']?:'—')?></td><td><a href="?edit=<?=$a['id']?>">Edit</a> <form class="inline" method="post" onsubmit="return confirm('Delete this asset?')"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=$a['id']?>"><button class="link danger">Delete</button></form></td></tr><?php endforeach;?>
</table>
<a href="export_assets.php"
   style="display: inline-block;
          background: #2459a6;
          color: white;
          padding: 8px 14px;
          text-decoration: none;
          border-radius: 5px;
          font-size: 14px;">
    Export CSV
</a>
</div></section><?php require 'includes/footer.php'; ?>
