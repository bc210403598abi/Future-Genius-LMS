<?php include_once('header.php'); ?>
<?php include_once('validation.php'); ?>

<?php
// Only students can access
if ($user_role == 'students') {
    include_once('nav-user.php'); 
} else {
    header('location: logout.php');
    exit;
}
?>

<div class="container mt-5">
    <div class="row">
        <figure class="text-center mb-5 mt-5">
            <blockquote class="blockquote">
                <h1 class="display-6 fw-bold text-muted">
                    <span class="text-dark"> Available Courses </span>
                </h1>
            </blockquote>
        </figure>

        <!-- Available Courses -->
        <div class="card mb-4">
            <div class="card-body">
                <h5>📚 All Courses</h5>

                <?php
                $query = $db->query("SELECT * FROM courses ORDER BY created_at DESC");

                if ($query->num_rows > 0) {
                    echo '<table class="table table-bordered table-striped mt-3">
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
                                </tr>
                            </thead>
                            <tbody>';
                    
                    $no = 1;
                    while ($row = $query->fetch_assoc()) {
                        $course_id = $row['id'];

                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['course_name']}</td>
                                <td>{$row['course_code']}</td>
                                <td>{$row['course_description']}</td>
                                <td>{$row['credits']}</td>
                                <td>{$row['duration']}</td>
                                <td>{$row['start_date']} to {$row['end_date']}</td>
                                <td>";

                        // Fetch materials
                        $mats = $db->query("SELECT * FROM course_materials WHERE course_id='$course_id'");
                        if ($mats->num_rows > 0) {
                            while ($m = $mats->fetch_assoc()) {
                                echo "<a href='{$m['file_path']}' target='_blank' class='d-block'>📂 {$m['file_name']}</a>";
                            }
                        } else {
                            echo "<span class='text-muted'>No Materials</span>";
                        }

                        echo "</td>
                              </tr>";
                        $no++;
                    }

                    echo '</tbody></table>';
                } else {
                    echo "<div class='alert alert-info mt-3'>No courses available right now.</div>";
                }
                ?>
            </div>
        </div>

    </div>
</div>

<?php include_once('footer.php'); ?>
