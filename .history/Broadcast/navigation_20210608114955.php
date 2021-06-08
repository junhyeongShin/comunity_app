<?php
session_start();
include 'config.php';

?>


  <!-- Navigation -->
  <nav id="navigation">
  <nav  class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" style="padding: 20px;">
    <div class="container">
      <a class="navbar-brand" href="<?php echo $SERVER_ADDRESS; ?>">Us</a>
      </button>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <?php
            isset($_SESSION['userid'])
            if(isset($_SESSION['userid'])){
              ?>
              <a class="nav-link" href="<?php echo $SERVER_ADDRESS; ?>logout.php">로그아웃</a>
            <?php
            }else{
              ?>
              <a class="nav-link" href="<?php echo $SERVER_ADDRESS; ?>login.php">로그인</a>
            <?php
            }
            ?>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">방송하기</a>
          </li>
        </ul>
      </div>
      
      
    </div>
    
  </nav>