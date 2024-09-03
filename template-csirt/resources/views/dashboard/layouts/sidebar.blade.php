<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="/dashboard">
            <span data-feather="home"></span>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard/posts*') ? 'active' : '' }}" href="/dashboard/posts">
            <span data-feather="file-text"></span>
            Postingan Ku
          </a>
        </li>
      </ul>

      @can('admin')
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Administrator</span>
        </h6>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/categories*') ? 'active' : '' }}" href="/dashboard/categories">
              <span data-feather="grid"></span>
              Kategori Posting
            </a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/footers*') ? 'active' : '' }}" href="/dashboard/footers">
              <span data-feather="book"></span>
              Post Footer
            </a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/properties*') ? 'active' : '' }}" href="/dashboard/properties">
              <span data-feather="image"></span>
              Properti Gambar
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/profils*') ? 'active' : '' }}" href="/dashboard/profils">
              <span data-feather="clipboard"></span>
              Profil
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/files*') ? 'active' : '' }}" href="/dashboard/files">
              <span data-feather="file"></span>
              File RFC2350
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/services*') ? 'active' : '' }}" href="/dashboard/services">
              <span data-feather="award"></span>
              Layanan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/keys*') ? 'active' : '' }}" href="/dashboard/keys">
              <span data-feather="key"></span>
              PGP Key (Public Key)
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/guidances*') ? 'active' : '' }}" href="/dashboard/guidances">
              <span data-feather="book-open"></span>
              File Panduan
            </a>
          </li>
        
          @endcan
          @can('superadmin')          
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/users*') ? 'active' : '' }}" href="/dashboard/users">
              <span data-feather="users"></span>
              Manajemen Pengguna
            </a>
          </li>
          @endcan
        </ul>
    </div>
</nav>