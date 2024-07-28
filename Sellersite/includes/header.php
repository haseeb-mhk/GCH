


<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" style="position: fixed ; ;z-index: 1; width:82%;">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h1 class="h3 mb-0 text-gray-800"> <?php
$top_message = "";
if (isset($_GET['p_name'])) {
	$top_message = $_GET['p_name'];
    echo $top_message;
} else {
	$top_message = "Seller Dashboard";
    echo $top_message;
}


?></h1>
                
                    <ul class="navbar-nav ml-auto">
                           <!-- Nav Item - Alerts -->
                    

                       

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo($name); ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                             
                                <div class="dropdown-divider"></div>
                            <form method="post">
                                <button class="dropdown-item btn btn-danger" type="submit" name="btnLogout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </button>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>