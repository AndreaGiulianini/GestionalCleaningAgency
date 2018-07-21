<!DOCTYPE html>
<html lang="en">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/libs/head.php'; ?>
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
                    <div class="panel-heading">Lista Spedizioni</div>
                    <div class="panel-body" style="padding-bottom: 20px;">
                        <table id="table" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Magazzino Provenienza</th>
                                <th>Magazzino Destinazionione</th>
                                <th>Numero Bolla</th>
                                <th>Data</th>
                                <th>Data Scadenza</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($ids as $value) { ?>
                                <tr>
                                    <td><?php echo $value['id']; ?></td>
                                    <td><?php echo $value['nomeP']; ?></td>
                                    <td><?php echo $value['nomeD']; ?></td>
                                    <td><?php echo $value['bolla']; ?></td>
                                    <td><?php echo $value['data']; ?></td>
                                    <td <?php echo $value['css']; ?>><?php echo $value['dataScadenza']; ?></td>
                                </tr>
                            <?php } ?>
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
        //initialize the javascript
        App.init();
        var prezzo = "con";
        var type = "ven";
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
                    /* {
                        text: 'Con Prezzo',
                        action: function ( e, dt, node, config ) {
                            if(prezzo == "con"){
                                $(".prezzo").html("Senza Prezzo");
                                prezzo = "senza";
                            }
                            else{
                                $(".prezzo").html("Con Prezzo");
                                prezzo = "con";
                            }
                        },
                        className: 'btn-secondary prezzo'
                    }, */
                    {
                        text: 'Vendita',
                        action: function (e, dt, node, config) {
                            if (type == "ven") {
                                $(".vendita").html("Acquisto");
                                type = "acq";
                            }
                            else {
                                $(".vendita").html("Vendita");
                                type = "ven";
                            }
                        },
                        className: 'btn-secondary vendita'
                    },
                    {
                        text: 'Eseguita',
                        action: function (e, dt, node, config) {
                            $.ajax({
                                method: "POST",
                                url: "/views/magazzino/listaSpedizioni/updateExecution.php",
                                data: {
                                    'id': table.row('.selected').data()[0],
                                    'eseguita': 1,
                                }
                            }).done(function (msg) {
                                var tmp = JSON.parse(msg)
                                if (tmp.success) {
                                    $.gritter.add({
                                        title: 'Successo',
                                        text: 'Operazione eseguita con successo',
                                        class_name: 'gritter-color success'
                                    });
                                    location.reload();
                                }
                            });
                        },
                        className: 'btn-secondary eseguita'
                    },
                    {
                        text: 'Non eseguita',
                        action: function (e, dt, node, config) {
                            $.ajax({
                                method: "POST",
                                url: "/views/magazzino/listaSpedizioni/updateExecution.php",
                                data: {
                                    'id': table.row('.selected').data()[0],
                                    'eseguita': 0,
                                }
                            }).done(function (msg) {
                                var tmp = JSON.parse(msg)
                                if (tmp.success) {
                                    $.gritter.add({
                                        title: 'Successo',
                                        text: 'Operazione eseguita con successo',
                                        class_name: 'gritter-color success'
                                    });
                                    location.reload();
                                }
                            });
                        },
                        className: 'btn-secondary noteseguita'
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
