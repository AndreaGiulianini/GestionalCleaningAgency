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
                        <table id="table" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Numero Fattura</th>
                                <th>Aggiunta</th>
                                <th>Totale senza spedizione</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data as $value) {
                                ?>
                                <tr>
                                    <td><?php echo $value['id']; ?></td>
                                    <td><?php echo $value['numero']; ?></td>
                                    <td><?php echo $value['aggiunta']; ?></td>
                                    <td><?php echo $value['totale']; ?></td>
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
        App.init();
        var table = $("#table").DataTable(
            {
                buttons: [
                    {
                        text: 'Bolla Spedizione',
                        action: function (e, dt, node, config) {
                            if ($('#table .selected').length > 0) {
                                window.location.href = '/gestione-magazzino/pdfBolla.php?idSped=' + table.row('.selected').data()[0] + '&prezzo=' + prezzo + '&type=' + type;
                            } else {
                                $.gritter.add({
                                    title: 'Attenzione',
                                    text: 'Selezionare una riga',
                                    class_name: 'gritter-color warning'
                                });
                            }
                        },
                        className: 'btn-secondary'
                    },
                ]
            }
        );
        $('#table tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
    });
</script>
</body>
</html>
