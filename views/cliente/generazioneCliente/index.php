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
<?php require ($_SERVER['DOCUMENT_ROOT'] . '/views/default/navbar.php'); ?>
<div class="mai-wrapper">
    <div class="main-content container">
        <form>
            <div class="row">
                <div class="col-sm-6">
                    <label>Nome</label>
                    <input name="name" type="text" class="form-control" required="true"/>
                </div>
                <div class="col-sm-6">
                    <label>Rag_Soc</label>
                    <input name="ragSoc" type="text" class="form-control" required="true"/>
                </div>
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
                <div class="col-sm-4">
                    <label class="col-form-label">Username</label>
                    <input name="user" type="text" placeholder="Username" class="form-control form-control-danger" required="true">
                </div>
                <div class="col-sm-4">
                    <label class="col-form-label">Password</label>
                    <input name="pwd" type="text" placeholder="Password" class="form-control form-control-danger" required="true">
                </div>
                <div class="col-sm-4">
                    <label class="col-form-label">E-mail</label>
                    <input name="mail" type="text" placeholder="E-mail" class="form-control form-control-danger" required="true">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-1 offset-sm-11">
                    <button type="submit" class="btn btn-primary">Inserisci</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/libs/head-js.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        App.init();
        $("form").submit(function(){
            $.ajax({
                method: "POST",
                url: "/views/cliente/generazioneCliente/insertClient.php",
                data: $(this).serialize(),
            })
                .done(function( msg ) {
                    if(msg == "OK"){
                        $.gritter.add({
                            title: 'Successo',
                            text: 'Inserimento avvenuto con successo',
                            class_name: 'gritter-color success'
                        });
                        $("input").val("");
                        $("select").val(0);
                        $("select[name='prodotto']").val("NP");
                    }else{
                        $.gritter.add({
                            title: 'Errore',
                            text: 'Risposta dal server non valida.',
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
