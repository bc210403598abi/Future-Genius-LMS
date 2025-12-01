<?php include_once('header.php'); ?>
<?php include_once('nav-front.php'); ?>
<div class="container mt-5">
    <div class="row">
        <figure class="text-center mb-5 mt-5">
            <blockquote class="blockquote">
                <h1 class="display-6 fw-bold text-muted">Sign up</h1>
            </blockquote>
        </figure>
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <input type="text" class="form-control p-3" name="name" placeholder="Enter Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control p-3" name="email" placeholder="Enter Email"
                                required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control p-3" name="password" placeholder="Enter Password"
                                required>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control p-3" name="number" placeholder="Enter Contact No."
                                required>
                        </div>
                        <div class="mb-3">
                            <select class="form-select p-3" name="role" aria-label="Default select example">
                                <option selected>Select User</option>
                                <option value="students">Students</option>
                                <option value="teacher">Teacher</option>
                                <option value="other">Others Stack Holder</option>
                            </select>
                        </div>
                        <div class="mb-0">
                            <input type="submit" value="Click to Register" name="btn" class="btn btn-dark p-3">
                        </div>
                    </form>
                    <?php 
                
                    if(isset($_POST['btn'])){

                        $name     = $_POST['name'];
                        $email    = $_POST['email'];
                        $password =($_POST['password']); // Hash the password
                        $number   = $_POST['number'];
                        $role     = $_POST['role'];


                        // Check if email already exists
                        $check_email = mysqli_query($db, "SELECT * FROM users WHERE email = '$email' ");
                        if(mysqli_num_rows($check_email) > 0){
    
                            echo "<p class='alert alert-warning mt-3 p-3 mb-0'>Email already Taken.</p>";
    
                        } else {
                            // Insert the new user into the database
                            $insert = $db->query("INSERT INTO users (name, email, password, number, role) 
                                                  VALUES ('$name', '$email', '$password', '$number', '$role')");
    
                            if($insert){
                                echo "<p class='alert alert-success p-3 mt-3 mb-0'>Your Account has been Registered</p>";
                            } else {
                                echo "<p class='alert alert-danger p-3 mt-3 mb-0'>Error: " . $db->error . "</p>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>