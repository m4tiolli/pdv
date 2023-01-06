<?php header("Content-type: text/html; charset=utf-8");
if (isset($_POST['submit'])) {
  include('connectionfactory.php');
  mysqli_set_charset($connection, "utf8");

  $table = 'generaluser';
  $att = 'id, mainlevel, fullname, email, pass, state, city, street, numberstreet, postalcode';

  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $state = $_POST['state'];
  $city = $_POST['city'];
  $street = $_POST['street'];
  $numberstreet = $_POST['numberstreet'];
  $postalcode = $_POST['postalcode'];

  $insert = "INSERT INTO $table ($att) VALUES(default, 4, '$fullname', '$email', '$pass', '$state', '$city', '$street', '$numberstreet', '$postalcode')";

  if (mysqli_query($connection, $insert)) {
  } else {
    die('an error has occurred: ' . $connection);
    mysqli_close($connection);
    exit;
  }

  $select = "SELECT id FROM $table WHERE email = '$email' and pass = '$pass'";

  if (mysqli_query($connection, $select)) {
    $rs = mysqli_fetch_assoc(mysqli_query($connection, $select));
    $id = intval($rs['id']);
  } else {
    die('an error has occurred: ' . mysqli_error($connection));
    mysqli_close($connection);
    exit;
  }

  $insertatt = "INSERT INTO user_mainlevel(generaluser, mainlevel) VALUES($id, 4)";
  if (mysqli_query($connection, $insertatt)) {
    return;
  } else {
    die('an error has occurred: ' . $connection);
    mysqli_close($connection);
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up</title>
  <link rel="stylesheet" href="css/header.css" />
  <link rel="stylesheet" href="css/register.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <script src="https://kit.fontawesome.com/aec2c6e751.js" crossorigin="anonymous"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
</head>

<body>
  <nav class="navbar">
    <a href="" class="logo"><img src="img/logo-g.png" alt=""></a>
    <input type="checkbox" id="toggler" />
    <label for="toggler"><i class="fa-solid fa-bars"></i></label>
    <div class="menu">
      <ul class="list">
        <li><a href="">Home</a></li>
        <li><a href="">About</a></li>
        <li><a href="">Contact</a></li>
      </ul>
    </div>
  </nav>
  <div id="backnav"></div>
  <div class="container">
    <div id="background">
      <div class="section">
        <h1>Sign up now, it's easyer and simple!</h1>
        <form action="" method="post" autocomplete="off">
          <br />
          <div class="input-group">
            <input type="text" id="fullname" class="input" placeholder="Full Name" name="fullname" />
            <label for="fullname" class="input-label">Full Name</label>
          </div>
          <br />
          <div class="input-group">
            <input type="email" id="email" class="input" placeholder="Email" name="email" />
            <label for="email" class="input-label">Email</label>
          </div>
          <br />
          <div class="input-group">
            <input type="password" id="password" class="input" placeholder="Password" name="pass" />
            <label for="password" class="input-label">Password</label>
            <span class="fa-regular fa-eye" id="olho"></span>
            <span class="fa-regular fa-eye-slash" id="olho1"></span>
          </div>
          <br />
          <div class="button-group">
            <span class="next-button" onclick="nextstep()">next</span>
          </div>
          <div class="signup">
            <p>already have an account?</p>
            <a href="login.html">sign in</a>
          </div>
      </div>
      <div id="section-next">
        <h1>One more step...</h1>
        <br />
        <div class="input-group">
          <input type="text" id="postalcode" class="input" placeholder="Postal Code" name="postalcode" />
          <label for="postalcode" class="input-label">Postal Code</label>
        </div>

        <br />
        <div class="input-group">
          <input type="text" id="numberstreet" class="input" placeholder="Number" name="numberstreet" />
          <label for="numberstreet" class="input-label">Number</label>
        </div>
        <br />
        <div class="input-group">
          <input type="text" id="reference" class="input" placeholder="Reference" name="reference" />
          <label for="reference" class="input-label">Reference</label>
        </div>
        <br />
        <input style="display: none;" type="text" name="street" id="street"><input style="display: none;" type="text" name="city" id="city"><input style="display: none;" type="text" name="state" id="state">
        <div class="button-group">
          <input type="submit" class="next-button" value="finish" name="submit" />
        </div>

      </div>
    </div>
  </div>
  </form>
</body>
<script type="text/javascript">
  function nextstep() {
    var content = document.getElementById("section-next");
    var input1 = document.getElementById("fullname");
    var input2 = document.getElementById("email");
    var input3 = document.getElementById("password");
    if(input1.value == 0 || input2.value == 0 || input3.value == 0){
      alert("Please fill in all fields.")
    } else {
    content.style.display = "block";
    window.scrollTo(0, 1000);
    }
  }
</script>
<script>
  var senha = $("#password");
  var olho = $("#olho");
  var olho1 = $("olho1");

  $("#olho1").css("display", "none");

  olho.click(function() {
    senha.attr("type", "text");
    $("#olho").css("display", "none");
    $("#olho1").css("display", "block");
  });
  $("#olho1").click(function() {
    $("#password").attr("type", "password");
    $("#olho1").css("display", "none");
    $("#olho").css("display", "block");
  });
</script>
<script type="text/javascript">
  $("#postalcode").focusout(function() {
    $.ajax({
      url: "https://viacep.com.br/ws/" + $(this).val() + "/json/",
      dataType: "json",
      success: function(resposta) {
        $("#street").val(resposta.logradouro);
        $("#city").val(resposta.localidade);
        $("#state").val(resposta.uf);
      },
    });
  });
</script>

</html>