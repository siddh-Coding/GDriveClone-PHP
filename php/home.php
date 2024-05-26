<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FileHub - Files</title>
  <link rel="stylesheet" href="../css/nevbar.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <style>

  </style>

</head>

<body>
  <div class="main">
    <div class="container">
      <!-- <div class="logo">
        <img src="" alt="FileHub Logo">
      </div> -->

      <form id="uploadForm" action="home.php?list=home" method="post" enctype='multipart/form-data'>
        <div class="labels">
          <input type="file" name="newfile" id="newfile" onchange="submitForm()">

          <label for="newfile">New File</label>
        </div>
      </form>

      <div class="menu">
        <ul>
          <li><a href="home.php?list=home" class="<?php echo ($_GET['list'] ?? '') == 'home' ? 'bg' : ''; ?>">Home</a>
          </li>
          <li><a href="home.php?list=myfiles" class="<?php echo ($_GET['list'] ?? '') == 'myfiles' ? 'bg' : ''; ?>">My
              Files</a></li>
          <li><a href="home.php?list=shared" class="<?php echo ($_GET['list'] ?? '') == 'shared' ? 'bg' : ''; ?>">Shared
              with
              Me</a></li>
          <li><a href="home.php?list=recent"
              class="<?php echo ($_GET['list'] ?? '') == 'recent' ? 'bg' : ''; ?>">Recent</a>
          </li>
        </ul>
      </div>




      <div class="storage">
        <hr>
        <p><?php include ('calcSize.php');
        echo round($total_size / 1000000, 2); ?> MB of 500 MB used</p>
        <div class="progress-bar">
          <div class="progress" style="width: <?php echo min($used_percentage, 100); ?>%;"></div>
        </div>
      </div>

    </div>
    <div class="files">
      <img src="../assets/nofiles.png" alt="">
      <p>No Files yet...</p>
    </div>
    <div class="showFiles">
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Date - Time</th>
            <th>Share</th>
            <th>Download</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php include ('showFiles.php') ?>
        </tbody>
      </table>
    </div>


    <div class="top-right">
      <?php include ('upload.php') ?>
    </div>

    <!-- <div class="file-preview" id="filePreview"></div> -->

  </div>

  <script src="../js/script.js"></script>

</body>

</html>