<script>

// aqui tem os scripts basicos. 
    var keyColumn = '<?php echo ($keyColumn); ?>';
    var descColumn = '<?php echo ($descColumn); ?>';
    var retrieveFields = <?php echo ($retrieveFields); ?>;
    var plMainController = '<?php echo ($controller) ?>';

<?php echo ($javascript); ?>

// funcao da toolbar
    function onGridToolbarPressedPL(bPressed, dData) {

        

        if (bPressed == 'clear') {
            plresetData();
        }

        if (bPressed == 'openMaint') {
            window.open('main/redirect/' + plMainController, '_newtab');
        }
    }

    $('#myPLGridx').w2grid(varMySpecificPL);
//$('#filtersPL').width('700px');


    w2ui.specificPLPrc.on('dblClick', function (event) {
        plselectData(event.recid);
    });



    $('#modalPicklistTitle').html("<?php echo ($title); ?>");


// retorna os dadosselecionados.!
    function plselectData(recid) {
        var record = w2ui["specificPLPrc"].get(recid);

        // com o custom callback dah pra chamar qq funcao de selecao. Isso para evitar problemas
        // em telas que tem mais niveis, e tem picklist em todos!! Funcina que eh um charme!!!
        //if (typeof picklistCallBack === "function") {
        picklistCallBack(record.recid, record.description, record);
        SBSModalVar.close()

        //} else {
    }

    w2ui["specificPLPrc"].boxToLock = '#csplid';
            //console.log(w2ui["specificPLPrc"]);

            setTimeout(function () {
                onGridToolbarPressedPL('retrieve');
            }, 200);
</script>
<div id='csplid'>

   
    <div class="row" style="padding-top: 5px;padding-left: 10px;padding-right: 10px;">
        <div id="myPLGridx" style="height: 480px;background-color: #003399;width: 100%"> </div>
    </div>
</div>