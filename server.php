<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <script src="card.js" defer></script>
  <title>Document</title>
</head>

<body>
  <div class="card-container">
    <div class="card-image">
      <?php
      // upload the file 
      move_uploaded_file($_FILES["image"]["tmp_name"], "media/" . $_FILES["image"]["name"]);
      // output it into the website
      echo '<img src="media/' . $_FILES["image"]["name"] . '" alt="">'; ?>
    </div>
    <div class="card-info">
      <div class="card-name">
        <h2> <?php echo $_POST["nom"] . " " . $_POST["prenom"] ?> </h2>
        <h4>Développeur</h4>
      </div>
      <div class="card-languages">
        <h5 class="card-title">langages</h5>
        <div class="card-language <?php $languages = $_POST["language"];
                                  function verify($string)
                                  {
                                    global $languages;
                                    foreach ($languages as $item) {
                                      if ($item == $string) {
                                        return true;
                                      }
                                    }
                                    return false;
                                  }
                                  if (!verify("java")) {
                                    echo "disabled";
                                  }  ?>
            java">
          <p>Java</p>
        </div>
        <div class="card-language <?php if (!verify("c")) {
                                    echo "disabled";
                                  }  ?> c">
          <p>C</p>
        </div>
        <div class="card-language <?php if (!verify("c-plus")) {
                                    echo "disabled";
                                  }  ?> c-plus">
          <p>C++</p>
        </div>
        <div class="card-language <?php if (!verify("php")) {
                                    echo "disabled";
                                  } ?> php">
          <p>PHP</p>
        </div>
      </div>
      <div class="card-education">
        <h5 class="card-title">Éducation</h5>
        <p class="card-text">
          Licence en <span class="card-speciality"><?php
                                                    if ($_POST["specialty"] === "ti") echo "Technologie de l'information";
                                                    if ($_POST["specialty"] === "gl") echo "Génie logiciel";
                                                    if ($_POST["specialty"] === "si") echo "Systèmes d'information";
                                                    if ($_POST["specialty"] === "sci") echo "Sciences de l'informatique";
                                                    ?></span> de
          l’Université Constantine 2.
        </p>
      </div>
      <div class="card-os">
        <h5 class="card-title">OS Utilisés</h5>
        <img class="<?php
                    function verifyOs($os)
                    {
                      foreach ($_POST as $key => $value) {
                        if ($key == $os) return;
                      }
                      echo "disabled";
                    }
                    verifyOs("windows");
                    ?> windows" src="media/Icons/windows.svg" alt="" />
        <img class=" <?php
                      verifyOs("macos")
                      ?> macos" src="media/Icons/macos.svg" alt="" />
        <img class="<?php
                    verifyOs("linux")
                    ?>  linux" src="media/Icons/linux.svg" alt="" />
      </div>
      <div class="card-contact">
        <h5 class="card-title">Contact</h5>
        <img src="media/Icons/email.svg" alt="" />
        <p class="card-text"><?php echo $_POST["email"] ?></p>
      </div>
    </div>
  </div>
</body>

</html>