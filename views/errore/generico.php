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
                <?php if ($title == null) { ?>
                    <h1>Errore sconosciuto</h1>
                    <?php
                } else { ?>
                    <h1><?php echo $title ?></h1>
                    <?php
                } ?>
            </div>
            <div class="col-md-8 page-head-desc">
                <?php if ($desc == null) { ?>
                    <h3>
                        Sei stato reindirizzato su questa pagina a causa di un errore sconosciuto.<br>
                        Clicca <a href="/">qui</a> per tornare alla Homepage.
                    </h3>
                    <?php
                } else { ?>
                    <h3><?php echo $desc ?></h3>
                    <?php
                } ?>
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
