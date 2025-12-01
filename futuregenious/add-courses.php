<?php include_once('header.php'); ?> 
<?php include_once('validation.php'); ?> 

<?php 
// Only teachers can access
if ($user_role == 'teacher') {
    include_once('nav-teacher.php');  
} else {
    header('location: logout.php');
}
?>

<div class="container mt-5">
    <div class="row">
        <figure class="text-center mb-5 mt-5">
            <blockquote class="blockquote">
                <h1 class="display-6 fw-bold text-muted">
                    <span class="text-dark"> Manage Courses & Materials </span>
                </h1>
            </blockquote>
        </figure>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <?php 
                    // ✅ EDIT COURSE
                    if (isset($_GET['edit'])) {
                        $edit_id = $_GET['edit'];
                        $query = $db->query("SELECT * FROM courses WHERE id='$edit_id'");
                        $row = $query->fetch_assoc();

                        $course_name = $row['course_name'];
                        $course_code = $row['course_code'];
                        $course_description = $row['course_description'];
                        $credits = $row['credits'];
                        $duration = $row['duration'];
                        $start_date = $row['start_date'];
                        $end_date = $row['end_date'];
                    ?>
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input type="text" name="course_name" class="form-control" 
                                   value="<?php echo $course_name; ?>" required>
                            <label>Course Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="course_code" class="form-control" 
                                   value="<?php echo $course_code; ?>" required>
                            <label>Course Code</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="course_description" class="form-control" rows="4"><?php echo $course_description; ?></textarea>
                            <label>Course Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" name="credits" class="form-control" 
                                   value="<?php echo $credits; ?>">
                            <label>Credits</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="duration" class="form-control" 
                                   value="<?php echo $duration; ?>">
                            <label>Duration</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" name="start_date" class="form-control" 
                                   value="<?php echo $start_date; ?>">
                            <label>Start Date</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" name="end_date" class="form-control" 
                                   value="<?php echo $end_date; ?>">
                            <label>End Date</label>
                        </div>

                        <!-- Upload Material -->
                        <div class="mb-3">
                            <label class="form-label">Upload Course Material (PDF/DOC)</label>
                            <input type="file" name="material" class="form-control">
                        </div>

                        <div class="mb-0">
                            <input type="submit" value="Update Course" name="update_course" 
                                   class="btn btn-primary px-5 p-3">
                        </div>
                    </form>

                    <?php 
                        if (isset($_POST['update_course'])) {
                            $course_name = $_POST['course_name'];
                            $course_code = $_POST['course_code'];
                            $course_description = $_POST['course_description'];
                            $credits = $_POST['credits'];
                            $duration = $_POST['duration'];
                            $start_date = $_POST['start_date'];
                            $end_date = $_POST['end_date'];

                            $stmt = $db->prepare("UPDATE courses 
                                SET course_name=?, course_code=?, course_description=?, credits=?, duration=?, start_date=?, end_date=? 
                                WHERE id=?");
                            $stmt->bind_param("sssisssi", $course_name, $course_code, $course_description, $credits, $duration, $start_date, $end_date, $edit_id);

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mb-0 mt-3">✅ Course Updated Successfully</div>';

                                // File Upload
                                if (!empty($_FILES['material']['name'])) {
                                    $fileName = basename($_FILES["material"]["name"]);
                                    $targetDir = "uploads/";
                                    $targetFile = $targetDir . time() . "_" . $fileName;

                                    if (move_uploaded_file($_FILES["material"]["tmp_name"], $targetFile)) {
                                        $stmt2 = $db->prepare("INSERT INTO course_materials (course_id, file_name, file_path) VALUES (?, ?, ?)");
                                        $stmt2->bind_param("iss", $edit_id, $fileName, $targetFile);
                                        $stmt2->execute();
                                        $stmt2->close();
                                        echo "<div class='alert alert-info mt-2'>📂 Material uploaded successfully!</div>";
                                    }
                                }

                            } else {
                                echo '<div class="alert alert-danger mb-0 mt-3">❌ Failed to Update Course</div>';
                            }
                            $stmt->close();
                        }
                    } 
                    else { 
                    ?>
                    
                    <!-- ✅ ADD COURSE -->
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="course_name" required>
                            <label>Course Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="course_code" required>
                            <label>Course Code</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="course_description" rows="4"></textarea>
                            <label>Course Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="credits" value="3">
                            <label>Credits</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="duration">
                            <label>Duration</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" name="start_date">
                            <label>Start Date</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" name="end_date">
                            <label>End Date</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Course Material (PDF/DOC)</label>
                            <input type="file" name="material" class="form-control">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary px-5 p-3" name="submit">Add Course</button>
                        </div>
                    </form>

                    <?php 
                        if (isset($_POST['submit'])) {
                            $course_name = $_POST['course_name'];
                            $course_code = $_POST['course_code'];
                            $course_description = $_POST['course_description'];
                            $credits = $_POST['credits'];
                            $duration = $_POST['duration'];
                            $start_date = $_POST['start_date'];
                            $end_date = $_POST['end_date'];

                            $stmt = $db->prepare("INSERT INTO courses (teacher_id, course_name, course_code, course_description, credits, duration, start_date, end_date) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("isssisss", $user_id, $course_name, $course_code, $course_description, $credits, $duration, $start_date, $end_date);

                            if ($stmt->execute()) {
                                $new_course_id = $stmt->insert_id;
                                echo "<div class='alert alert-success'>✅ Course added successfully!</div>";

                                // File Upload
                                if (!empty($_FILES['material']['name'])) {
                                    $fileName = basename($_FILES["material"]["name"]);
                                    $targetDir = "uploads/";
                                    $targetFile = $targetDir . time() . "_" . $fileName;

                                    if (move_uploaded_file($_FILES["material"]["tmp_name"], $targetFile)) {
                                        $stmt2 = $db->prepare("INSERT INTO course_materials (course_id, file_name, file_path) VALUES (?, ?, ?)");
                                        $stmt2->bind_param("iss", $new_course_id, $fileName, $targetFile);
                                        $stmt2->execute();
                                        $stmt2->close();
                                        echo "<div class='alert alert-info mt-2'>📂 Material uploaded successfully!</div>";
                                    }
                                }

                            } else {
                                echo "<div class='alert alert-danger'>❌ Error: " . $stmt->error . "</div>";
                            }
                            $stmt->close();
                        }
                    } 
                    ?>
                </div>
            </div>
        </div>

        <!-- ✅ Show Courses and Materials -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <!-- Courses Table -->
                    <table class="table table-bordered table-striped mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Course Name</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Credits</th>
                                <th>Duration</th>
                                <th>Dates</th>
                                <th>Materials</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = $db->query("SELECT * FROM courses WHERE teacher_id='$user_id'");
                            if ($query->num_rows) {
                                $no = 1;
                                while ($row = $query->fetch_assoc()) {
                                    $course_id = $row['id'];
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $row['course_name']; ?></td>
                                <td><?php echo $row['course_code']; ?></td>
                                <td><?php echo $row['course_description']; ?></td>
                                <td><?php echo $row['credits']; ?></td>
                                <td><?php echo $row['duration']; ?></td>
                                <td><?php echo $row['start_date']." to ".$row['end_date']; ?></td>
                                <td>
                                    <?php 
                                    $mats = $db->query("SELECT * FROM course_materials WHERE course_id='$course_id'");
                                    if ($mats->num_rows) {
                                        while ($m = $mats->fetch_assoc()) {
                                            echo "<a href='{$m['file_path']}' target='_blank'>{$m['file_name']}</a><br>";
                                        }
                                    } else {
                                        echo "<span class='text-muted'>No Materials</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="add-courses.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="add-courses.php?remove=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this course?');">Delete</a>
                                </td>
                            </tr>
                            <?php 
                                }
                            } else {
                                echo "<tr><td colspan='9' class='text-center'>No courses found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <?php 
                    // ✅ DELETE COURSE
                    if (isset($_GET['remove'])) {
                        $remove_id = $_GET['remove'];
                        $db->query("DELETE FROM course_materials WHERE course_id='$remove_id'");
                        $db->query("DELETE FROM courses WHERE id='$remove_id'");
                        echo "<div class='alert alert-danger mt-3'>🗑️ Course deleted successfully!</div>";
                        echo "<meta http-equiv='refresh' content='1;url=add-courses.php'>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>
