<?php include_once('header.php'); ?>
<?php include_once('nav-front.php'); ?>
<div class="container mt-5">
    <div class="row">
        <figure class="text-center mb-5 mt-5">
            <blockquote class="blockquote">
                <h1 class="display-6 fw-bold text-muted"><span class="text-dark">Sign In </span></h1>
            </blockquote>
        </figure>
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="floatingInput"
                                placeholder="name@example.com" required>
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="floatingPassword"
                                placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="mb-0">
                            <button type="submit" name="login-btn" class="btn btn-primary p-3 px-5">Login</button>
                        </div>
                    </form>
                    <?php 
                    if(isset($_POST['login-btn'])){
                        $email    = $_POST['email'];
                        $password = $_POST['password'];

                        // Email & password match check
                        $check_email_pass = $db->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
                        
                        if($check_email_pass->num_rows == 0){
                            echo "<div class='alert alert-danger mb-0 mt-3'>❌ Invalid Email or Password</div>";
                        } else {
                            $data = $check_email_pass->fetch_assoc();

                            // Check status
                            if($data['ustatus'] !== 'approved'){
                                echo "<div class='alert alert-warning mb-0 mt-3'>⚠️ Your account is still pending approval. Please wait for admin approval.</div>";
                            } else {
                                // Session set karo
                                $_SESSION['id']   = $data['id'];
                                $_SESSION['role'] = $data['role'];

                                // Redirect based on role
                                if($data['role'] == 'admin'){
                                    header('location: backend.php');
                                }elseif($data['role'] == 'teacher') {
                                    header('location: backend-teacher.php');
                                }elseif($data['role'] == 'students') {
                                    header('location: backend-user.php');
                                }else {
                                    header('location: backend-others.php');
                                }
                                exit();
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
