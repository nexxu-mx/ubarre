
<header class="header header-desktop" data-header>
<div class="container">

  <a href="index.php" class="logo">
    <img src="./assets/images/svg/logo-negro.svg" width="136" height="46"
      alt>
  </a>
  <nav class="navbar">

      <div class="navbar-top">

        <a href="index.php" class="logo">
          <img src="./assets/images/svg/logo-negro.svg" width="136"
            height="46" alt>
        </a>

        <button class="nav-close-btn" aria-label="clsoe menu"
          data-nav-toggler>
          <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
        </button>

      </div>

      <ul class="navbar-list">

        <li class="navbar-item">
          <a href="aboutus.php" class="navbar-link title-md">ABOUT US</a>
        </li>

        <li class="navbar-item">
          <a href="clases.php" class="navbar-link title-md">CLASES</a>
        </li>

        <li class="navbar-item">
          <a href="reserva.php" class="navbar-link title-md">RESERVA</a>
        </li>

        <li class="navbar-item">
          <a href="paquetes.php" class="navbar-link title-md">PAQUETES</a>
        </li>

        <li class="navbar-item">
          <a href="coaches.php" class="navbar-link title-md">COACHES</a>
        </li>

        <li class="navbar-item">
          <a href="contacto.php" class="navbar-link title-md">CONTACTO</a>
        </li>

      </ul>

      <ul class="social-list">

        <li>
          <a href="#" class="social-link">
            <ion-icon name="logo-twitter"></ion-icon>
          </a>
        </li>

        <li>
          <a href="#" class="social-link">
            <ion-icon name="logo-facebook"></ion-icon>
          </a>
        </li>

        <li>
          <a href="#" class="social-link">
            <ion-icon name="logo-pinterest"></ion-icon>
          </a>
        </li>

        <li>
          <a href="#" class="social-link">
            <ion-icon name="logo-instagram"></ion-icon>
          </a>
        </li>

        <li>
          <a href="#" class="social-link">
            <ion-icon name="logo-youtube"></ion-icon>
          </a>
        </li>

      </ul>

      </nav>
  

  <div class="container-profile-menu">
    <?php
    
    session_start();
    if (empty($_SESSION['idUser']) || empty($_SESSION['nombre'])) {
        
        echo '<div class="login-bolsa-navbar">
            <a href="login.php" style="display: flex;align-items: baseline;gap: 3px;">
              <img src="assets/images/svg/login.svg" alt="login icon">
            
            </a>
          </div>';
        
    }else{
      echo '<div class="login-bolsa-navbar">
            <a href="profile.php" style="display: flex;align-items: baseline;gap: 3px;font-weight: 400;">
              <img src="assets/images/svg/login.svg" alt="login icon">
              <p id="profile-name">' . $_SESSION['nombre'] . '</p>
            </a>
          </div>';
    }
    
 
    
    ?>

    <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
      <ion-icon name="menu-outline"></ion-icon>
    </button>
  </div>


 
</div>
</header>

  

<div class="header-mobile" id="header-mobile">
<a href="index.php" class="hmobile"><ion-icon name="home" aria-hidden="true"></ion-icon></a>
<a href="reserva.php" class="hmobile"><ion-icon name="calendar-number-outline" aria-hidden="true"></ion-icon></a>
<a href="login.php" class="hmobile">
    <img src="assets/images/svg/login.svg" style="width: 27px;" alt="login icon">
</a>
<button class="nav-open-btn mobile-log" aria-label="open menu" data-nav-toggler="">
    <ion-icon name="menu-outline" style="color: #2e2e2e;"></ion-icon>
</button>

</div>
<nav class="navbar navbar-mob" data-navbar>

      <div class="navbar-top">

        <a href="index.php" class="logo">
          <img src="./assets/images/svg/logo-negro.svg" width="136"
            height="46" alt>
        </a>

        <button class="nav-close-btn" aria-label="clsoe menu"
          data-nav-toggler>
          <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
        </button>

      </div>

      <ul class="navbar-list">

        <li class="navbar-item">
          <a href="aboutus.php" class="navbar-link title-md">ABOUT US</a>
        </li>

        <li class="navbar-item">
          <a href="clases.php" class="navbar-link title-md">CLASES</a>
        </li>

        <li class="navbar-item">
          <a href="reserva.php" class="navbar-link title-md">RESERVA</a>
        </li>

        <li class="navbar-item">
          <a href="paquetes.php" class="navbar-link title-md">PAQUETES</a>
        </li>

        <li class="navbar-item">
          <a href="coaches.php" class="navbar-link title-md">COACHES</a>
        </li>

        <li class="navbar-item">
          <a href="contacto.php" class="navbar-link title-md">CONTACTO</a>
        </li>

      </ul>

      <ul class="social-list">


        <li>
          <a href="#" class="social-link">
            <ion-icon name="logo-facebook"></ion-icon>
          </a>
        </li>

        

        <li>
          <a href="#" class="social-link">
            <ion-icon name="logo-instagram"></ion-icon>
          </a>
        </li>


      </ul>

      </nav>
      <div class="overlay" data-nav-toggler data-overlay></div>