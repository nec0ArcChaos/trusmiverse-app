<div class="row mb-4">
    <div class="col-12 px-0">
        <?php
        $CI = &get_instance();
        $CI->load->model('Model_navigation', 'nav');
        $menu_a = $CI->nav->menu(1);
        $menu_b = $CI->nav->menu(2);
        $menu_c = $CI->nav->menu(3);
        $menu_d = $CI->nav->menu(4); 
        $menu_e = $CI->nav->menu(5); 

        $role_id = $this->session->userdata("user_role_id");
        $company_id = $this->session->userdata("company_id");
        $department_id = $this->session->userdata("department_id");
        $designation_id = $this->session->userdata("designation_id");
        $user_id = $this->session->userdata("user_id");
        $user_id_blocked = $this->session->userdata("user_id");
        ?>
        <ul class="nav nav-pills">
            <?php foreach ($menu_a as $a) { ?>

                <!-- check hak akses menu a -->
                <?php
                $status_role_id = 0; // not allowed
                if ($a->a_role_id != "") {
                    $allowed_a_role_id = explode(",", $a->a_role_id);
                    if (in_array($role_id, $allowed_a_role_id)) {
                        $status_role_id = 1; // allowed
                    }
                }

                $status_company_id = 0; // not allowed
                if ($a->a_company_id != "") {
                    $allowed_a_company_id = explode(",", $a->a_company_id);
                    if (in_array($company_id, $allowed_a_company_id)) {
                        $status_company_id = 1; // allowed
                    }
                }

                $status_department_id = 0; // not allowed
                if ($a->a_department_id != "") {
                    $allowed_a_department_id = explode(",", $a->a_department_id);
                    if (in_array($department_id, $allowed_a_department_id)) {
                        $status_department_id = 1; // allowed
                    }
                }

                $status_designation_id = 0; // not allowed
                if ($a->a_designation_id != "") {
                    $allowed_a_designation_id = explode(",", $a->a_designation_id);
                    if (in_array($designation_id, $allowed_a_designation_id)) {
                        $status_designation_id = 1; // allowed
                    }
                }

                $status_user_id = 0; // not allowed
                if ($a->a_user_id != "") {
                    $allowed_a_user_id = explode(",", $a->a_user_id);
                    if (in_array($user_id, $allowed_a_user_id)) {
                        $status_user_id = 1; // allowed
                    }
                }

                $status_user_id_blocked = 0; // not allowed
                if ($a->a_user_id_blocked != "") {
                    $allowed_a_user_id_blocked = explode(",", $a->a_user_id_blocked);
                    if (in_array($user_id_blocked, $allowed_a_user_id_blocked)) {
                        $status_user_id_blocked = 1; // allowed
                    }
                }

                if (
                    ($status_role_id == 1 || $status_company_id == 1 || $status_department_id == 1 || $status_designation_id == 1 || $status_user_id == 1)
                    && $status_user_id_blocked != 1
                ) {
                ?>
                    <!-- jika menu a single link -->
                    <?php if ($a->a_url != "#") { ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= base_url() . $a->a_url ?>"
                              <?= 
                                 // Tooltip level 1
                                 !empty($a->a_notes) 
                                    ? 'data-toggle="tooltip" data-placement="top" title="'.htmlspecialchars($a->a_notes, ENT_QUOTES, 'UTF-8').'"' 
                                    : '' 
                              ?> 
                            >
                                <div class="avatar avatar-40 icon"><i class="<?= $a->a_icon ?>"></i></div>
                                <div class="col"><?= $a->a_menu; ?></div>
                            </a>
                        </li>
                    <?php } ?>

                    <!-- jika menu a punya dropdown -->
                    <?php if ($a->a_url == "#") { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="false" data-bs-display="static" href="#" role="button" aria-expanded="false"
                              <?= 
                                 // Tooltip level 1
                                 !empty($a->a_notes) 
                                    ? 'data-toggle="tooltip" data-placement="top" title="'.htmlspecialchars($a->a_notes, ENT_QUOTES, 'UTF-8').'"' 
                                    : '' 
                              ?> 
                            >
                                <div class="avatar avatar-40 icon"><i class="<?= $a->a_icon ?>"></i></div>
                                <div class="col"><?= $a->a_menu; ?></div>
                                <div class="arrow"><i class="bi bi-chevron-right plus"></i> <i class="bi bi-chevron-down minus"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach ($menu_b as $b) { ?>


                                    <!-- check hak akses menu b -->
                                    <?php
                                    $status_role_id = 0; // not allowed
                                    if ($b->b_role_id != "") {
                                        $allowed_b_role_id = explode(",", $b->b_role_id);
                                        if (in_array($role_id, $allowed_b_role_id)) {
                                            $status_role_id = 1; // allowed
                                        }
                                    }

                                    $status_company_id = 0; // not allowed
                                    if ($b->b_company_id != "") {
                                        $allowed_b_company_id = explode(",", $b->b_company_id);
                                        if (in_array($company_id, $allowed_b_company_id)) {
                                            $status_company_id = 1; // allowed
                                        }
                                    }

                                    $status_department_id = 0; // not allowed
                                    if ($b->b_department_id != "") {
                                        $allowed_b_department_id = explode(",", $b->b_department_id);
                                        if (in_array($department_id, $allowed_b_department_id)) {
                                            $status_department_id = 1; // allowed
                                        }
                                    }

                                    $status_designation_id = 0; // not allowed
                                    if ($b->b_designation_id != "") {
                                        $allowed_b_designation_id = explode(",", $b->b_designation_id);
                                        if (in_array($designation_id, $allowed_b_designation_id)) {
                                            $status_designation_id = 1; // allowed
                                        }
                                    }

                                    $status_user_id = 0; // not allowed
                                    if ($b->b_user_id != "") {
                                        $allowed_b_user_id = explode(",", $b->b_user_id);
                                        if (in_array($user_id, $allowed_b_user_id)) {
                                            $status_user_id = 1; // allowed
                                        }
                                    }

                                    $status_user_id_blocked = 0; // not allowed
                                    if ($b->b_user_id_blocked != "") {
                                        $allowed_b_user_id_blocked = explode(",", $b->b_user_id_blocked);
                                        if (in_array($user_id_blocked, $allowed_b_user_id_blocked)) {
                                            $status_user_id_blocked = 1; // allowed
                                        }
                                    }
                                    if (
                                        ($status_role_id == 1 || $status_company_id == 1 || $status_department_id == 1 || $status_designation_id == 1 || $status_user_id == 1)
                                        && $status_user_id_blocked != 1
                                    ) { ?>

                                        <!-- jika menu b single link -->
                                        <?php if ($b->b_url != "#" && $b->b_parent_id == $a->a_id) { ?>
                                            <li>
                                                <a class="dropdown-item nav-link" href="<?= base_url() . $b->b_url ?>"
                                                   <?= 
                                                      // Tooltip level 2 
                                                      !empty($b->b_notes) 
                                                         ? 'data-toggle="tooltip" data-placement="top" title="'.htmlspecialchars($b->b_notes, ENT_QUOTES, 'UTF-8').'"' 
                                                         : '' 
                                                   ?> 
                                                >
                                                    <div class="avatar avatar-40 icon" style="margin-left: 8px;"><i class="<?= $b->b_icon ?>"></i>
                                                    </div>
                                                    <div class="col align-self-center"><?= $b->b_menu ?></div>
                                                </a>
                                            </li>
                                        <?php } // end if menu b single 
                                        ?>


                                        <!-- jika menu b punya dropdown -->
                                        <?php if ($b->b_url == "#" && $b->b_parent_id == $a->a_id) { ?>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="false" data-bs-display="static" href="#" role="button" aria-expanded="false"
                                                   <?= 
                                                      // Tooltip level 2
                                                      !empty($b->b_notes) 
                                                         ? 'data-toggle="tooltip" data-placement="top" title="'.htmlspecialchars($b->b_notes, ENT_QUOTES, 'UTF-8').'"' 
                                                         : '' 
                                                   ?> 
                                                >
                                                    <div class="avatar avatar-40 icon" style="margin-left: 8px;"><i class="<?= $b->b_icon ?>"></i></div>
                                                    <div class="col"><?= $b->b_menu; ?></div>
                                                    <div class="arrow"><i class="bi bi-chevron-right plus"></i> <i class="bi bi-chevron-down minus"></i>
                                                    </div>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <?php foreach ($menu_c as $c) { ?>

                                                        <!-- check hak akses menu c -->
                                                        <?php
                                                        $status_role_id = 0; // not allowed
                                                        if ($c->c_role_id != "") {
                                                            $allowed_c_role_id = explode(",", $c->c_role_id);
                                                            if (in_array($role_id, $allowed_c_role_id)) {
                                                                $status_role_id = 1; // allowed
                                                            }
                                                        }

                                                        $status_company_id = 0; // not allowed
                                                        if ($c->c_company_id != "") {
                                                            $allowed_c_company_id = explode(",", $c->c_company_id);
                                                            if (in_array($company_id, $allowed_c_company_id)) {
                                                                $status_company_id = 1; // allowed
                                                            }
                                                        }

                                                        $status_department_id = 0; // not allowed
                                                        if ($c->c_department_id != "") {
                                                            $allowed_c_department_id = explode(",", $c->c_department_id);
                                                            if (in_array($department_id, $allowed_c_department_id)) {
                                                                $status_department_id = 1; // allowed
                                                            }
                                                        }

                                                        $status_designation_id = 0; // not allowed
                                                        if ($c->c_designation_id != "") {
                                                            $allowed_c_designation_id = explode(",", $c->c_designation_id);
                                                            if (in_array($designation_id, $allowed_c_designation_id)) {
                                                                $status_designation_id = 1; // allowed
                                                            }
                                                        }

                                                        $status_user_id = 0; // not allowed
                                                        if ($c->c_user_id != "") {
                                                            $allowed_c_user_id = explode(",", $c->c_user_id);
                                                            if (in_array($user_id, $allowed_c_user_id)) {
                                                                $status_user_id = 1; // allowed
                                                            }
                                                        }

                                                        $status_user_id_blocked = 0; // not allowed
                                                        if ($c->c_user_id_blocked != "") {
                                                            $allowed_c_user_id_blocked = explode(",", $c->c_user_id_blocked);
                                                            if (in_array($user_id_blocked, $allowed_c_user_id_blocked)) {
                                                                $status_user_id_blocked = 1; // allowed
                                                            }
                                                        }
                                                        if (
                                                            ($status_role_id == 1 || $status_company_id == 1 || $status_department_id == 1 || $status_designation_id == 1 || $status_user_id == 1)
                                                            && $status_user_id_blocked != 1
                                                        ) { ?>

                                                            <!-- jika menu c single link -->
                                                            <?php if ($c->c_url != "#" && $c->c_parent_id == $b->b_id) { ?>
                                                                <li>
                                                                    <a class="dropdown-item nav-link" href="<?= base_url() . $c->c_url ?>"
                                                                        <?= 
                                                                           // Tooltip level 3
                                                                           !empty($c->c_notes) 
                                                                           ? 'data-toggle="tooltip" data-placement="top" title="'.htmlspecialchars($c->c_notes, ENT_QUOTES, 'UTF-8').'"' 
                                                                           : '' 
                                                                        ?>    
                                                                    >
                                                                        <div class="avatar avatar-40 icon" style="margin-left: 16px;"><i class="<?= $c->c_icon ?>"></i>
                                                                        </div>
                                                                        <div class="col align-self-center"><?= $c->c_menu ?></div>
                                                                    </a>
                                                                </li>
                                                            <?php } // end if menu c single 
                                                            ?>

                                                            <!-- jika menu c punya dropdown -->
                                                            <?php if ($c->c_url == "#" && $c->c_parent_id == $b->b_id) { ?>
                                                               <li class="nav-item dropdown">
                                                                  <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="false" data-bs-display="static" href="#" role="button" aria-expanded="false"
                                                                  <?= 
                                                                     // Tooltip level 3
                                                                     !empty($c->c_notes) 
                                                                     ? 'data-toggle="tooltip" data-placement="top" title="'.htmlspecialchars($c->c_notes, ENT_QUOTES, 'UTF-8').'"' 
                                                                     : '' 
                                                                  ?>  
                                                                  >
                                                                     <div class="avatar avatar-40 icon" style="margin-left: 16px;"><i class="<?= $c->c_icon ?>"></i></div>
                                                                     <div class="col"><?= $c->c_menu; ?></div>
                                                                     <div class="arrow"><i class="bi bi-chevron-right plus"></i> <i class="bi bi-chevron-down minus"></i>
                                                                     </div>
                                                                  </a>

                                                                  <ul class="dropdown-menu">
                                                                        <?php foreach ($menu_d as $d) { ?>
                                                                           <!-- check hak akses menu d -->
                                                                           <?php
                                                                           $status_role_id = 0;
                                                                           if ($d->d_role_id != "") {
                                                                              $allowed_d_role_id = explode(",", $d->d_role_id);
                                                                              if (in_array($role_id, $allowed_d_role_id)) $status_role_id = 1;
                                                                           }
                                                                           $status_company_id = 0;
                                                                           if ($d->d_company_id != "") {
                                                                              $allowed_d_company_id = explode(",", $d->d_company_id);
                                                                              if (in_array($company_id, $allowed_d_company_id)) $status_company_id = 1;
                                                                           }
                                                                           $status_department_id = 0;
                                                                           if ($d->d_department_id != "") {
                                                                              $allowed_d_department_id = explode(",", $d->d_department_id);
                                                                              if (in_array($department_id, $allowed_d_department_id)) $status_department_id = 1;
                                                                           }
                                                                           $status_designation_id = 0;
                                                                           if ($d->d_designation_id != "") {
                                                                              $allowed_d_designation_id = explode(",", $d->d_designation_id);
                                                                              if (in_array($designation_id, $allowed_d_designation_id)) $status_designation_id = 1;
                                                                           }
                                                                           $status_user_id = 0;
                                                                           if ($d->d_user_id != "") {
                                                                              $allowed_d_user_id = explode(",", $d->d_user_id);
                                                                              if (in_array($user_id, $allowed_d_user_id)) $status_user_id = 1;
                                                                           }
                                                                           $status_user_id_blocked = 0;
                                                                           if ($d->d_user_id_blocked != "") {
                                                                              $allowed_d_user_id_blocked = explode(",", $d->d_user_id_blocked);
                                                                              if (in_array($user_id_blocked, $allowed_d_user_id_blocked)) $status_user_id_blocked = 1;
                                                                           }
                                                                           if (($status_role_id == 1 || $status_company_id == 1 || $status_department_id == 1 || $status_designation_id == 1 || $status_user_id == 1) && $status_user_id_blocked != 1) {
                                                                           ?>

                                                                              <!-- jika menu d single link -->
                                                                              <?php if ($d->d_url != "#" && $d->d_parent_id == $c->c_id) { ?>
                                                                                    <li>
                                                                                       <a class="dropdown-item nav-link" href="<?= base_url() . $d->d_url ?>"
                                                                                          <?= 
                                                                                             // Tooltip level 4
                                                                                             !empty($d->d_notes) 
                                                                                             ? 'data-toggle="tooltip" data-placement="top" title="'.htmlspecialchars($d->d_notes, ENT_QUOTES, 'UTF-8').'"' 
                                                                                             : '' 
                                                                                          ?>
                                                                                       >
                                                                                          <div class="avatar avatar-40 icon" style="margin-left: 28px;"><i class="<?= $d->d_icon ?>"></i>
                                                                                          </div>
                                                                                          <div class="col align-self-center"><?= $d->d_menu ?></div>
                                                                                       </a>
                                                                                    </li>
                                                                              <?php } ?>

                                                                              <!-- jika menu d punya dropdown -->
                                                                              <?php if ($d->d_url == "#" && $d->d_parent_id == $c->c_id) { ?>
                                                                                    <li class="nav-item dropdown">
                                                                                       <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="false" data-bs-display="static" href="#" role="button" aria-expanded="false"
                                                                                          <?= 
                                                                                             // Tooltip level 4
                                                                                             !empty($d->d_notes) 
                                                                                             ? 'data-toggle="tooltip" data-placement="top" title="'.htmlspecialchars($d->d_notes, ENT_QUOTES, 'UTF-8').'"' 
                                                                                             : '' 
                                                                                          ?>
                                                                                       >
                                                                                          <div class="avatar avatar-40 icon" style="margin-left: 28px;"><i class="<?= $b->b_icon ?>"></i></div>
                                                                                          <div class="col"><?= $d->d_menu; ?></div>
                                                                                          <div class="arrow"><i class="bi bi-chevron-right plus"></i> <i class="bi bi-chevron-down minus"></i>
                                                                                          </div>
                                                                                       </a>
                                                                                       <ul class="dropdown-menu">
                                                                                          <?php foreach ($menu_e as $e) { ?>
                                                                                                <?php
                                                                                                $status_role_id = 0;
                                                                                                if ($e->e_role_id != "") {
                                                                                                   $allowed_e_role_id = explode(",", $e->e_role_id);
                                                                                                   if (in_array($role_id, $allowed_e_role_id)) $status_role_id = 1;
                                                                                                }
                                                                                                $status_company_id = 0;
                                                                                                if ($e->e_company_id != "") {
                                                                                                   $allowed_e_company_id = explode(",", $e->e_company_id);
                                                                                                   if (in_array($company_id, $allowed_e_company_id)) $status_company_id = 1;
                                                                                                }
                                                                                                $status_department_id = 0;
                                                                                                if ($e->e_department_id != "") {
                                                                                                   $allowed_e_department_id = explode(",", $e->e_department_id);
                                                                                                   if (in_array($department_id, $allowed_e_department_id)) $status_department_id = 1;
                                                                                                }
                                                                                                $status_designation_id = 0;
                                                                                                if ($e->e_designation_id != "") {
                                                                                                   $allowed_e_designation_id = explode(",", $e->e_designation_id);
                                                                                                   if (in_array($designation_id, $allowed_e_designation_id)) $status_designation_id = 1;
                                                                                                }
                                                                                                $status_user_id = 0;
                                                                                                if ($e->e_user_id != "") {
                                                                                                   $allowed_e_user_id = explode(",", $e->e_user_id);
                                                                                                   if (in_array($user_id, $allowed_e_user_id)) $status_user_id = 1;
                                                                                                }
                                                                                                $status_user_id_blocked = 0;
                                                                                                if ($e->e_user_id_blocked != "") {
                                                                                                   $allowed_e_user_id_blocked = explode(",", $e->e_user_id_blocked);
                                                                                                   if (in_array($user_id_blocked, $allowed_e_user_id_blocked)) $status_user_id_blocked = 1;
                                                                                                }
                                                                                                if (($status_role_id == 1 || $status_company_id == 1 || $status_department_id == 1 || $status_designation_id == 1 || $status_user_id == 1) && $status_user_id_blocked != 1) {
                                                                                                ?>
                                                                                                   <!-- menu e hanya single link -->
                                                                                                   <?php if ($e->e_url != "#" && $e->e_parent_id == $d->d_id) { ?>
                                                                                                      <li>
                                                                                                            <a class="dropdown-item nav-link" href="<?= base_url() . $e->e_url ?>"
                                                                                                               <?= 
                                                                                                                  // Tooltip level 5
                                                                                                                  !empty($e->e_notes) 
                                                                                                                  ? 'data-toggle="tooltip" data-placement="top" title="'.htmlspecialchars($e->e_notes, ENT_QUOTES, 'UTF-8').'"' 
                                                                                                                  : '' 
                                                                                                               ?>
                                                                                                            >
                                                                                                               <div class="avatar avatar-40 icon" style="margin-left: 36px;"><i class="<?= $e->e_icon ?>"></i>
                                                                                                               </div>
                                                                                                               <div class="col align-self-center"><?= $e->e_menu ?></div>
                                                                                                            </a>
                                                                                                      </li>
                                                                                                   <?php } ?>
                                                                                                <?php } ?>
                                                                                          <?php } ?>
                                                                                       </ul>
                                                                                    </li>
                                                                              <?php } ?>
                                                                           <?php } ?>
                                                                        <?php } ?>
                                                                  </ul>
                                                               </li>
                                                            <?php } ?>

                                                        <?php } // end if hak akses c
                                                        ?>
                                                    <?php } // end  foreach menu c
                                                    ?>
                                                </ul>
                                            </li>
                                        <?php } // end if menu b dropdown 
                                        ?>
                                    <?php } // end if hak akses menu b 
                                    ?>
                                <?php } // end if foreach menu b
                                ?>
                            </ul>
                        </li>
                    <?php } ?>
                <?php } // end if hak akses                
                ?>
            <?php } // end foreach menu a
            ?>

            <?php
            $user_it = array(1, 61, 62, 63, 64, 323, 979, 1161, 2041, 2063, 2969, 2070, 2903);
            if (in_array($user_id, $user_it)) { ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('department'); ?>">
                        <div class="avatar avatar-40 icon"><i class="bi bi-diagram-3"></i></div>
                        <div class="col">Department</div>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>