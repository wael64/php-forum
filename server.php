<?php

function verifyOs($os)
{
  foreach ($_POST as $key => $value) {
    if ($key == $os) return;
  }
  return "disabled";
}

function verifyLanguage($string)
{
  $languages = $_POST["language"];
  foreach ($languages as $item) {
    if ($item === $string) {
      return true;
    }
  }
  return false;
}

// Connect to database
$conn = mysqli_connect('localhost', 'wael', 'toor', 'users');

// Get all users
$sqlFetch = "SELECT users.id, first_name, last_name, email, speciality, image_path, languages_id, os_id, created_at,php,java,c,c_plus, windows, linux, mac FROM users INNER JOIN languages ON users.languages_id = languages.id INNER JOIN os ON users.os_id = os.id;";

// Execute the language id query
$fetchResult = mysqli_query($conn, $sqlFetch);

// Store the result as associative array 
$fetchArr = mysqli_fetch_all($fetchResult, MYSQLI_ASSOC);


// check if this is a submition of a new user or a change of the user
if (isset($_POST["language"])) {

  // check if the username already exists. If so, redirect back to the form
  foreach ($fetchArr as $key => $value) {
    if ($value["first_name"] === $_POST["prenom"] && $value["last_name"] === $_POST["nom"]) {
      session_start();
      $_SESSION["full_name"] = "{$value['first_name']} {$value['last_name']}";
      header("Location: http://localhost/php-server/");
      exit();
    }
  }

  // Storing values for OS in variables
  $windows = verifyOs("windows") !== "disabled" ? 1 : 0;
  $linux = verifyOs("linux") !== "disabled" ? 1 : 0;
  $macos = verifyOs("macos") !== "disabled" ? 1 : 0;

  // Storing values for languages in variables
  $php = verifyLanguage("php") ? 1 : 0;
  $java = verifyLanguage("java") ? 1 : 0;
  $c = verifyLanguage("c") ? 1 : 0;
  $c_plus = verifyLanguage("c-plus") ? 1 : 0;

  // The query for the language table 
  $sqlLanguages = "INSERT INTO languages(php, java, c, c_plus) VALUES($php, $java, $c, $c_plus);";
  mysqli_query($conn, $sqlLanguages);

  // The query to get the id of the last row from language to link to foreign
  $sqlLanguagesForeign = "SELECT id FROM languages ORDER BY id DESC LIMIT 1;";
  mysqli_query($conn, $sqlLanguagesForeign);

  // Execute the language id query
  $languageResult = mysqli_query($conn, $sqlLanguagesForeign);
  // Store the result as associative array 
  $languageId = mysqli_fetch_all($languageResult, MYSQLI_ASSOC);

  // The query for the os table
  $sqlOs = "INSERT INTO os(windows, linux, mac) VALUES($windows, $linux, $macos);";
  mysqli_query($conn, $sqlOs);

  // The query to get the id of the last row from os to link to foreign
  $sqlOsForeign = "SELECT id FROM os ORDER BY id DESC LIMIT 1;";
  mysqli_query($conn, $sqlOsForeign);

  // Execute the language id query
  $osResult = mysqli_query($conn, $sqlOsForeign);
  // Store the result as associative array 
  $osId = mysqli_fetch_all($osResult, MYSQLI_ASSOC);


  // The query to insert data to the users table
  $sqlUsers = "INSERT INTO 
                users(first_name, last_name, email, speciality, image_path, languages_id, os_id) 
                VALUES 
                ('{$_POST["prenom"]}', '{$_POST["nom"]}', '{$_POST["email"]}', 
                '{$_POST["specialty"]}', 'media/{$_FILES["image"]["name"]}', 
                {$languageId[0]["id"]}, {$osId[0]["id"]});";
  // Execute the users query
  mysqli_query($conn, $sqlUsers);

  // add the new user to the all users array in the first position to display him as the selected option in the select input
  array_unshift($fetchArr, ["first_name" => $_POST["prenom"], "last_name" => $_POST["nom"], "email" => $_POST["email"], "speciality" => $_POST["specialty"], "image_path" => 'media/{$_FILES["image"]["name"]}', "language_id" => $languageId[0]["id"], "os_id" => $osId[0]["id"]]);
}
// Changed current user
else {
  // query for the selected user
  $selectedQuery = "SELECT users.id, first_name, last_name, email, speciality, image_path, languages_id, os_id, created_at,php,java,c,c_plus, windows, linux, mac FROM users INNER JOIN languages ON users.languages_id = languages.id INNER JOIN os ON users.os_id = os.id WHERE users.id={$_POST['changed_id']} ;";

  // execute the selected user query
  $selectedResult = mysqli_query($conn, $selectedQuery);

  // Store the selected user query in an array
  $selectedArr = mysqli_fetch_all($selectedResult, MYSQLI_ASSOC);


  // ======= 
  // replacing the global arrays values with the data from the selected user
  // =======

  $_POST["prenom"] = $selectedArr[0]["first_name"];
  $_POST["nom"] = $selectedArr[0]["last_name"];
  $_POST["email"] = $selectedArr[0]["email"];
  $_POST["specialty"] = $selectedArr[0]["speciality"];
  $_POST["id"] = $selectedArr[0]["id"];

  // Create an array the same as the one sent by php from the languages inputs, function return name of passed key if value equals 1
  function verifyInTable($key, $value)
  {
    if ($value == 1) {
      return $key;
    }
  }

  // if value of language equals 1 in the database, pass the language into the language array
  $languageArr = [verifyInTable("java", $selectedArr[0]["java"]), verifyInTable("c", $selectedArr[0]["c"]), verifyInTable("c-plus", $selectedArr[0]["c_plus"]), verifyInTable("php", $selectedArr[0]["php"])];
  $_POST["language"] = $languageArr;

  // if value of OS equals 1 in the database, pass the OS name into the $_POST object and give it the value 1 (value doesn't matter)
  (verifyInTable("windows", $selectedArr[0]["windows"]) === "windows") ? $_POST["wowinds"] = 1 : "";
  (verifyInTable("linux", $selectedArr[0]["linux"]) === "linux") ? $_POST["linux"] = 1 : "";
  (verifyInTable("mac", $selectedArr[0]["mac"]) === "mac") ? $_POST["macos"] = 1 : "";

  $_FILES["image"]["name"] = $selectedArr[0]["image_path"];
  $_FILES["image"]["tmp_name"] = "false";
}
// Echo any errors
echo mysqli_error($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <script src="fill.js" defer></script>
  <title>Document</title>
</head>

<body>
  <div class="card-container">
    <div class="card-image">
      <?php
      if ($_FILES["image"]["name"]) {
        if ($_FILES["image"]["tmp_name"] !== "false") {
          // upload the file 
          move_uploaded_file($_FILES["image"]["tmp_name"], "media/" . $_FILES["image"]["name"]);
          // output it into the website
          echo '<img src="media/' . $_FILES["image"]["name"] . '" alt="">';
        } else {
          echo '<img src="' . $_FILES["image"]["name"] . '" alt="">';
        }
      }
      ?>
    </div>
    <div class="card-info">
      <div class="card-name">
        <h2> <?php echo $_POST["prenom"] . " " . $_POST["nom"] ?> </h2>
        <h4>Développeur</h4>
      </div>
      <div class="card-languages">
        <h5 class="card-title">langages</h5>
        <div class="card-language <?php

                                  if (!verifyLanguage("java")) {
                                    echo "disabled";
                                  }  ?>
            java">
          <p>Java</p>
        </div>
        <div class="card-language <?php if (!verifyLanguage("c")) {
                                    echo "disabled";
                                  }  ?> c">
          <p>C</p>
        </div>
        <div class="card-language <?php if (!verifyLanguage("c-plus")) {
                                    echo "disabled";
                                  }  ?> c-plus">
          <p>C++</p>
        </div>
        <div class="card-language <?php if (!verifyLanguage("php")) {
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
                    echo verifyOs("windows");
                    ?> windows" src="media/Icons/windows.svg" alt="" />
        <img class=" <?php
                      echo verifyOs("macos")
                      ?> macos" src="media/Icons/macos.svg" alt="" />
        <img class="<?php
                    echo verifyOs("linux")
                    ?>  linux" src="media/Icons/linux.svg" alt="" />
      </div>
      <div class="card-contact">
        <h5 class="card-title">Contact</h5>
        <img src="media/Icons/email.svg" alt="" />
        <p class="card-text"><?php echo $_POST["email"] ?></p>
      </div>
    </div>
  </div>
  <div class="select_user">
    <form method="POST" id="change">
      <select name="changed_id" class="drop-down">
        <?php
        // if it's a user change, add the selected user as the first option and skip him when he pops up again. Else add all users normally as the first user in the table is the first displayed
        if (isset($_POST["changed_id"])) {
          echo "<option value='{$_POST['id']}' >{$_POST['prenom']} {$_POST['nom']}</option>";
          foreach ($fetchArr as $key => $value) {
            if ($value['id'] == $_POST['id']) continue;
            echo "<option value='{$value['id']}' >{$value['first_name']} {$value['last_name']}</option>";
          }
        } else {
          foreach ($fetchArr as $key => $value) {
            echo "<option value='{$value['id']}' >{$value['first_name']} {$value['last_name']}</option>";
          }
        }
        ?>
      </select>
      <button type="submit">Change</button>
    </form>
  </div>
</body>

</html>