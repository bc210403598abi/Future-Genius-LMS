<?php include_once('header.php'); ?>
<?php include_once('nav-front.php'); ?>
<div class="container mt-5">
    <div class="row">
        <figure class="text-center mb-5">
            <blockquote class="blockquote">
                <h1 class="display-6 fw-bold text-muted">Sign In</h1>
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
                        <div class="form-floating mb-3">
                            <select name="role" id="selectbox" class="form-select" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <label for="selectbox">Your Role</label>
                        </div>
                        <div class="mb-0">
                            <button type="submit" name="login-btn" class="btn btn-dark p-3 px-5">Login</button>
                        </div>
                    </form>
                    <?php 
                

                if(isset($_POST['login-btn'])){


                    $email    = $_POST['email'];
                    $password = $_POST['password'];
                    $role     = $_POST['role'];


                    $check_email_pass = $db->query("SELECT * FROM users WHERE email = '$email' AND password = '$password' AND role = '$role'");
                    $data = $check_email_pass->fetch_assoc();
                    if($check_email_pass->num_rows == 0){
                        echo "<div class='alert alert-danger mb-0 mt-3'>Invalid Email or Password</div>";
                    }elseif($check_email_pass->num_rows == 1){
                        
                        $_SESSION['id']   = $data['id'];
                        $_SESSION['role'] = $data['role'];
                        
                        if($role == 'admin'){
                            header('location: backend.php');
                        }else{
                            header('location: backend-user.php');
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