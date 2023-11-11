<nav class="sidebar">
    <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
        MMCZ<span>F.M.S</span>
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">
      <ul class="nav">
        <li class="nav-item nav-category">ADMIN</li>
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item nav-category">File Management</li>

        <li class="nav-item">
          <a href="{{route('manage-files')}}" class="nav-link">
            <i class="link-icon" data-feather="message-square"></i>
            <span class="link-title">Manage Files</span>
          </a>
        </li>


        <li class="nav-item">
            <a href="{{route('achieved-files')}}" class="nav-link">
              <i class="link-icon" data-feather="message-square"></i>
              <span class="link-title">Achieved Files</span>
            </a>
          </li>
        <li class="nav-item nav-category">User Management</li>

        <li class="nav-item">
          <a href="{{route('manage-users')}}" class="nav-link">
            <i class="link-icon" data-feather="users"></i>
            <span class="link-title">Manage Users</span>
          </a>
        </li>

        <li class="nav-item nav-category">Company Setup</li>

        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
            <i class="link-icon" data-feather="anchor"></i>
            <span class="link-title">Configurations</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="advancedUI">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{route('departments')}}" class="nav-link">Departments</a>
              </li>


            </ul>
          </div>

          <div class="collapse" id="advancedUI">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{route('folders')}}" class="nav-link">Folders</a>
              </li>


            </ul>
          </div>
        <li class="nav-item nav-category">Docs</li>
        <li class="nav-item">
          <a href="#" target="_blank" class="nav-link">
            <i class="link-icon" data-feather="hash"></i>
            <span class="link-title">Documentation</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>
