<!DOCTYPE html>
<html lang="en">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/libs/head.php'; ?>
<!-- Main CSS -->
<link rel="stylesheet" href="/assets/css/app.css" type="text/css"/>
<body>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/default/navbar.php'; ?>
<div class="mai-wrapper">
    <div class="main-content container">
        <div class="row page-head">
            <div class="col-md-4 page-head-heading">
                <h1>Errore 403</h1>
            </div>
            <div class="col-md-8 page-head-desc">
                <h3>
                    Non hai i diritti per accedere a questa pagina. Torna alla
                    <a href="/">Homepage</a> o alla pagina di
                    <a href="/auth/logout.php">Login</a>.
                </h3>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/libs/head-js.php'; ?>
<script type="text/javascript">
    $(document).ready(function () {
        App.init();
    });
</script>
</body>
</html>
