// Fonction d'ajout de champ groupe salesforce
function addGroupeField()
{
    var currentIteration = localStorage.getItem("currentIteration");
    var listeOfOptions = localStorage.getItem("listeOfOptions");
    var newIteration = parseInt(currentIteration) + parseInt('1');
    var addfield = '<div class="form-group" id="salesforceTerritories_'+newIteration+'">';
    addfield += '<label class="col-sm-3 control-label align_right font_exo_2" for="salesforce_territory'+newIteration+'">Terrirore SF '+newIteration+'</label>';
    addfield += '<div class="col-sm-8">';
    addfield += '<select name="salesforce[territory'+newIteration+']" id="salesforce_territory'+newIteration+'" class="form-control">';
    addfield += listeOfOptions;
    addfield += '</select>';
    addfield += '</div>';
    addfield += '</div>';
    localStorage.setItem("currentIteration", newIteration);
    $('#midEditForm').append(addfield)
}

// Fonction de chargement Standard Edit
function ajaxServiceEdit(editItem)
{
    $('#mainEditForm').addClass('hide').removeClass('show');
    $('#midEditForm').addClass('hide').removeClass('show');
    $('#bottomEditForm').addClass('hide').removeClass('show');
    $('#loading').addClass('show').removeClass('hide');
    document.getElementById("midEditForm").innerHTML = '';
    document.getElementById("bottomEditForm").innerHTML = '';
    var button = '<div class="form-group text-center" id="buttonSalesforceAdd"><button type="button" class="btn btn-info" onclick="addGroupeField();">Ajouter un Territoire Salesforce</button></div>';
    urlajax ="/ajax/service/get/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        var frm = $("#form-edit");
        var i = 0;
        for (i in result) {
            frm.find('[name="service[' + i + ']"]').val(result[i]);
        }
        urlajax ="/ajax/get/salesforce/territory_service/"+editItem;
        $.ajax({url:urlajax,success:function(result){
            var i = 0;
            for (i in result) {
                console.log(result[i].groupeName);
                addGroupeField();
                var z = parseInt(i) + parseInt('1');
                console.log(z);
                document.getElementById("salesforce_territory"+z).value = result[i].id;
            }
            $('#loading').addClass('hide').removeClass('show');
            $('#bottomEditForm').append(button).addClass('show').removeClass('hide');
            $('#midEditForm').addClass('show').removeClass('hide');
            $('#mainEditForm').addClass('show').removeClass('hide');
            localStorage.setItem("currentIteration", '0');
        }});
    }});
}



