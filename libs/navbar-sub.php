<nav class="navbar mai-sub-header">
    <div class="container">
        <!-- Mega Menu structure-->
        <nav class="navbar navbar-toggleable-sm">
            <button type="button" data-toggle="collapse" data-target="#mai-navbar-collapse"
                    aria-controls="#mai-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"
                    class="navbar-toggler hidden-md-up collapsed">
                <div class="icon-bar"><span></span><span></span><span></span></div>
            </button>
            <div id="mai-navbar-collapse" class="navbar-collapse collapse mai-nav-tabs">
                <ul class="nav navbar-nav">
                    <?php
                    $url = explode("/", $_SERVER['PHP_SELF']);
                    //unset($url[count($url) - 1]);
                    switch ($_SESSION['user_data']['ruolo']) {
                        case 1:
                            echo '
                <!--<li class="nav-item parent';
                            if (explode("/", $_SERVER['PHP_SELF'])[1] == 'index.php') echo ' open';
                            echo '"><a href="#" role="button" aria-expanded="false" class="nav-link"><span class="icon s7-home"></span><span>Home</span></a>
                  <ul class="mai-nav-tabs-sub mai-sub-nav nav">
                    <li class="nav-item"><a href="/" class="nav-link active"><span class="icon s7-note2"></span><span class="name">Riepilogo</span></a>
                    </li>
                  </ul>
                </li>-->
                <li class="nav-item parent';
                            if (explode("/", $_SERVER['PHP_SELF'])[1] == 'gestione-cantieri') echo ' open';
                            echo '"><a href="#" role="button" aria-expanded="false" class="nav-link"><span class="icon s7-tools"></span><span>Cantieri</span></a>
                  <ul class="mai-nav-tabs-sub mai-sub-nav nav">
                    <li class="nav-item"><a href="/gestione-cantieri/" class="nav-link"><span class="icon s7-config"></span><span class="name">Gestione Cantieri</span></a>
                    </li>
                    <li class="nav-item"><a href="/gestione-cantieri/attivita/" class="nav-link"><span class="icon s7-pin"></span><span class="name">Gestione Attività</span></a>
                    </li>
                    <!--<li class="nav-item"><a href="/gestione-cantieri/" class="nav-link"><span class="icon s7-attention"></span><span class="name">Segnalazioni</span></a>
                    </li>-->
                  </ul>
                </li>';
                            break;
                        case 3:
                            echo '
                <!--<li class="nav-item parent';
                            if (explode("/", $_SERVER['PHP_SELF'])[1] == 'index.php') echo ' open';
                            echo '"><a href="#" role="button" aria-expanded="false" class="nav-link"><span class="icon s7-home"></span><span>Home</span></a>
                  <ul class="mai-nav-tabs-sub mai-sub-nav nav">
                    <li class="nav-item"><a href="/" class="nav-link active"><span class="icon s7-note2"></span><span class="name">Riepilogo</span></a>
                    </li>
                  </ul>
                </li>-->
                <li class="nav-item parent';
                            if (explode("/", $_SERVER['PHP_SELF'])[1] == 'gestione-cantieri') echo ' open';
                            echo '"><a href="#" role="button" aria-expanded="false" class="nav-link"><span class="icon s7-tools"></span><span>Cantieri</span></a>
                  <ul class="mai-nav-tabs-sub mai-sub-nav nav">
                    <li class="nav-item"><a href="/gestione-cantieri/" class="nav-link"><span class="icon s7-config"></span><span class="name">Gestione Cantieri</span></a>
                    </li>
                    <li class="nav-item"><a href="/gestione-cantieri/attivita/" class="nav-link"><span class="icon s7-pin"></span><span class="name">Gestione Attività</span></a>
                    </li>
                    <!--<li class="nav-item"><a href="/gestione-cantieri/" class="nav-link"><span class="icon s7-attention"></span><span class="name">Segnalazioni</span></a>
                    </li>-->
                  </ul>
                </li>
                <li class="nav-item parent';
                            if (explode("/", $_SERVER['PHP_SELF'])[1] == 'gestione-utenti') echo ' open';
                            echo '"><a href="#" role="button" aria-expanded="false" class="nav-link"><span class="icon s7-users"></span><span>Utenti</span></a>
                  <ul class="mai-nav-tabs-sub mai-sub-nav nav">
                    <li class="nav-item"><a href="/gestione-utenti/" class="nav-link"><span class="icon s7-note"></span><span class="name">Gestione Utenti</span></a>
                    </li>
                    <li class="nav-item"><a href="/gestione-utenti/creazione/" class="nav-link"><span class="icon s7-add-user"></span><span class="name">Creazione Utenti</span></a>
                    </li>
                  </ul>
                </li>
                ';
                            break;
                    }
                    ?>
                </ul>
            </div>
        </nav>
        <!--Search input MOMENTANEAMENTE DISATTIVATO
        <div class="search">
          <input type="text" placeholder="Search..." name="q"><span class="s7-search"></span>
        </div> -->
    </div>
</nav>
