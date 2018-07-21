<!DOCTYPE html>
<html lang="en">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/libs/head.php'; ?>
<!-- Calendar -->
<link rel="stylesheet" type="text/css" href="/assets/lib/jquery.fullcalendar/fullcalendar.min.css"/>
<!-- Date Picker -->
<link rel="stylesheet" type="text/css" href="/assets/lib/datepicker/css/bootstrap-datepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/lib/datepicker/css/bootstrap-datepicker3.min.css"/>
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
        <form>
            <div class="row">
                <div class="col-sm-6">
                    <label>Numero Fattura</label>
                    <input name="numInvo" type="text" class="form-control"
                           value="<?php echo empty($numero) ? 1 : $numero + 1; ?>" required="true"/>
                </div>
                <div class="col-sm-6">
                    <label>Nomenclatura Fattura</label>
                    <input name="nameAddInvo" type="text" class="form-control" value=""/>
                </div>
                <div class="col-sm-8">
                    <select name="cli" class="form-control custom-select" required="true">
                        <option value="0">Seleziona Cliente</option>
                        <?php foreach ($clients as $value) { ?>
                            <option value="<?php echo $value["id"] ?>"><?php echo $value["nome"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label> Cliente esterno?</label>
                    <input name="extern" type="checkbox" value="si">
                </div>
                <div id="clientExtern" class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Nome</label>
                            <input name="name" type="text" class="form-control" required="true"/>
                        </div>
                        <div class="col-sm-6">
                            <label>Rag_Soc</label>
                            <input name="ragSoc" type="text" class="form-control" required="true"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Via</label>
                            <input name="via" type="text" class="form-control" required="true"/>
                        </div>
                        <div class="col-sm-4">
                            <label>Città</label>
                            <input name="city" type="text" class="form-control" required="true"/>
                        </div>
                        <div class="col-sm-4">
                            <label>PV</label>
                            <input name="pv" type="text" class="form-control" required="true"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label>CAP</label>
                            <input name="cap" type="text" class="form-control" required="true"/>
                        </div>
                        <div class="col-sm-4">
                            <label>P.IVA</label>
                            <input name="pIva" type="text" class="form-control" required="true"/>
                        </div>
                        <div class="col-sm-4">
                            <label>Cod.Fiscale</label>
                            <input name="codFisc" type="text" class="form-control" required="true"/>
                        </div>
                    </div>
                    <div id="product">
                        <div class="row">
                            <label class="col-sm-2 col-form-label">Servizio</label>
                            <label class="col-sm-2 col-form-label">Data</label>
                            <label class="col-sm-1 col-form-label">Dipendente</label>
                            <label class="col-sm-2 col-form-label">Costo</label>
                            <label class="col-sm-2 col-form-label">Quantità</label>
                            <label class="col-sm-1 col-form-label">Iva</label>
                        </div>
                        <div class="row">
                            <div id="repeat" class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input name="services[0][name]" type="text" placeholder="Nome servizo"
                                               class="form-control form-control-danger" required="true"/>
                                    </div>
                                    <div class="col-sm-2">
                                        <input name="services[0][date]" type="text" placeholder="Data"
                                               class="form-control datepicker" required="true"/>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="services[0][emplo]" class="form-control custom-select"
                                                required="true">
                                            <option value="0">Seleziona Dipendete</option>
                                            <?php foreach ($employees as $value) { ?>
                                                <option value="<?php echo $value["id"] ?>"><?php echo $value["nome"] . " " . $value["cognome"]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <input name="services[0][cost]" type="text" placeholder="Prezzo Unitario"
                                               class="form-control form-control-danger" required="true"/>
                                    </div>
                                    <div class="col-sm-2">
                                        <input name="services[0][quant]" type="text" placeholder="Quantità"
                                               class="form-control form-control-danger" required="true"/>
                                    </div>
                                    <div class="col-sm-2">
                                        <input name="services[0][iva]" type="checkbox"
                                               class="form-control form-control-danger" value="si"/>
                                    </div>
                                </div>
                            </div>
                            <div id="hidden"></div>
                            <div id="prepend" class="col-sm-1">
                                <button id="bRepeat" type="button" class="btn btn-primary">+</button>
                            </div>
                            <div class="col-sm-1">
                                <button id="bDelete" type="button" class="btn btn-primary">-</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1 offset-sm-10">
                            <button type="submit" class="btn btn-primary">Inserisci</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </form>
</div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/libs/head-js.php'; ?>
<!-- Date Picker -->
<script src="/assets/lib/datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="/assets/js/datepicker.it.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Instazio il primo e solo datepicker
        $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            language: 'it',
            weekStart: '1',
        })

        App.init();
        var table = $(".table").DataTable({buttons: []});

        $("input[name='name']").prop("disabled", true);
        $("input[name='ragSoc']").prop("disabled", true);
        $("input[name='via']").prop("disabled", true);
        $("input[name='city']").prop("disabled", true);
        $("input[name='pv']").prop("disabled", true);
        $("input[name='cap']").prop("disabled", true);
        $("input[name='pIva']").prop("disabled", true);
        $("input[name='codFisc']").prop("disabled", true);

        //+ e - per i servizi
        var i = 1;
        $("#bRepeat").click(function () {
            var repeat = $("#repeat").eq(0).clone();
            repeat.addClass("canc");
            repeat.find('input').each(function () {
                this.name = this.name.replace("services[0]", "services[" + i + "]");
            });
            repeat.find('select').each(function () {
                this.name = this.name.replace("services[0]", "services[" + i + "]");
            });

            $('#repeat').after(repeat);
            i++;

            //Per i nuovi datepicker
            $('.datepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
                language: 'it',
                weekStart: '1',
            })
        });

        $("#bDelete").click(function () {
            if (i != 1) {
                $(".canc")[0].remove();
                i--;
            }
        });

        $("select[name='cli']").change(function () {
            $.ajax({
                method: "POST",
                url: "/views/fatture/dataClients.php",
                data: {id: $(this).val()},
            }).done(function (data) {
                var res = JSON.parse(data);
                $("input[name='name']").val(res['client'][0].nome).prop("disabled", true);
                $("input[name='ragSoc']").val(res['client'][0].rag_soc).prop("disabled", true);
                $("input[name='via']").val(res['client'][0].via).prop("disabled", true);
                $("input[name='city']").val(res['client'][0].citta).prop("disabled", true);
                $("input[name='pv']").val(res['client'][0].provincia).prop("disabled", true);
                $("input[name='cap']").val(res['client'][0].cap).prop("disabled", true);
                $("input[name='pIva']").val(res['client'][0].p_iva).prop("disabled", true);
                $("input[name='codFisc']").val(res['client'][0].cod_fisc).prop("disabled", true);

                //DataTables ha aggiornato i metodi
                table.clear().draw();
                $("#hidden").children().remove();
                var count = 0;
                var result = res.sped.map(function (item) {
                    $("#hidden").append("<input type='hidden' name='idSped[" + count + "]' value='" + item.id + "'>");
                    count++;
                    var result = [];
                    result.push(item.id);
                    result.push(item.data);
                    result.push(item.data_scadenza);
                    result.push(item.num_bolla);
                    return result;
                });
                table.rows.add(result);
                table.draw();
            });
        });

        $('input[name="extern"]').change(function () {
            if (this.checked) {
                $('select[name="cli"]').val("").prop("disabled", true);
                $("input[name='name']").val("").prop("disabled", false);
                $("input[name='ragSoc']").val("").prop("disabled", false);
                $("input[name='via']").val("").prop("disabled", false);
                $("input[name='city']").val("").prop("disabled", false);
                $("input[name='pv']").val("").prop("disabled", false);
                $("input[name='cap']").val("").prop("disabled", false);
                $("input[name='pIva']").val("").prop("disabled", false);
                $("input[name='codFisc']").val("").prop("disabled", false);
            } else {
                $('select[name="cli"]').prop("disabled", false);
                $("input[name='name']").prop("disabled", true);
                $("input[name='ragSoc']").prop("disabled", true);
                $("input[name='via']").prop("disabled", true);
                $("input[name='city']").prop("disabled", true);
                $("input[name='pv']").prop("disabled", true);
                $("input[name='cap']").prop("disabled", true);
                $("input[name='pIva']").prop("disabled", true);
                $("input[name='codFisc']").prop("disabled", true);
            }
        });

        $("form").submit(function () {
            $.ajax({
                method: "POST",
                url: "/views/fatture/createInvo.php",
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
                    } else {
                        $.gritter.add({
                            title: 'Errore',
                            text: msg,
                            class_name: 'gritter-color danger'
                        });
                    }
                });
            return false;
        });
    });
</script>
</body>
</html>
