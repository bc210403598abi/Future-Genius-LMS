<?php include_once('header.php'); ?>
<?php include_once('validation.php'); ?>
<?php 
if($user_role == 'admin'){
    include_once('nav-admin.php'); 
}elseif($user_role == 'seller'){
    include_once('nav-seller.php'); 
}elseif($user_role == 'user')
    include_once('nav-user.php'); 
else{
    header('location: logout.php');
}
?>
<div class="container">
    <div class="row">
        <figure class="text-center mb-5 mt-5">
            <blockquote class="blockquote mt-5">
                <h1 class="display-6 fw-bold text-muted">
                    <span class = "text-dark">EDIT INFORMATION</span>
                </h1>
            </blockquote>
        </figure>
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row d-flex align-items-center mb-3">                           
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="name" value="<?php echo $user_name; ?>" class="form-control"
                                id="floatingInputUsername" placeholder="Your Name" required>
                            <label for="floatingInputUsername">Your name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" value="<?php echo $user_email; ?>" class="form-control"
                                id="floatingInput" placeholder="name@example.com" required readonly>
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password" value="<?php echo $user_password; ?>"
                                class="form-control" id="floatingPassword" placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" name="number" value="<?php echo $user_number; ?>" class="form-control"
                                id="floatingnumber" placeholder="Number" required>
                            <label for="floatingnumber">Number</label>
                        </div>
                        <div class="mb-0">
                            <button type="submit" name="update-btn" class="btn btn-primary p-3 px-5">Update</button>
                        </div>
                    </form>
                    <?php 
                

                if(isset($_POST['update-btn'])){


                    $name     = $_POST['name'];
                    $email    = $_POST['email'];
                    $password = $_POST['password'];
                    $number   = $_POST['number'];


                    $check_email = $db->query("SELECT * FROM users WHERE email = '$email' AND id != '$user_id'");
                    if($check_email->num_rows > 0){
                        echo "<div class='alert alert-warning mb-0 mt-3'>Email already exists</div>";
                    }else{

                        $update_info = $db->query("UPDATE users SET name = '$name', email = '$email', password = '$password', number = '$number' WHERE id = '$user_id'");
                        if($update_info){
                            echo "<p class='alert alert-success p-3 mt-3 mb-0'>Your Account has been Update</p>";
                            header('location: backend.php');
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