<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image">
      <span class="brand-text font-weight-light">Gestion de projets</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('index') }}" class="nav-link" data-path="/">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Produits</p>
              </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link" data-path="users">
              <i class="nav-icon fas fa-users"></i>
              <p>Utilisateurs</p>
              </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('commands.index') }}" class="nav-link" data-path="commands">
              <i class="nav-icon ion ion-android-cart"></i>
              <p>Commandes</p>
              </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>