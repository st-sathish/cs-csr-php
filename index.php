<?php
include "db/db_conn.php";
$msg="";
$msg_color = "";
if (isset($_POST['login'])) {
    $user = $_POST['email'];
    $pass = md5($_POST['password']);
    $role='admin';
    $sql = "SELECT * FROM csr_user WHERE (username='$user') AND password='$pass'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    $row=mysqli_fetch_assoc($result);
    if ($count > 0) {
        session_start();
        $_SESSION["user_id"] = $row['u_id'];
        $_SESSION["username"] = $row['username'];
        $_SESSION["name"] = $row['first_name']." ".$row['last_name'];
        $_SESSION["role"] = $role;
        header("location:views/dashboard.php");
        exit;
    } else {
        $msg = '<div class="alert alert-danger" id="dangerMessage">Username and Password Missmatch!</div>';
        $msg_color = "red";
    }
}
?>
<!DOCTYPE HTML>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo TITLE;?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, uMotorola web design" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href='//fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Work+Sans:400,500,600' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="login-page">
    <div class="login-main">
        <!-- <div class="login-head">
            <h1><?php echo TITLE;?></h1>
        </div> -->
        <div class="login-block">
            <form class="login-form widget" method="post" id="userlogin" autocomplete="off">
                <div class="w-section">
                    <div class="form-group">
                        <span style="text-transform: capitalize;color:<?php echo $msg_color; ?>"><?php echo $msg; ?></span><br>
                        <input  type="text" name="email" placeholder="User Name" autocomplete="on" required="">
                    </div>
                    <div class="form-group">
                        <input  type="password" name="password" class="lock" placeholder="Password" autocomplete="off" required="">
                    </div>

                    <input type="submit" name="login" value="Login">
            </form>

        </div>
    </div>
</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"> </script>
<?php include "views/shared/footer.php";?>
<script>
    setTimeout(function() {
        $('#dangerMessage').fadeOut('fast');
    }, 3000);
</script>
</body>
</html>