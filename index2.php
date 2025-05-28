<?php
session_start();
include("dbh.php");

<<<<<<< HEAD
    // Here you would typically check the credentials against a database
    // For demonstration purposes, we'll just check against hardcoded values
    if($email =="admin@gmail.com" && $sifra == "admin123") {
        // Redirect to the admin dashboard or home page
      header("Location: xampp\htdocs\FoodMartV2\admin.php");
    exit();
=======
// Admin podaci - dummy podaci za login admina
$adminEmail = "admin@admin.com";
$adminSifra = "admin123";

// Obrada LOGIN forme
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = trim($_POST["email"]);
    $sifra = trim($_POST["sifra"]);

    // Provjera za admina
    if ($email === $adminEmail && $sifra === $adminSifra) {
        $_SESSION["admin"] = $email;
        header("Location: admin/admin.php");
        exit();
>>>>>>> b750cd044d45e5a108d145d9b15e40269d857465
    } else {
        // Provjera za korisnika iz baze
        $stmt = $conn->prepare("SELECT ID, sifra, ime_korisnika FROM korisnici WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $korisnik = $result->fetch_assoc();

            if (password_verify($sifra, $korisnik["sifra"])) {
                $_SESSION["korisnik_id"] = $korisnik["ID"];
                $_SESSION["korisnik_ime"] = $korisnik["ime_korisnika"];
                header("Location: korisnik/index.php"); // promijeni ako želiš drugi redirect
                exit();
            } else {
                $error = "Pogrešan email ili šifra.";
            }
        } else {
            $error = "Pogrešan email ili šifra.";
        }

        header("Location: index2.php?error=" . urlencode($error));
        exit();
    }
}


// Obrada REGISTRACIJA forme
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    $ime = trim($_POST["ime"]);
    $email = trim($_POST["email"]);
    $sifra = trim($_POST["sifra"]); // ispravljeno

    // Provjera da li email postoji
    $provjera = $conn->prepare("SELECT ID FROM korisnici WHERE email = ?");
    $provjera->bind_param("s", $email);
    $provjera->execute();
    $provjera->store_result();

    if ($provjera->num_rows > 0) {
        $error = "Email je već registrovan.";
        header("Location: index2.php?error=" . urlencode($error));
        exit();
    }

    // Spremi korisnika s hashiranom šifrom
    $hashirana = password_hash($sifra, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO korisnici (ime_korisnika, email, sifra) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $ime, $email, $hashirana);

    if ($stmt->execute()) {
        header("Location: index2.php?success=" . urlencode("Registracija uspješna! Možete se prijaviti."));
        exit();
    } else {
        $error = "Greška prilikom registracije.";
        header("Location: index2.php?error=" . urlencode($error));
        exit();
    }
}
?>

<!DOCTYPE html>
<<<<<<< HEAD
<!-- Coding by CodingNepal | www.codingnepalweb.com-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Login and Registration Form in HTML & CSS | CodingLab </title>
    <link rel="stylesheet" href="style.css">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
   <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #e8f272;
  padding: 30px;
}
.container {
  position: relative;
  max-width: 850px;
  width: 100%;
  background: #fff;
  padding: 40px 30px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  perspective: 2700px;
}
.container .cover {
  position: absolute;
  top: 0;
  left: 50%;
  height: 100%;
  width: 50%;
  z-index: 98;
  transition: all 1s ease;
  transform-origin: left;
  transform-style: preserve-3d;
  backface-visibility: hidden;
}
.container #flip:checked ~ .cover {
  transform: rotateY(-180deg);
}
.container #flip:checked ~ .forms .login-form {
  pointer-events: none;
}
.container .cover .front,
.container .cover .back {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
}
.cover .back {
  transform: rotateY(180deg);
}
.container .cover img {
  position: absolute;
  height: 100%;
  width: 100%;
  object-fit: cover;
  z-index: 10;
}

.container .cover .text {
  position: absolute;
  z-index: 10;
  height: 100%;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.container .cover .text::before {
  content: '';
  position: absolute;
  height: 100%;
  width: 100%;
  opacity: 0.5;
  background: #b2b3ad;
}

.cover .text .text-1,
.cover .text .text-2 {
  z-index: 20;
  font-size: 26px;
  font-weight: 600;
  color: #fff;
  text-align: center;
}

.cover .text .text-2 {
  font-size: 15px;
  font-weight: 500;
}
.container .forms {
  height: 100%;
  width: 100%;
  background: #fff;
}

.container .form-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.form-content .login-form,
.form-content .signup-form {
  width: calc(100% / 2 - 25px);
}

.forms .form-content .title {
  position: relative;
  font-size: 24px;
  font-weight: 500;
  color: #333;
}

.forms .form-content .title:before {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  height: 3px;
  width: 25px;
  background: #b2b3ad;
}

.forms .signup-form .title:before {
  width: 20px;
}

.forms .form-content .input-boxes {
  margin-top: 30px;
}

.forms .form-content .input-box {
  display: flex;
  align-items: center;
  height: 50px;
  width: 100%;
  margin: 10px 0;
  position: relative;
}

.form-content .input-box input {
  height: 100%;
  width: 100%;
  outline: none;
  border: none;
  padding: 0 30px;
  font-size: 16px;
  font-weight: 500;
  border-bottom: 2px solid rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
}

.form-content .input-box input:focus,
.form-content .input-box input:valid {
  border-color: #b2b3ad;
}

.form-content .input-box i {
  position: absolute;
  color: #b2b3ad;
  font-size: 17px;
}

.forms .form-content .text {
  font-size: 14px;
  font-weight: 500;
  color: #333;
}

.forms .form-content .text a {
  text-decoration: none;
}

.forms .form-content .text a:hover {
  text-decoration: underline;
}

.forms .form-content .button {
  color: #fff;
  margin-top: 40px;
}

.forms .form-content .button input {
  color: #fff;
  background: #b2b3ad;
  border-radius: 6px;
  padding: 0;
  cursor: pointer;
  transition: all 0.4s ease;
}

.forms .form-content .button input:hover {
  background: #b2b3ad;
}

.forms .form-content label {
  color: #b2b3ad;
  cursor: pointer;
}

.forms .form-content label:hover {
  text-decoration: underline;
}

.forms .form-content .login-text,
.forms .form-content .sign-up-text {
  text-align: center;
  margin-top: 25px;
}

.container #flip {
  display: none;
}

@media (max-width: 730px) {
  .container .cover {
    display: none;
  }

  .form-content .login-form,
  .form-content .signup-form {
    width: 100%;
  }

  .form-content .signup-form {
    display: none;
  }

  .container #flip:checked ~ .forms .signup-form {
    display: block;
  }

  .container #flip:checked ~ .forms .login-form {
    display: none;
  }
}
    </style>




=======
<html lang="hr" dir="ltr">
<head>
  <meta charset="UTF-8" />
  <title>Login | Admin Panel</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }
    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #7d2ae8;
      padding: 30px;
    }
    .container {
      position: relative;
      max-width: 850px;
      width: 100%;
      background: #fff;
      padding: 40px 30px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      perspective: 2700px;
    }
    .container .cover {
      position: absolute;
      top: 0;
      left: 50%;
      height: 100%;
      width: 50%;
      z-index: 98;
      transition: all 1s ease;
      transform-origin: left;
      transform-style: preserve-3d;
      backface-visibility: hidden;
    }
    .container #flip:checked ~ .cover {
      transform: rotateY(-180deg);
    }
    .container #flip:checked ~ .forms .login-form {
      pointer-events: none;
    }
    .container .cover .front,
    .container .cover .back {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
    }
    .cover .back {
      transform: rotateY(180deg);
    }
    .container .cover img {
      position: absolute;
      height: 100%;
      width: 100%;
      object-fit: cover;
      z-index: 10;
    }
    .container .cover .text {
      position: absolute;
      z-index: 10;
      height: 100%;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .container .cover .text::before {
      content: "";
      position: absolute;
      height: 100%;
      width: 100%;
      opacity: 0.5;
      background: #7d2ae8;
    }
    .cover .text .text-1,
    .cover .text .text-2 {
      z-index: 20;
      font-size: 26px;
      font-weight: 600;
      color: #fff;
      text-align: center;
    }
    .cover .text .text-2 {
      font-size: 15px;
      font-weight: 500;
    }
    .container .forms {
      height: 100%;
      width: 100%;
      background: #fff;
    }
    .container .form-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .form-content .login-form,
    .form-content .signup-form {
      width: calc(100% / 2 - 25px);
    }
    .forms .form-content .title {
      position: relative;
      font-size: 24px;
      font-weight: 500;
      color: #333;
    }
    .forms .form-content .title:before {
      content: "";
      position: absolute;
      left: 0;
      bottom: 0;
      height: 3px;
      width: 25px;
      background: #7d2ae8;
    }
    .forms .signup-form .title:before {
      width: 20px;
    }
    .forms .form-content .input-boxes {
      margin-top: 30px;
    }
    .forms .form-content .input-box {
      display: flex;
      align-items: center;
      height: 50px;
      width: 100%;
      margin: 10px 0;
      position: relative;
    }
    .form-content .input-box input {
      height: 100%;
      width: 100%;
      outline: none;
      border: none;
      padding: 0 30px;
      font-size: 16px;
      font-weight: 500;
      border-bottom: 2px solid rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }
    .form-content .input-box input:focus,
    .form-content .input-box input:valid {
      border-color: #7d2ae8;
    }
    .form-content .input-box i {
      position: absolute;
      color: #7d2ae8;
      font-size: 17px;
    }
    .forms .form-content .text {
      font-size: 14px;
      font-weight: 500;
      color: #333;
    }
    .forms .form-content .text a {
      text-decoration: none;
    }
    .forms .form-content .text a:hover {
      text-decoration: underline;
    }
    .forms .form-content .button {
      color: #fff;
      margin-top: 40px;
    }
    .forms .form-content .button input {
      color: #fff;
      background: #7d2ae8;
      border-radius: 6px;
      padding: 0;
      cursor: pointer;
      transition: all 0.4s ease;
      height: 45px;
      width: 100%;
      font-size: 17px;
      font-weight: 600;
    }
    .forms .form-content .button input:hover {
      background: #5b13b9;
    }
    .forms .form-content label {
      color: #5b13b9;
      cursor: pointer;
    }
    .forms .form-content label:hover {
      text-decoration: underline;
    }
    .forms .form-content .login-text,
    .forms .form-content .sign-up-text {
      text-align: center;
      margin-top: 25px;
    }
    .container #flip {
      display: none;
    }
    @media (max-width: 730px) {
      .container .cover {
        display: none;
      }
      .form-content .login-form,
      .form-content .signup-form {
        width: 100%;
      }
      .form-content .signup-form {
        display: none;
      }
      .container #flip:checked ~ .forms .signup-form {
        display: block;
      }
      .container #flip:checked ~ .forms .login-form {
        display: none;
      }
    }
  </style>
</head>
>>>>>>> b750cd044d45e5a108d145d9b15e40269d857465
<body>
  <div class="container">
    <input type="checkbox" id="flip" />
    <div class="cover">
      <div class="front">
        <img src="images/pozadina_login.jpg" alt="" />
        <div class="text">
<<<<<<< HEAD

          <!-- aaaaaaaaaaaaaaaa -->
          <span class="text-1">Svaki novi kuhar/ica <br> znaci nova jela </span>
=======
          <span class="text-1">Svaki novi kuhar/ica <br /> znači nova jela</span>
>>>>>>> b750cd044d45e5a108d145d9b15e40269d857465
          <span class="text-2">Admin LOGIN</span>
          <!-- aaaaaaaaaaaaaaaaaaaaa -->

        </div>
      </div>
      <div class="back">
<<<<<<< HEAD

        <!--<img class="backImg" src="images/backImg.jpg" alt="">-->
        
=======
>>>>>>> b750cd044d45e5a108d145d9b15e40269d857465
        <div class="text">
          <span class="text-1">Complete miles of journey <br /> with one step</span>
          <span class="text-2">Let's get started</span>
        </div>
      </div>
    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title">Prijava</div>

          <?php if (isset($_GET["error"])): ?>
            <div style="color: red; margin: 10px 0;">
              <?php echo htmlspecialchars($_GET["error"]); ?>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET["success"])): ?>
            <div style="color: green; margin: 10px 0;">
              <?php echo htmlspecialchars($_GET["success"]); ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="">
            <div class="input-box">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Unesite email" required />
            </div>
            <div class="input-box">
              <i class="fas fa-lock"></i>
              <input
                type="password"
                name="sifra"
                placeholder="Unesite šifru"
                required
              />
            </div>
            <div class="button">
              <input type="submit" name="login" value="Prijavi se" />
            </div>
            <div class="text sign-up-text">
              Nemaš nalog? <label for="flip">Registruj se</label>
            </div>
          </form>
        </div>
        <div class="signup-form">
          <div class="title">Registracija</div>
          <form method="POST" action="">
            <div class="input-box">
              <i class="fas fa-user"></i>
              <input type="text" name="ime" placeholder="Unesite ime" required />
            </div>
            <div class="input-box">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Unesite email" required />
            </div>
            <div class="input-box">
              <i class="fas fa-lock"></i>
              <input
                type="password"
                name="sifra"
                placeholder="Unesite šifru"
                required
              />
            </div>
            <div class="button">
              <input type="submit" name="signup" value="Registruj se" />
            </div>
            <div class="text sign-up-text">
              Već imaš nalog? <label for="flip">Prijavi se</label>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<<<<<<< HEAD


























=======
>>>>>>> b750cd044d45e5a108d145d9b15e40269d857465
