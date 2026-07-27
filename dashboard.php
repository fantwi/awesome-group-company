<?php
declare(strict_types=1);
require_once 'includes/config.php';
requireLogin();

$pdo = db();
$editRecord = null;
if (isset($_GET['edit'])) {
    $statement = $pdo->prepare('SELECT * FROM company_records WHERE id = ?');
    $statement->execute([(int) $_GET['edit']]);
    $editRecord = $statement->fetch() ?: null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $pdo->prepare('DELETE FROM company_records WHERE id = ?')->execute([(int) $_POST['id']]);
        flash('success', 'Record deleted successfully.');
    } else {
        $values = [
            trim($_POST['department'] ?? ''),
            trim($_POST['service_name'] ?? ''),
            trim($_POST['manager'] ?? ''),
            trim($_POST['email'] ?? ''),
            $_POST['status'] ?? 'Pending',
        ];
        if (in_array('', $values, true) || !filter_var($values[3], FILTER_VALIDATE_EMAIL)) {
            flash('error', 'Complete all fields and provide a valid email address.');
        } elseif ($action === 'update') {
            $values[] = (int) $_POST['id'];
            $pdo->prepare('UPDATE company_records SET department=?, service_name=?, manager=?, email=?, status=?, updated_at=CURRENT_TIMESTAMP WHERE id=?')->execute($values);
            flash('success', 'Record updated successfully.');
        } else {
            $pdo->prepare('INSERT INTO company_records (department, service_name, manager, email, status) VALUES (?, ?, ?, ?, ?)')->execute($values);
            flash('success', 'New record added successfully.');
        }
    }
    header('Location: dashboard.php');
    exit;
}

$search = trim($_GET['search'] ?? '');
if ($search !== '') {
    $statement = $pdo->prepare('SELECT * FROM company_records WHERE department LIKE ? OR service_name LIKE ? OR manager LIKE ? ORDER BY id DESC');
    $term = '%' . $search . '%';
    $statement->execute([$term, $term, $term]);
    $records = $statement->fetchAll();
} else {
    $records = $pdo->query('SELECT * FROM company_records ORDER BY id DESC')->fetchAll();
}
$pageTitle = 'Records Dashboard';
require 'includes/header.php';
?>
<section class="dashboard-hero">
    <div><span class="eyebrow">Company information system</span><h1>Good <?= (int) date('H') < 12 ? 'morning' : ((int) date('H') < 18 ? 'afternoon' : 'evening') ?>, <?= e(explode(' ', $_SESSION['user_name'])[0]) ?>.</h1><p>Add, retrieve, update, and delete company service records from one place.</p></div>
    <div class="dashboard-count"><strong><?= count($records) ?></strong><span>Visible records</span></div>
</section>
<section class="dashboard-layout">
    <aside class="record-form-panel">
        <span class="eyebrow"><?= $editRecord ? 'Update record' : 'Add record' ?></span>
        <h2><?= $editRecord ? 'Edit company data' : 'Create new record' ?></h2>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
            <input type="hidden" name="action" value="<?= $editRecord ? 'update' : 'add' ?>">
            <?php if ($editRecord): ?><input type="hidden" name="id" value="<?= (int) $editRecord['id'] ?>"><?php endif; ?>
            <label>Department<input name="department" required value="<?= e($editRecord['department'] ?? '') ?>" placeholder="e.g. Technology"></label>
            <label>Service name<input name="service_name" required value="<?= e($editRecord['service_name'] ?? '') ?>" placeholder="e.g. Web Development"></label>
            <label>Manager<input name="manager" required value="<?= e($editRecord['manager'] ?? '') ?>" placeholder="Full name"></label>
            <label>Contact email<input type="email" name="email" required value="<?= e($editRecord['email'] ?? '') ?>" placeholder="team@company.com"></label>
            <label>Status<select name="status"><?php foreach (['Active', 'Pending', 'Inactive'] as $status): ?><option <?= ($editRecord['status'] ?? '') === $status ? 'selected' : '' ?>><?= $status ?></option><?php endforeach; ?></select></label>
            <button class="button primary full" type="submit"><?= $editRecord ? 'Update record' : 'Add record' ?> →</button>
            <?php if ($editRecord): ?><a class="cancel-link" href="dashboard.php">Cancel editing</a><?php endif; ?>
        </form>
    </aside>
    <div class="records-panel">
        <div class="records-toolbar">
            <div><span class="eyebrow">Retrieve records</span><h2>Company services</h2></div>
            <form class="search-form" method="get"><input name="search" value="<?= e($search) ?>" placeholder="Search records..."><button type="submit">Retrieve record</button></form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Department</th><th>Service</th><th>Manager</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                <?php if (!$records): ?><tr><td colspan="6" class="empty-state">No matching records found.</td></tr><?php endif; ?>
                <?php foreach ($records as $record): ?>
                    <tr>
                        <td>#<?= str_pad((string) $record['id'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td><strong><?= e($record['department']) ?></strong></td>
                        <td><?= e($record['service_name']) ?><small><?= e($record['email']) ?></small></td>
                        <td><?= e($record['manager']) ?></td>
                        <td><span class="status <?= strtolower($record['status']) ?>"><?= e($record['status']) ?></span></td>
                        <td class="actions">
                            <a href="?edit=<?= (int) $record['id'] ?>" aria-label="Update record">Edit</a>
                            <form method="post" onsubmit="return confirm('Delete this record permanently?')">
                                <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int) $record['id'] ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php require 'includes/footer.php'; ?>

