<div class="col-md-6 col-sm-6 nav-link-hgn" data-url="<?= base_url(); ?>projects" >
              <div class="social-box social-box-4 linkedin">
              <i class="icon-rocket"> Project Active</i>
                <ul>
                  <li>
                    <strong><?= !empty($project['LEAD'])? $project['LEAD'] : 0 ?></strong>
                    <span>Lead</span>
                  </li>
                  <li>
                    <strong><?= !empty($project['LAG'])? $project['LAG'] : 0 ?></strong>
                    <span>Lag</span>
                  </li>
                  <li>
                    <strong><?= !empty($project['DELAY'])? $project['DELAY'] : 0 ?></strong>
                    <span>Delay</span>
                  </li>
                </ul>
              </div>
            </div>

            <div class="col-md-3 col-sm-6  nav-link-hgn" data-url="<?= base_url(); ?>projects/candidate">
              <div class="social-box twitter">
              <i class="icon-vector"> Candidate</i>
                <ul>
                  <li>
                    <strong><?= $project['LOP'] ?></strong>
                    <span>Epic</span>
                    </li>
                    <li>
                    <strong><?= !empty($project['NONLOP'])? $project['NONLOP'] : '0' ?></strong>
                    <span>Prime</span>
                  </li>
                </ul>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 nav-link-hgn" data-url="<?= base_url(); ?>bast">
              <div class="social-box google-plus">
              <i class="fa fa-handshake-o"> BAST</i>
                <ul>
                  <li>
                    <strong><?= $bast['progress'] ?></strong>
                    <span>In Progress</span>
                    </li>
                    <li>
                    <strong><?= $bast['approved'] ?></strong>
                    <span>Approved</span>
                  </li>
                </ul>
              </div>
            </div>