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
                <form>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="col-form-label">Nome</label>
                            <input name="name" type="text" placeholder="Nome" class="form-control form-control-danger"
                                   required="true">
                        </div>
                        <div class="col-sm-4">
                            <label class="col-form-label">Descrizione</label>
                            <input name="desc" type="text" placeholder="Descrizione"
                                   class="form-control form-control-danger" required="true">
                        </div>
                        <div class="col-sm-4">
                            <label class="col-form-label">Indirizzo</label>
                            <input name="street" type="text" placeholder="Indirizzo"
                                   class="form-control form-control-danger" required="true">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1 offset-sm-11">
                            <button type="submit" class="btn btn-primary">Inserisci</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12">
                <select name="mag" class="form-control custom-select" required="true">
                    <option value="0">Seleziona Magazzino</option>
                    <?php foreach ($magazzini as $value) { ?>
                        <option value="<?php echo $value["id"] ?>"><?php echo $value["n"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div id="np" class="offset-sm-3 col-sm-6">
                <br>
                <h2>Nessun Prodotto in questo Magazzino</h2>
            </div>
            <div id="data" class="col-sm-12">
                <br>
                <div class="panel panel-default panel-table" style="display:none">
                    <div class="panel-heading">Lista Prodotti in Magazzino</div>
                    <div class="panel-body" style="padding-bottom: 20px">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Quantità</th>
                            </tr>
                            </thead>
                            <tbody id="tb">
                            </tbody>
                        </table>
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
        var table = null;
        $("select[name='mag']").change(function () {
            $.ajax({
                method: "POST",
                url: "/views/magazzino/spedizioni/productFromMag.php",
                data: {source: $(this).val(),}
            })
                .done(function (msg) {
                    if (table != null) {
                        table.destroy();
                    }
                    $(".del").remove();
                    var data = JSON.parse(msg);
                    if (data.length == 0) {
                        $("#np").show();
                        $("#data").hide();
                    } else {
                        $("#np").hide();
                        $("#data").show();
                    }
                    $.each(data, function (index, jsonObject) {
                        var head = "<tr class='del'>";
                        var foot = "</tr>";
                        $("#tb").append(head + "<td>" + jsonObject.id + "</td>" + "<td>" + jsonObject.nome + "</td>" + "<td>" + jsonObject.quant + "</td>" + foot);
                        $(".panel").css("display", "block");
                    });
                    table = $(".table").DataTable(
                        {
                            buttons: []
                        });
                });
        });
        $("form").submit(function () {
            $.ajax({
                method: "POST",
                url: "/views/cliente/creazioneMag/insertMag.php",
                data: $(this).serialize(),
            })
                .done(function (msg) {
                    console.log(msg);
                    if (msg == "OK") {
                        $.gritter.add({
                            title: 'Successo',
                            text: 'Inserimento avvenuto con successo',
                            class_name: 'gritter-color success'
                        });
                        $("input").val("");
                        $("select").val(0);
                    } else {
                        $.gritter.add({
                            title: 'Errore',
                            text: 'Risposta dal server non valida.',
                            class_name: 'gritter-color danger'
                        });
                    }
                });
        });
    });
</script>
</body>
</html>
