<?php
session_start();
require 'connection.php';
$connect = Connect();

function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

$keyword = trim($_GET['search'] ?? '');

$stmt = $connect->prepare("SELECT * FROM tbl_employee_info 
                           WHERE emp_id LIKE :kw 
                              OR firstname LIKE :kw 
                              OR lastname LIKE :kw");
$stmt->execute([':kw' => "%$keyword%"]);
$rows = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Search Results</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-3">
  <h2>Search Results for "<?= h($keyword) ?>"</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th><th>Employee No.</th><th>First Name</th><th>Last Name</th><th>Age</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($rows): $i=1; foreach ($rows as $row): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= h($row->emp_id) ?></td>
          <td><?= h($row->firstname) ?></td>
          <td><?= h($row->lastname) ?></td>
          <td><?= h($row->age) ?></td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="5">No results found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
  <a href="employee.php" class="btn btn-secondary">Back</a>
</body>
</html>
