<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Login</title>
    <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
    <script>
        function validateInput() {
            const inputField = document.getElementById('userInput');
            const inputValue = inputField.value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phonePattern = /^\+?\d{10,15}$/;

            if (emailPattern.test(inputValue)) {
                inputField.setAttribute('name', 'email');
                return true; 
            } else if (phonePattern.test(inputValue)) {
                inputField.setAttribute('name', 'phone');
                return true;
            }
            return false; // Return false if input is invalid
        }

        // This function will be called to set the token before form submission
        function onSmartCaptchaSuccess(token) {
            const form = document.getElementById('loginForm');
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = 'smart-token'; // This should match the PHP variable used to capture the token
            tokenInput.value = token;
            form.appendChild(tokenInput);
        }
    </script>
</head>

<body>
    <?php include "inc/header.php"; ?>
    <?php include "./mysql_cli.php"; ?> 
    <?php include "./auth_class.php"; ?>
    <?php 
    $auth = new UserAuth($_POST);

    // Your SMARTCAPTCHA_SERVER_KEY
    define('SMARTCAPTCHA_SERVER_KEY', 'ysc2_BG9x7Tr5tDQEbQ3ZXPSCiHSDYkr0zFD6mk5Ib2x97fa06942');

    function check_captcha($token) {
        $ch = curl_init("https://smartcaptcha.yandexcloud.net/validate");
        $args = [
            "secret" => SMARTCAPTCHA_SERVER_KEY,
            "token" => $token
        ];
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_POST, true);    
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch); 
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode !== 200) {
            echo "Allow access due to an error: code=$httpcode; message=$server_output
";
            return true;
        }
     
        $resp = json_decode($server_output);
        return isset($resp->status) && $resp->status === "ok";
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $token = $_POST['smart-token']; // Safely access the token
        if (check_captcha($token)) {
            echo "Passed
";
            // Proceed with further authentication
        } else {
            echo "Robot
";
        }
    }
    ?>

    <div class="div_table">
        <h1 style="text-align: center">Login</h1>
        <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateInput();">
            <table>
                <tr>   
                    <td class="table_td_name"><label for="userInput">Email:</label></td>
                    <td><input type="text" id="userInput" required></td>
                </tr>
                <tr>
                    <td class="table_td_name"><label for="password">Password:</label></td>
                    <td><input type="password" name="password" id="password" required></td>
                </tr>         
                <tr>
                    <td>
                        <div
                            style="height: 100px"
                            id="captcha-container"
                            class="smart-captcha"
                            data-sitekey="ysc1_BG9x7Tr5tDQEbQ3ZXPSCw5OrNAez5ehnwVK89I7Fcea15308"
                            data-callback="onSmartCaptchaSuccess"
                        ></div>
                    </td>
                </tr>
                <tr>
                    <td><button type="submit">Login</button></td>
                    <td><a href="reg.php">Registration</a></td>
                </tr>
            </table>   
        </form>
        <div>
            <?php
                echo $auth->enterErrors();
            ?>
        </div>
    </div>
</body>
</html>

