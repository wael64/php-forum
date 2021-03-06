<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <link href="media/Poppins/Poppins-Bold.ttf" rel="stylesheet" />
  <link href="media/Poppins/Poppins-Regular.ttf" rel="stylesheet" />
  <script src="validation.js" defer></script>
  <title>Form Validator</title>
</head>

<body class="forum">
  <?php
  // check if the user has been redirected from an attempt to add an existing username
  session_start();
  if (isset($_SESSION["full_name"])) {
    echo "<div class='user-found'><h1 >The user {$_SESSION['full_name']} already exists</h1></div>";
    session_destroy();
  }
  ?>
  <main class="container">
    <form action="server.php" method="post" enctype="multipart/form-data">
      <div class="list">
        <div class="item fullname">
          <div class="item">
            <label for="nom">Nom</label>
            <input id="nom" class="input nom" type="text" name="nom" />
            <div class="short hidden">
              <span class="message"><img src=" media/Icons/alert-circle-outline.svg" alt="warning" class="warning" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="error-text"><span>
                    Username has to be between 4 and 30 charcaters</span>
                </span>
            </div>
          </div>
          <div class="item">
            <label for="prenom">Prenom</label>
            <input id="prenom" class="input prenom" type="text" name="prenom" />
            <div class="short hidden">
              <span class="message"><img src=" media/Icons/alert-circle-outline.svg" alt="warning" class="warning" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="error-text"><span>
                    Username has to be between 4 and 30 charcaters</span>
                </span>
            </div>
          </div>

        </div>
        <div class="item">
          <label for="email">Email</label>
          <input id="email" class="input email" type="email" name="email" />
          <div class="short hidden">
            <span class="message"><img src=" media/Icons/alert-circle-outline.svg" alt="warning"
                class="warning" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="error-text">Email is invalid</span>
            </span>
          </div>
        </div>
      </div>
      <div class="item">
        <label for="sexe">Sexe</label>
        <div class="sexe">
          <div class="homme sexe-item">
            <label for="homme">Homme</label>
            <input type="radio" name="sexe" id="homme" value="homme" required />
          </div>
          <div class="femme sexe-item">
            <label for="femme">Femme</label>
            <input type="radio" name="sexe" id="femme" value="femme" required />
          </div>
        </div>
      </div>
      <div class="item">
        <label for="photo">Photo</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
        <input class="input-file" type="file" name="image" required />
      </div>
      <div class="item">
        <label for="specialty">Specialty</label><br>
        <select name="specialty" id="specialty">
          <option value="ti">TI</option>
          <option value="gl">GL</option>
          <option value="si">SI</option>
          <option value="sci">SCI</option>
        </select>
      </div>
      <div class="item language">
        <label for="language">Langages de programmation maitrises</label><br>
        <select name="language[]" id="language" multiple="multiple" required>
          <div>
            <option value="java">Java</option>
            <option value="c">C</option>
            <option value="c-plus">C++</option>
            <option value="php">PHP</option>
          </div>
        </select>
      </div>
      <div class="item checkbox">
        <label for="system">Systemes d'exploitation utilises</label>
        <div class="system">
          <label for="windows">Windows</label>
          <input name="windows" type="checkbox" id="windows" />
          <label for="linux">Linux</label>
          <input name="linux" type="checkbox" id="linux" />
          <label for="macos">MacOs</label>
          <input name="macos" type="checkbox" id="macos" />
        </div>
      </div>
      <div class="item button-container">
        <button type="submit">SUBMIT</button>
      </div>
      </div>
    </form>
  </main>
</body>

</html>