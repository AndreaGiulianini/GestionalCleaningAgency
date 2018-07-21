<!DOCTYPE html>
<html lang="en">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/libs/head.php'; ?>
<!-- Calendar -->
<link rel="stylesheet" type="text/css" href="/assets/lib/jquery.fullcalendar/fullcalendar.min.css"/>
<!-- Main CSS -->
<link rel="stylesheet" href="/assets/css/app.css" type="text/css"/>
<style>
    .timetable td {
        text-align: center;
    }
</style>
<body>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/default/navbar.php'; ?>
<div class="mai-wrapper">
    <div class="main-content container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">Lista Fatture</div>
                    <div class="panel-body" style="padding-bottom: 20px;">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Servizio</th>
                                <th>Fattura</th>
                                <th>Cliente</th>
                                <th>Via</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data as $d) { ?>
                                <tr>
                                    <td><?php echo $d['nome']; ?></td>
                                    <td><?php echo $d['numero'] . " " . $d['add']; ?></td>
                                    <td><?php echo $d[0]['nomeC']; ?></td>
                                    <td><?php echo $d[0]['viaC']; ?></td>
                                    <td><?php echo $d['data'] ?></td>
                                </tr>
                                <?php
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/libs/head-js.php'; ?>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $(".table").DataTable({buttons: []});
    });
</script>
</body>
</html>
