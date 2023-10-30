<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/connection/connect.php";

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
     <!-- custom css file link -->
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
    <link rel="stylesheet" href="csslog/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
.password-container {
        position: relative;
    }

.toggle-password-btn {
        position: absolute;
        right: -7px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
    }
.form-field input {
    width: 100%;
    display: block;
    border: none;
    outline: none;
    font-size: 1.2rem;
    color: #666;
    padding: 10px 15px 10px 10px;
    border-radius: 20px;
}

.form-field {
    display: flex;
    align-items: center;
    padding-left: 10px;
    margin-bottom: 20px;
    border-radius: 20px;
    background-color: #fff;
}

.form-field input {
    flex: 1;
    width: 100%;
    border: none;
    outline: none;
    background: none;
    font-size: 1.2rem;
    color: #666;
    padding: 10px 15px 10px 10px;
    margin-left:30px;
}

.input-icon {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon span {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.2rem;
    color: #555;
}

.toggle-password {
    cursor: pointer;
    transition: color 0.3s;
    margin-left: -30px; /* I-adjust ang margin para ilagay ang icon sa kanan ng password field */
}

.toggle-password.active {
    color: #555; /* Baguhin ang kulay ng mata icon kapag ito ay active (password visible) */
}
#emailError {
    color: red;
    display: none;
    margin-top: -20px;
}
.password-input-container {
    display: flex;
    flex-direction: column;
}

#password-validation-msg {
    margin-top: 5px;
}


/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
    

  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 20px;
  text-align: center;
  background-image: url("./img/opening.jpg");
  font-size: 16px;
    display: block;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 20px;
    text-align: center;
}



</style>
</head>

<body>
<div class="column">
        <div class="card">
<div class="form-container">
    <form method="post" class="mx-auto" method="post" action="process-reset-password.php"
          style="background-color: #FFFACD">
        <img src="img/ourlogo.png" alt="Logo" class="logo">
        <h6 class="text-center p-1">Medicine Management System for Barangay Malitam</h6>
        <h2 class="text-center p-1">Reset Password</h2>
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $_GET['error'] ?>
            </div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?= $_GET['success'] ?>
            </div>
        <?php } ?>

        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <div class="form-field d-flex align-items-center">
    <div class="input-icon">
        <span class="fas fa-key"></span>
        <div class="password-input-container">
            <input type="text" name="password" id="password" oninput="validatePassword(this.value)" autocomplete="off" required placeholder="Enter New Password" style="font-size: 15px; height: 50px; width: 255px;" />
            <button type="button" id="passwordToggle" class="toggle-password-btn" onclick="togglePasswordVisibility('password')">
            <i class="fas fa-eye-slash toggle-password"></i>
        </button>
        </div>
    </div>
</div>
<small id="passwordError" class="form-text text-danger"></small>


<div class="form-field d-flex align-items-center">
    <div class="input-icon">
        <span class="fas fa-key"></span>
        <div class="password-input-container">
            <input type="password" name="password_confirmation" id="password_confirmation" oninput="validatePasswordConfirmation(this.value)" autocomplete="off" required placeholder="Confirm Password" style="font-size: 15px; height: 50px; width: 255px;" />
            <small id="passwordConfirmationError" class="form-text text-danger" style="margin-top: 5px;"></small>
        </div>
        <button type="button" id="passwordConfirmationToggle" class="toggle-password-btn" onclick="togglePasswordVisibility('password_confirmation')">
            <i class="fas fa-eye-slash toggle-password"></i>
        </button>
    </div>
</div>


        <br>
        <button class="btn btn-primary mt-0">Send</button>
        <br>
    </form>
</div>
</body>

<script>
     function togglePasswordButton(buttonId) {
            var passwordInput = document.getElementById(buttonId.replace('Toggle', ''));
            var showPasswordBtn = document.getElementById(buttonId);

            if (passwordInput.value.length > 0) {
                showPasswordBtn.style.display = "block";
            } else {
                showPasswordBtn.style.display = "none";
            }
        }

        function togglePasswordVisibility(inputId) {
            var passwordInput = document.getElementById(inputId);
            var showPasswordBtn = document.getElementById(inputId + "Toggle");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                showPasswordBtn.innerHTML = '<i class="fas fa-eye"></i>';
            } else {
                passwordInput.type = "password";
                showPasswordBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
            }
        }
</script>

<script>
    function validatePassword(password) {
        var passwordField = document.getElementById("password");
        var passwordError = document.getElementById("passwordError");

        if (password.length > 24) {
            passwordField.classList.add("is-invalid");
            passwordError.textContent = "Password must be 24 characters or less.";
        } else if (/[^a-zA-Z0-9_]+/.test(password)) {
            passwordField.classList.add("is-invalid");
            passwordError.textContent = "Password can only contain letters, numbers, and underscores.";
        } else {
            passwordField.classList.remove("is-invalid");
            passwordError.textContent = "";
        }
    }
</script>
<script>
    // Function to enforce character limit
    function enforceCharacterLimit(inputElement, maxLength) {
        if (inputElement.value.length > maxLength) {
            inputElement.value = inputElement.value.slice(0, maxLength);
        }
    }

    // Add event listeners to the input fields
    document.getElementById("password").addEventListener("input", function () {
        enforceCharacterLimit(this, 24);
    });

    document.getElementById("password_confirmation").addEventListener("input", function () {
        enforceCharacterLimit(this, 24);
    });
</script>

</html>
