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
<?php require($_SERVER['DOCUMENT_ROOT'] . '/views/default/navbar.php'); ?>
<div class="mai-wrapper">
    <div class="main-content container">
        <form>
            <div class="row">
                <div class="col-sm-6">
                    <label class="col-form-label">Nome Categoria</label>
                    <input name="nome" type="text" placeholder="Nome" class="form-control form-control-danger" required>
                </div>
                <div class="col-sm-6">
                    <label class="col-form-label">Descrizione</label>
                    <input name="descrizione" type="text" placeholder="Descrizione"
                           class="form-control form-control-danger" required>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-1 offset-sm-11">
                    <button type="submit" class="btn btn-primary">Inserisci</button>
                </div>
            </div>
        </form>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">Lista Categorie</div>
                    <div class="panel-body" style="padding-bottom: 20px;">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Descrizione</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($categorie as $value) { ?>
                                <tr>
                                    <td><?php echo $value['id']; ?></td>
                                    <td><?php echo $value['nome']; ?></td>
                                    <td><?php echo $value['descrizione']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modale -->
        <div id="md-default" tabindex="-1" role="dialog" class="modal fade" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <label class="col-form-label">Modificare Categoria</label>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <label class="col-form-label">Nome</label>
                            <input id="name" type="text" class="form-control form-control-danger">
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label">Descrizione</label>
                            <input id="desc" type="text" class="form-control form-control-danger">
                        </div>
                        <div class="text-center">
                            <div class="mt-6">
                                <button id="bModCat" type="button" data-dismiss="modal"
                                        class="btn btn-sm btn-space btn-primary">Conferma
                                </button>
                            </div>
                        </div>
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
        $("form").submit(function () {
            $.ajax({
                method: "POST",
                url: "/views/magazzino/categorie/insertCategory.php",
                data: $(this).serialize(),
            })
                .done(function (msg) {
                    if (msg == "OK") {
                        $.gritter.add({
                            title: 'Successo',
                            text: 'Inserimento avvenuto con successo',
                            class_name: 'gritter-color success'
                        });
                        $("input").val("");
                    } else {
                        $.gritter.add({
                            title: 'Errore',
                            text: 'Risposta dal server non valida.',
                            class_name: 'gritter-color danger'
                        });
                    }
                });
        });
        var table = $(".table").DataTable(
            {
                buttons: [
                    {
                        text: 'Modifica Categoria',
                        action: function (e, dt, node, config) {
                            if ($('.table .selected').length > 0) {
                                $('#md-default').modal();
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
        $('.table tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        $("#bModCat").click(function () {
            $.ajax({
                method: "POST",
                url: "/views/magazzino/categorie/modCategory.php",
                data: {
                    id: table.row('.selected').data()[0],
                    nome: $("#name").val(),
                    desc: $("#desc").val(),
                },
            }).done(function (msg) {
                location.reload();
            });
        });
    });
</script>
</body>
</html>
