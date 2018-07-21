<nav class="navbar navbar-full navbar-inverse navbar-fixed-top mai-top-header">
    <div class="container"><a href="/" class="navbar-brand" style="    background-image: none;"><img
                    class="img-responsive" style="width:320px" src="/assets/img/loghi/Aurea_Logo_Nav.png"/></a>
        <!--Left Menu-->
        <ul class="nav navbar-nav mai-top-nav">
        </ul>
        <!--User Menu-->
        <ul class="nav navbar-nav float-lg-right mai-user-nav">
            <li class="dropdown nav-item">
                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle nav-link">
                    <img style="background-color:white" src="<?php echo $_SESSION['user_data']['foto']; ?>">
                    <span class="user-name">
                  <?php echo $_SESSION['user_data']['username']; ?>
                </span>
                    <span class="angle-down s7-angle-down"></span>
                </a>
                <div role="menu" class="dropdown-menu">
                    <a href="/auth/logout.php" class="dropdown-item">
                        <span class="icon s7-power"> </span>Log Out
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
