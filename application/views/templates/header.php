<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CodeIgniter Posting Sample</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>

  <header class="p-3 mb-3 border-bottom  bg-dark  border-body" data-bs-theme="dark">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="<?= base_url() ?>" class="nav-link px-2 link-body-emphasis">Blog Posts</a></li>
       

          <?php if ($this->session->logged_in) { ?>

            <li><a href="add" class="nav-link px-2 link-body-emphasis">Add Posts</a></li>
            <li><a href="<?= base_url() ?>logout" class="nav-link px-2 link-body-emphasis">Logout</a></li>
            <li><a href="#" class="nav-link px-2 link-body-emphasis"><?= $this->session->fullname ; ?></a></li>
      <?php  } else {  ?>

        <li><a href="<?= base_url() ?>login" class="nav-link px-2 link-body-emphasis">Login</a></li>
    <?php      } ?> 

    </ul>

   <form action="<?= base_url();?>search" method="post" class="row g-3">
  <div class="col-auto">
    <label for="search" class="visually-hidden">Password</label>
    <input type="text" class="form-control" name="search" id="search" placeholder="search title here...">
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3">Search</button>
  </div>
  </form> 



      <!-- <div class="dropdown text-end ">
        <a href="#" class="d-block  link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small">
          <li><a class="dropdown-item" href="#">New project...</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
      </div> -->
      </div>
    </div>
  </header>
  <div class="container mt-5">