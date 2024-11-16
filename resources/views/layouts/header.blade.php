<style>
  .modal-dialog {
      display: flex;
      justify-content: center;
      align-items: center;
  }

  .modal-content {
      width: 80%;
      justify-content: center;
  }

  .modal-header {
      text-align: center;
      display: flex;
      justify-content: center;
      align-items: center;
  }

  .modal-header .profile-icon {
      margin-right: 10px;
  }

  .modal-footer {
      text-align: center;
  }

  .profile-info {
      margin-bottom: 20px;
  }

  .large-icon {
      font-size: 5em;
  }

  /* Mengubah warna navbar menjadi warna #EF5428 */
  .main-header.navbar {
      background-color: #EF5428; /* Warna orange-red */
      color: #ffffff; /* Teks putih untuk kontras */
  }

  .navbar-light .navbar-nav .nav-link {
      color: #ffffff; /* Teks pada link navbar berwarna putih */
  }

  .navbar-light .navbar-nav .nav-link:hover {
      color: #f8f9fa; /* Warna lebih cerah ketika di-hover */
  }

</style>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item">
        <a href="{{ url('logout') }}" class="nav-link" role="button">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>

     
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->