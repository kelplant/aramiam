// Fonction d'ajout de champ groupe salesforce
function addGroupeField()
{
    var currentIteration = localStorage.getItem("currentIteration");
    var listeOfOptions = localStorage.getItem("listeOfOptions");
    var newIteration = parseInt(currentIteration) + parseInt('1');
    var addfield = '<div class="form-group" id="salesforceTerritories_'+newIteration+'">';
    addfield += '<label class="col-sm-4 control-label align_right font_exo_2" for="salesforce_territory'+newIteration+'">Terrirore SF '+newIteration+'</label>';
    addfield += '<div class="col-sm-7">';
    addfield += '<select name="salesforce[territory'+newIteration+']" id="salesforce_territory'+newIteration+'" class="form-control">';
    addfield += listeOfOptions;
    addfield += '</select>';
    addfield += '</div>';
    addfield += '<div class="col-sm-1" style="padding-top: 0.5%">';
    addfield += '<button type="button" class="btn btn-default btn-xs" onclick="unsetField('+newIteration+');" aria-label="Left Align">';
    addfield += '<span class="glyphicon glyphicon-remove btn-xs" aria-hidden="true"></span>';
    addfield += '</button>';
    addfield += '</div>';
    addfield += '</div>';
    localStorage.setItem("currentIteration", newIteration);
    $('#midEditForm').append(addfield)
}

// Fonction Unset territoire
function unsetField(fieldId)
{
    document.getElementById('salesforceTerritories_'+fieldId).innerHTML = '';
}


// Fonction de chargement Standard Edit
function ajaxServiceEdit(editItem)
{
    $('#mainEditForm').addClass('hide').removeClass('show');
    $('#midEditForm').addClass('hide').removeClass('show');
    $('#bottomEditForm').addClass('hide').removeClass('show');
    $('#loading').addClass('show').removeClass('hide');
    $('#windowsToggle').removeClass('active');
    $('#aramisToggle').removeClass('active');
    $('#salesforceToggle').removeClass('active');
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
        $('#loading').addClass('hide').removeClass('show');
        $('#mainEditForm').addClass('show').removeClass('hide');
        localStorage.setItem("currentServiceEdit", editItem);
    }});
}

// Fonction de chargement du bloc salesforce
function ajaxGenerateSalesforce()
{
    $('#createActionWindowsPart').addClass('hide').removeClass('show');
    $('#createActionAramisPart').addClass('hide').removeClass('show');
    $('#createActionSalesforcePart').addClass('hide').removeClass('show');
    $('#midEditForm').addClass('hide').removeClass('show');
    $('#bottomEditForm').addClass('hide').removeClass('show');
    $('#windowsToggle').removeClass('active');
    $('#aramisToggle').removeClass('active');
    $('#salesforceToggle').addClass('active');
    $('#loadingRight').removeClass('hide').addClass('show');
    document.getElementById("midEditForm").innerHTML = '';
    document.getElementById("bottomEditForm").innerHTML = '';
    var editItem = localStorage.getItem("currentServiceEdit");
    var button = '<div class="form-group text-center" id="buttonSalesforceAdd"><button type="button" class="btn btn-info" onclick="addGroupeField();">Ajouter un Territoire Salesforce</button></div>';

    urlajax ="/ajax/get/salesforce/territory_service/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        var i = 0;
        for (i in result) {
            addGroupeField();
            var z = parseInt(i) + parseInt('1');
            document.getElementById("salesforce_territory"+z).value = result[i].id;
        }
        $('#loadingRight').addClass('hide').removeClass('show');
        $('#bottomEditForm').append(button).addClass('show').removeClass('hide');
        $('#midEditForm').addClass('show').removeClass('hide');
        $('#mainEditForm').addClass('show').removeClass('hide');
        $('#createActionSalesforcePart').addClass('show').removeClass('hide');
        localStorage.setItem("currentIteration", result.length);
    }});
}


