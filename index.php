<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli('127.0.0.1', 'root', '', 'user_status');
if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}

// Handle deletion
if (isset($_POST['delete_id'])) {
    $delId = intval($_POST['delete_id']);
    $conn->query("DELETE FROM user_data WHERE id=$delId");
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Handle status toggle (AJAX)
if (isset($_POST['toggle_id'])) {
    $id = intval($_POST['toggle_id']);
    $row = $conn->query("SELECT status FROM user_data WHERE id=$id")->fetch_assoc();
    $newStatus = $row['status'] ? 0 : 1;
    $conn->query("UPDATE user_data SET status=$newStatus WHERE id=$id");
    echo json_encode(['new_status' => $newStatus]);
    exit;
}

// Handle form submission
if (isset($_POST['name'], $_POST['age'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $age = intval($_POST['age']);
    $conn->query("INSERT INTO user_data (full_name, user_age) VALUES ('$name', $age)");
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch all records
$result = $conn->query("SELECT * FROM user_data ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">User Form</h2>
    <form method="post" class="row g-3 mb-5">
        <div class="col"><input name="name" class="form-control" placeholder="Name" required></div>
        <div class="col"><input name="age" type="number" class="form-control" placeholder="Age" required></div>
        <div class="col-auto"><button type="submit" class="btn btn-primary">Submit</button></div>
    </form>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr data-id="<?= $row['id'] ?>">
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= $row['user_age'] ?></td>
                <td class="status"><?= $row['status'] ? 'Active' : 'Inactive' ?></td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary toggle">Toggle</button>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.toggle').forEach(button => {
        button.addEventListener('click', () => {
            const tr = button.closest('tr');
            const id = tr.dataset.id;
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'toggle_id=' + id
            })
            .then(res => res.json())
            .then(data => {
                tr.querySelector('.status').innerText = data.new_status ? 'Active' : 'Inactive';
            });
        });
    });
</script>
</body>
</html>
