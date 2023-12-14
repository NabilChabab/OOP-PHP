<?php

include "../controller/user_controller.php";



?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

   <title>PHP CRUD Application</title>

   <style>
      .card {
         width: 100%;
         border: none;
         background-color: transparent;
         display: flex;
         justify-content: center;
         align-items: center;
      }

      .card img {
         width: 200px;
         border-radius: 50%;
         object-fit: cover;
      }

      .card label {
         margin-top: 30px;
         text-align: center;
         height: 40px;
         cursor: pointer;
         font-weight: bold;
         margin-bottom: 20px;
      }

      .card input {
         display: none;
      }
   </style>
</head>

<body class="bg-dark text-light">
   <div class="container mt-5">
      <div class="text-center mb-4">
         <h3>Add New Student</h3>
         <p class="text-muted">Complete the form below to add a new student</p>
      </div>

      <?php

      if (isset($update)) {
         ?>
         <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>
               <?= $update ?>
            </strong> You should check in on some of those fields below.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
         <?php
      }

      ?>

      <div class="container d-flex justify-content-center" style="margin-top:5%;">
         <?php
         $one = null;
         if (isset($_GET['id'])) {
            $id = base64_decode($_GET['id']);
             $one = $user->getUserbyId($id);
         }
         if ($one) {
             while ($row = mysqli_fetch_assoc($one)) {
               ?>

               <form action="" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
                  <div class="card">
                     <img src="<?= $row['profile'] ?>" alt="image" id="image">
                     <label for="input-file">Choose Image</label>
                     <input type="file" accept="image/jpg , image/png , image/jpeg" id="input-file" name="image">
                  </div>
                  <div class="row mb-3">
                     <div class="col">
                        <label class="form-label">First Name:</label>
                        <input type="text" class="form-control" name="first_name" placeholder="firstname"
                           value="<?= $row['first_name'] ?>">
                     </div>

                     <div class="col">
                        <label class="form-label">Last Name:</label>
                        <input type="text" class="form-control" name="last_name" placeholder="lastname"
                           value="<?= $row['last_name'] ?>">
                     </div>
                  </div>

                  <div class="mb-3">
                     <label class="form-label">CIN:</label>
                     <input type="text" class="form-control" name="cin" placeholder="CIN" value="<?= $row['cin'] ?>">
                  </div>

                  <div class="mb-3">
                     <label class="form-label">Email:</label>
                     <input type="email" class="form-control" name="email" placeholder="name@example.com"
                        value="<?= $row['email'] ?>">
                  </div>

                  <div class="form-group mb-3">
                     <label>Gender:</label>
                     &nbsp;
                     <input type="radio" class="form-check-input" name="gender" id="male" value="male"
                        <?= $row['gender'] == 'male' ? "checked" : "" ?>>
                     <label for="male" class="form-input-label">Male</label>
                     &nbsp;
                     <input type="radio" class="form-check-input" name="gender" id="female" value="female"
                        <?= $row['gender'] == 'female' ? "checked" : "" ?>>
                     <label for="female" class="form-input-label">Female</label>
                  </div>

                  <div class="row ms-1 mt-4">
                     <button type="submit" class="btn btn-success col-3 me-3" name="submit">Save</button>
                     <a href="home.php" class="btn btn-danger col-3">Cancel</a>
                  </div>
               </form>

               <?php
            }
         }

         ?>

      </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"></script>
   <script>
      let image = document.getElementById("image");
      let input = document.getElementById("input-file");

      input.onchange = () => {
         image.src = URL.createObjectURL(input.files[0]);
      }
   </script>
</body>

</html>