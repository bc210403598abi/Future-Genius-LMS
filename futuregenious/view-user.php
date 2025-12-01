<?php include_once('header.php'); ?>
<?php include_once('validation.php'); ?>
<?php
// Load the appropriate navigation bar based on user role
if ($user_role == 'admin') {
    include_once('nav-admin.php'); 
}else {
    header('location: logout.php');
}
?>

<div class="container mt-5">
    <div class="row">
        <figure class="text-center mb-5 mt-5">
            <blockquote class="blockquote">
                <h1 class="display-6 fw-bold text-muted">
                    <span class="text-dark"> Manage User </span>
                </h1>
            </blockquote>
        </figure>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <?php 
                        if (isset($_GET['edit'])) {
                            $edit_id = $_GET['edit'];
                            $query = $db->query("SELECT * FROM users WHERE id = '$edit_id'");
                            $row = $query->fetch_assoc();
                            $item_id = $row['id'];
                            $name = $row['name'];
                            $email = $row['email'];
                            $number = $row['number'];
                            $ustatus = $row['ustatus'];
                    ?>
                    <form action="" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control" id="item-name"
                                value="<?php echo $name; ?>">
                            <label for="item-name">User Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="email" class="form-control" id="item-description"
                                rows="4"><?php echo $email; ?></textarea>
                            <label for="item-description">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" name="number" class="form-control" id="item-price"
                                value="<?php echo $number; ?>">
                            <label for="item-price">Number</label>
                        </div>
                        <div class="mb-0">
                            <input type="submit" value="Update User" name="update_item"
                                class="btn btn-primary px-5 p-3">
                        </div>
                    </form>
                    <?php 
                        if (isset($_POST['update_item'])) {
                            $name    = $_POST['name'];
                            $email   = $_POST['email'];
                            $number  = $_POST['number'];
                            $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, number = ? WHERE id = ?");
                            $stmt->bind_param("ssii", $name, $email, $number, $edit_id);

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mb-0 mt-3">✅ User Updated Successfully</div>';
                            } else {
                                echo '<div class="alert alert-danger mb-0 mt-3">❌ Failed to Update User</div>';
                            }
                            $stmt->close();
                        }
                    } ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?php 
                    if (isset($_GET['remove'])) {
                        $remove_id = $_GET['remove'];
                        $sql = $db->query("DELETE FROM users WHERE id = '$remove_id'");

                        if ($sql) {
                            header('location: view-user.php');
                        } else {
                            echo "<div class='alert alert-danger'>Failed to delete user</div>";
                        }
                    }
                    ?>

                    <table class="table table-bordered table-striped mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Number</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = $db->query("SELECT * FROM users WHERE role='students' OR role='teacher' OR role='other'");
                            if ($query->num_rows) {
                                $no = 1;
                                while ($row = $query->fetch_assoc()) {
                                    $item_id = $row['id'];
                                    $item_name = $row['name'];
                                    $email = $row['email'];
                                    $number = $row['number'];
                                    $ustatus = $row['ustatus'];
                                    ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $item_name; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $number; ?></td>
                                <td>
                                    <?php if($ustatus == 'pending'){ ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php } elseif($ustatus == 'rejected'){ ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php } else { ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="view-user.php?edit=<?php echo $item_id; ?>"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <a href="view-user.php?remove=<?php echo $item_id; ?>"
                                        class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                ?>
                            <tr>
                                <td colspan="6" class="text-center">No users found</td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>
