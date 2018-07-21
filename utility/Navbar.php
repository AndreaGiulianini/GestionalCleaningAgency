<?php

class Navbar
{
    private $userType;
    private $userPic;
    private $userName;
    private $currentRoute;
    private $items = [
        [
            "name" => "Magazzino",
            "roles" => [3],
            "path" => "gestione-magazzino",
            "icon" => "s7-box1",
            "children" => [
                [
                    "name" => "Aggiungi",
                    "roles" => [3],
                    "path" => "",
                    "icon" => "s7-note"
                ],
                [
                    "name" => "Spedizioni",
                    "roles" => [3],
                    "path" => "spedizioni",
                    "icon" => "s7-note"
                ],
                [
                    "name" => "Causali",
                    "roles" => [3],
                    "path" => "causali",
                    "icon" => "s7-note"
                ],
                [
                    "name" => "Lista Categorie",
                    "roles" => [3],
                    "path" => "categorie",
                    "icon" => "s7-note"
                ],
                [
                    "name" => "Lista Magazzini",
                    "roles" => [3],
                    "path" => "listaMagazzini",
                    "icon" => "s7-note"
                ],
                [
                    "name" => "Lista Prodotti",
                    "roles" => [3],
                    "path" => "listaProdotti",
                    "icon" => "s7-note"
                ],
                [
                    "name" => "Lista Spedizioni",
                    "roles" => [3],
                    "path" => "listaSpedizioni",
                    "icon" => "s7-note"
                ],
            ]
        ],
        [
            "name" => "Fatture",
            "roles" => [3],
            "path" => "gestione-fatture",
            "icon" => "s7-users",
            "children" => [
                [
                    "name" => "Genera Fattura",
                    "roles" => [3],
                    "path" => "",
                    "icon" => "s7-note"
                ],
                [
                    "name" => "Lista Fatture",
                    "roles" => [3],
                    "path" => "listaFatture",
                    "icon" => "s7-note"
                ],
                [
                    "name" => "Fatture Ricevute",
                    "roles" => [3],
                    "path" => "fattureRicevute",
                    "icon" => "s7-note"
                ],
            ]
        ],
        [
            "name" => "Cliente",
            "roles" => [2],
            "path" => "gestione-cliente",
            "icon" => "s7-users",
            "children" => [
                [
                    "name" => "Fatture",
                    "roles" => [2],
                    "path" => "",
                    "icon" => "s7-note"
                ],
                [
                    "name" => "Crea Magazzino",
                    "roles" => [2],
                    "path" => "creazioneMag",
                    "icon" => "s7-note"
                ],
            ]
        ],
        [
            "name" => "Dipendente",
            "roles" => [1],
            "path" => "gestione-dipendente",
            "icon" => "s7-users",
            "children" => [
                [
                    "name" => "Servizi",
                    "roles" => [1],
                    "path" => "",
                    "icon" => "s7-note"
                ]
            ]
        ],
        [
            "name" => "Generazione Utenti",
            "roles" => [3],
            "path" => "gestione-utenti",
            "icon" => "s7-users",
            "children" => [
                [
                    "name" => "Generazione Dipendente",
                    "roles" => [3],
                    "path" => "dipendente",
                    "icon" => "s7-note"
                ],
                [
                    "name" => "Generazione Cliente",
                    "roles" => [3],
                    "path" => "cliente",
                    "icon" => "s7-note"
                ],
            ]
        ],
    ];

    private function generateHeader()
    {
        return '
            <nav class="navbar navbar-full navbar-inverse navbar-fixed-top mai-top-header">
                <div class="container">
                    <a href="/" class="navbar-brand" style="background-image: none;"><img class="img-responsive" style="width:320px"src="/assets/img/loghi/logo_steso.png"/></a>
                    <ul class="nav navbar-nav mai-top-nav">
                    </ul>
                    <ul class="nav navbar-nav float-lg-right mai-user-nav">
                      <li class="dropdown nav-item">
                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle nav-link">
                          <img style="background-color:white" src="' . $this->userPic . '">
                            <span class="user-name">' . $this->userName . '</span>
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
        ';
    }

    private $navMainStart = '
        <nav class="navbar mai-sub-header">
          <div class="container">
            <nav class="navbar navbar-toggleable-sm">
              <button type="button" data-toggle="collapse" data-target="#mai-navbar-collapse" aria-controls="#mai-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler hidden-md-up collapsed">
                <div class="icon-bar"><span></span><span></span><span></span></div>
              </button>
              <div id="mai-navbar-collapse" class="navbar-collapse collapse mai-nav-tabs">
                <ul class="nav navbar-nav">
    ';

    private $navMainEnd = '
                 </ul>
              </div>
            </nav>
          </div>
        </nav>
    ';

    private function generateChildItem($item, $parentActive)
    {
        $active = '';
        if ($this->routeByLevels[2] == $item['path'] && $parentActive) {
            $active = ' active';
        }
        return '<li class="nav-item"><a href="/' . $item['parentPath'] . '/' . $item['path'] . '" class="nav-link' . $active . '"><span class="icon ' . $item['icon'] . '"></span><span class="name">' . $item['name'] . '</span></a>';
    }

    private function generateMainItem($item)
    {
        $active = '';
        $flag = false;
        if ($this->routeByLevels[1] == $item['path']) {
            $active = ' open';
            $flag = true;
        }
        $html = '
            <li class="nav-item parent' . $active . '">
                <a href="#" role="button" aria-expanded="false" class="nav-link">
                    <span class="icon ' . $item['icon'] . '"></span><span>' . $item['name'] . '</span></a>
                    <ul class="mai-nav-tabs-sub mai-sub-nav nav">
        ';
        foreach ($item['children'] as $child) {
            if (in_array($this->userType, $child['roles'])) {
                $child['parentPath'] = $item['path'];
                $html .= $this->generateChildItem($child, $flag);
            }
        }
        $html .= '
            </ul>
        ';
        $html .= '
            </li>
        ';
        return $html;
    }

    public function initialize($user)
    {
        if (!isset($user['role'])) {
            return false;
        }
        $this->userType = $user['role'];
        $this->userPic = $user['pic'];
        $this->userName = $user['username'];
        $this->currentRoute = $_SERVER['PHP_SELF'];
        $levels = explode("/", $this->currentRoute);
        if ($levels[count($levels) - 1] == "index.php") {
            $levels[count($levels) - 1] = "";
        } elseif ($levels[count($levels) - 1] != "") {
            $levels[] = "";
        }
        $this->routeByLevels = $levels;

        $html = $this->generateHeader();
        $html .= $this->navMainStart;
        foreach ($this->items as $item) {
            if (in_array($this->userType, $item['roles'])) {
                $html .= $this->generateMainItem($item);
            }
        }
        $html .= $this->navMainEnd;
        return $html;
    }
}
