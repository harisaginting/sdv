  <div class="app-body">
    <div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" data-url="<?= base_url(); ?>dashboard/main"><i class="icon-speedometer"></i> Dashboard </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" data-url="<?= base_url(); ?>projects" data-url=''><i class="icon-star"></i> Projects </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" data-url="<?= base_url(); ?>projects/candidate" data-url=''><i class="icon-star"></i> Projects Candidate </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" data-url="<?= base_url(); ?>bast"><i class="icon-star"></i> BAST </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" data-url="<?= base_url(); ?>lpp"><i class="icon-star"></i> LPP </a>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-screen-desktop"></i> Monitoring</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="icons/flags.html"><i class="icon-star"></i> Project Manager </a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="icons/font-awesome.html"><i class="icon-star"></i> Deliverable </a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="icons/simple-line-icons.html"><i class="icon-star"></i> Customers</a>
              </li>

              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="icons/simple-line-icons.html"><i class="icon-star"></i> Partners</a>
              </li>

            </ul>
          </li>

          <li class="nav-title">
            Admin Menu
          </li>
          
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-link-hgn nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Users</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" data-url="<?= base_url(); ?>masters/customer"><i class="icon-puzzle"></i> Local</a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" data-url="<?= base_url(); ?>masters/partners"><i class="icon-puzzle"></i> Partners</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="charts.html"><i class="icon-pie-chart"></i> Account Manager</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="charts.html"><i class="icon-pie-chart"></i> Segmen</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="charts.html"><i class="icon-pie-chart"></i> Parners</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="charts.html"><i class="icon-pie-chart"></i> History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="charts.html"><i class="icon-pie-chart"></i> Config</a>
          </li>

        </ul>
      </nav>
      <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>

    <!-- Main content -->
    <main class="main">

      <div class="container-fluid">
        <div id="ui-view">
