<?php $user_regional = !empty($this->session->userdata('regional')) ? $this->session->userdata('regional') : 0; ?> 

  <div class="app-body">
    <div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">
          <li class="nav-item"> 
            <a class="nav-link nav-link-hgn" id="menu-dashboard" href="<?= base_url(); ?>"><i class="icon-speedometer"></i> Dashboard </a>
          </li>
          <li class="nav-item"> 
            <a class="nav-link nav-link-hgn" id="menu-timeline" href="<?= base_url(); ?>timeline"><i class="icon-globe"></i> Timeline <span class="badge badge-warning">DEV</span></a>
          </li>
          <?php if($this->auth->get_access_value('PROJECT')>0) : ?>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" id="menu-project-active" href="<?= base_url(); ?>projects"><i class="icon-rocket"></i> Projects Active</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" id="project-non-pm" href="<?= base_url(); ?>projects/nonPM" ><i class="icon-cursor"></i> Projects Non PM </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" id="menu-project-candidate" href="<?= base_url(); ?>projects/candidate"><i class="icon-vector"></i> Projects Candidate </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" id="menu-project-closed" href="<?= base_url(); ?>projects/closed"><i class="icon-badge"></i> Projects Closed</a>
          </li>

          <!-- <li class="nav-item">
            <a class="nav-link nav-link-hgn" id="menu-project-cancel" href="<?= base_url(); ?>projects/cancel"><i class="icon-badge"></i> Projects Cancel <span class="badge badge-warning">DEV</span></a>
          </li> -->

          <?php endif; ?>
          
          <?php if(!empty($this->session->userdata('regional')==0)) :  ?>
            <li class="nav-item">
              <a class="nav-link nav-link-hgn" id="menu-bast" href="<?= base_url(); ?>bast"><i class="fa fa-handshake-o"></i> BAST </a>
            </li>
          <?php endif; ?>
          <!-- <li class="nav-item">
            <a class="nav-link nav-link-hgn" id="menu-lpp" href="<?= base_url(); ?>lpp"><i class="icon-star"></i> LPP <span class="badge badge-warning">DEV</span></a>
          </li> -->
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" id="menu-monitoring" href="#"><i class="icon-screen-desktop"></i> Monitoring</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>monitoring/pm" ><i class="icon-star"></i> Project Manager </a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>monitoring/planAch"><i class="icon-star"></i> 
                Plan - Achievment</a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>monitoring/issueAp"><i class="icon-star"></i> 
                Issue - Action Plan </a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>monitoring/bast"><i class="icon-star"></i> 
                BAST Project</a>
              </li>

              <?php if(!empty($this->session->userdata('regional')==0)) :  ?>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>monitoring/subsidiary"><i class="icon-star"></i> Subsidiary <span class="badge badge-warning">DEV</span></a>
              </li>
              <?php endif; ?>

            </ul>
          </li>
          <?php if(!empty($this->session->userdata('regional')==0)) :  ?>
              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" id="menu-monitoring" href="#"><i class="fa fa-cog"></i> Utility</a>
                <ul class="nav-dropdown-items">
                   <li class="nav-item">
                    <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>utility/domes_bast" ><i class="icon-star"></i>BAST DOMES </a>
                  </li>
                </ul>
              </li>
          <?php endif; ?>

          <?php if($this->auth->get_access_value('MASTER')>0) : ?>
          <li class="nav-title">
            Admin Menu 
          </li>
          
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>user"><i class="icon-puzzle"></i> Users </a>
          </li>
          <?php 
          if($user_regional == 0) : ?>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>master/am"><i class="icon-puzzle"></i> Acc. Manager </a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>master/subsidiary"><i class="icon-puzzle"></i> Subsidiary</a>
              </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>timeline/post"><i class="fa fa-thumbtack"></i> Post <span class="badge badge-warning">DEV</span></a> 
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>timeline/credit_point"><i class="fa fa-trophy"></i> Credit Point <span class="badge badge-warning">DEV</span></a> 
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>master/history"><i class="icon-puzzle"></i> History</a>
          </li>

          <?php if($user_regional == 0) : ?>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>master/api"><i class="icon-puzzle"></i> API <span class="badge badge-warning">DEV</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-hgn" href="<?= base_url(); ?>master/customer"><i class="icon-puzzle"></i> Config <span class="badge badge-warning">DEV</span></a>
          </li>
          <?php endif; ?>

          <?php endif; ?>

        </ul>
      </nav>
      <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>

    <!-- Main content -->
    <main class="main">

      <div class="container-fluid">
        <div id="pre-load-background">
        </div>
        <div id="ui-view">
