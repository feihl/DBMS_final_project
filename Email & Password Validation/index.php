<?php
require 'config.php';

if(isset($_POST["submit"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $confirmpassword = $_POST["cpassword"];

  $duplicate = mysqli_query($conn, "SELECT * FROM user_account WHERE username = '$username' OR password = '$password'");

  if(mysqli_num_rows($duplicate) > 0) {
    echo "<script> alert('Username or Email Has Already Been Taken'); </script>";
  } else {
    if($password == $confirmpassword) {
      $access = 1; // Set the default value for the 'access' field
      $active = 1; // Set the default value for the 'active' field

      $query = "INSERT INTO user_account (username, password, access, active) VALUES ('$username', '$password', $access, $active)";
      mysqli_query($conn, $query);
      echo "<script> alert('Registration Successful'); </script>";
    } else {
      echo "<script> alert('Password Does Not Match'); </script>";
    }
  }
}
?>

<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com-->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Email and Password Validation</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css" />

    <!-- Boxicons CSS -->
    <link
      href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
      rel="stylesheet"
    />
  </head>
  <style>
        body {
          background-image: url('path/to/your/image.jpg');
          background-size: cover;
          background-position: center;
          /* Additional styling properties */
        }
      
    </style>
  <body>
    <div class="container">
      <header>Signup</header>
      <form action="#" method="POST">
        <div class="field email-field">
          <div class="input-field">
            <input type="text" name="username" placeholder="Enter your email" class="username" />                                                                                                                                                                                                            
          </div>
          <span class="error email-error">
            <i class="bx bx-error-circle error-icon"></i>
            <p class="error-text">Please enter a valid email</p>
          </span>
        </div>
        <div class="field create-password">
          <div class="input-field">
            <input type="password" name="password" placeholder="Create password" class="password" />
            <i class="bx bx-hide show-hide"></i>
          </div>
          <span class="error password-error">
            <i class="bx bx-error-circle error-icon"></i>
            <p class="error-text">
              Please enter at least 8 characters with a number, symbol, small and
              capital letter.
            </p>
          </span>
        </div>
        <div class="field confirm-password">
          <div class="input-field">
            <input type="password" name="cpassword" placeholder="Confirm password" class="password" />
            <i class="bx bx-hide show-hide"></i>
          </div>
          <span class="error cPassword-error">
            <i class="bx bx-error-circle error-icon"></i>
            <p class="error-text">Password doesn't match</p>
          </span>
        </div>
        <div class="input-field button">
          <input type="submit" name="submit" value="Submit Now" />
        </div>
      </form>
    </div>

    <!-- JavaScript -->
  </body>
</html>
<script>
  const form = document.querySelector("form");
const emailField = form.querySelector(".email-field");
const emailInput = emailField.querySelector(".username");
const passField = form.querySelector(".create-password");
const passInput = passField.querySelector(".password");
const cPassField = form.querySelector(".confirm-password");
const cPassInput = cPassField.querySelector(".password");

// Email Validation
function checkEmail() {
  const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
  if (!emailInput.value.match(emailPattern)) {
    emailField.classList.add("invalid");
  } else {
    emailField.classList.remove("invalid");
  }
}

// Hide and show password
const eyeIcons = document.querySelectorAll(".show-hide");

eyeIcons.forEach((eyeIcon) => {
  eyeIcon.addEventListener("click", () => {
    const pInput = eyeIcon.parentElement.querySelector("input");
    if (pInput.type === "password") {
      eyeIcon.classList.replace("bx-hide", "bx-show");
      pInput.type = "text";
    } else {
      eyeIcon.classList.replace("bx-show", "bx-hide");
      pInput.type = "password";
    }
  });
});

// Password Validation
function createPass() {
  const passPattern =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

  if (!passInput.value.match(passPattern)) {
    passField.classList.add("invalid");
  } else {
    passField.classList.remove("invalid");
  }
}

// Confirm Password Validation
function confirmPass() {
  if (passInput.value !== cPassInput.value || cPassInput.value === "") {
    cPassField.classList.add("invalid");
  } else {
    cPassField.classList.remove("invalid");
  }
}

// Calling Functions on Form Submit
form.addEventListener("submit", (e) => {
  e.preventDefault();

  checkEmail();
  createPass();
  confirmPass();

  emailInput.addEventListener("keyup", checkEmail);
  passInput.addEventListener("keyup", createPass);
  cPassInput.addEventListener("keyup", confirmPass);

  if (
    !emailField.classList.contains("invalid") &&
    !passField.classList.contains("invalid") &&
    !cPassField.classList.contains("invalid")
  ) {
    location.href = form.getAttribute("action");
  }
});

</script>