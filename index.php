<!doctype html>
<html lang="en">
  <head>
    <title>Micro Blog CRUD</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style>
    body{
      background-color: lightblue;
    }

    .containerA{
      color: lightblue;
      border: 3px solid gray;
      margin-bottom: 10px;
      background-color: rgb(0,0,200);
    }

    .containerA h1, h4{
      text-align: center;
      color: white;
    }
  </style>

  </head>
  <body>

  <div class="container text-center">
    <h1>POST YOUR ARTICLE AREA</h1>
    <p>Just Enter your article inside thoses boxes.</p>
    <div class="row justify-content-center">
      <form action="" method="POST">
        <input type="text" placeholder="TITLE" name="title" class="mb-2" required/><br>
        <input type="text" placeholder="AUTHOR" name="author" class="mb-2" required><br>
        <textarea id="article" name="article" cols="60" rows="20" class="mb-2" required>ENTER THE FULL ARTICLE HERE</textarea><br>
        <button class="btn-outline-warning btn-lg mb-3" type="submit" name="btnSubmit">Submit</button>
      </form>
    </div>
    <a href="index.php?refresh">REFRESH PAGE</a>
  </div>

  <?php

  $con = mysqli_connect("localhost", "root", "root", "test");

  //Inserting a new post
  if(isset($_POST['btnSubmit'])){

    $getTitle = mysqli_real_escape_string($con, $_POST['title']);
    $getAuthor = mysqli_real_escape_string($con, $_POST['author']);
    $getArticle = mysqli_real_escape_string($con, $_POST['article']);

    $insertPost = "INSERT INTO post(title, author, article) VALUES('$getTitle', '$getAuthor', '$getArticle')";
    $queryInsert = mysqli_query($con, $insertPost);

    if($queryInsert){
      header("Location: http://localhost/CRUD/POST/index.php");
      exit();
    }
  }

  //DELETE A POST
  if(isset($_POST['btnDelete'])){
    
    $getID = $_POST['btnDelete'];

    $deleteID = "DELETE FROM post WHERE id='$getID'";
    $queryDeleteID = mysqli_query($con, $deleteID);

    if($queryDeleteID){
      header("Location: index.php");
      exit();
    } 
  }

  //EDIT A POST
  if(isset($_POST['btnEdit'])){
    $editID = $_POST['btnEdit'];

    $selectEdit = "SELECT * FROM post WHERE id='$editID'";
    $querySelect = mysqli_query($con, $selectEdit);

    $rowEdit = mysqli_fetch_array($querySelect);
    $idid = $rowEdit['id'];
    $title = $rowEdit['title'];
    $author = $rowEdit['author'];
    $article = $rowEdit['article'];

    echo "
    
    <form method='POST' action=''>
      <input type='text' value='$title' name='newTitle'/>
      <input type='text' value='$author' name='newAuthor'/>
      <textarea value='' name='newArticle' cols='60' rows='20'>$article</textarea>
      <input value='Submit Edit' type='submit' name='btnSubEdit'/>
    </form>

    ";
  }

  if(isset($_POST['btnSubEdit'])){

    $newID = $idid;
    if(isset($idid)){
      echo "<br> id: $idid<br>";
    } else{
      echo "<br>is not set!<br>";
    }

    $newTitle = mysqli_real_escape_string($con, $_POST['newTitle']);
    $newAuthor = mysqli_real_escape_string($con, $_POST['newAuthor']);
    $newArticle = mysqli_real_escape_string($con, $_POST['newArticle']);

    $update = "UPDATE post SET title='$newTitle', author='$newAuthor', article='$newArticle' WHERE id='$newID'";
    $queryUpdate = mysqli_query($con, $update);

    if($queryUpdate){
      header("Location: index.php");
      exit();
    }
  }

  //SHOWING THE DATA BLOG STYLE

  $selectAll = "SELECT * FROM post ORDER BY date DESC";
  $querySelectAll = mysqli_query($con, $selectAll);

  while($row = mysqli_fetch_array($querySelectAll)){
    $tableID = $row['id'];
    $tableTitle = $row['title'];
    $tableAuthor = $row['author'];
    $tableArticle = $row['article'];
    $tableDate = $row['date'];

    echo "
      <div class='container containerA'>
        <form method='POST' action=''>
        <h1>$tableTitle</h1>
        <h4>$tableAuthor</h4>
        <p>$tableArticle</p>
        <p>$tableDate</p>
        <button class='btn btn-outline-dark mr-3' name='btnEdit' value='$tableID' type='submit'>EDIT</button>
        <button class='btn btn-outline-danger' name='btnDelete' value='$tableID' type='submit'>DELETE</button>
        </form>
      </div>
    
    ";
  }

  ?>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>