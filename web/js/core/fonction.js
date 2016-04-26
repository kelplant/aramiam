// Fonction d'ajout de champ groupe salesforce
function addSfGroupeField()
{
    var currentIteration = localStorage.getItem("currentIteration");
    var listeOfOptions = localStorage.getItem("listeOfOptions");
    var newIteration = parseInt(currentIteration) + parseInt('1');
    var addfield = '<div class="form-group" id="salesforceGroupes_'+newIteration+'">';
    addfield += '<label class="col-sm-4 control-label align_right font_exo_2" for="salesforce_groupe'+newIteration+'">Groupe SF '+newIteration+'</label>';
    addfield += '<div class="col-sm-7">';
    addfield += '<select name="salesforce[groupe'+newIteration+']" id="salesforce_groupe'+newIteration+'" class="form-control">';
    addfield += listeOfOptions;
    addfield += '</select>';
    addfield += '</div>';
    addfield += '<div class="col-sm-1" style="padding-top: 0.5%">';
    addfield += '<button type="button" class="btn btn-default btn-xs" onclick="unsetSFField('+newIteration+');" aria-label="Left Align">';
    addfield += '<span class="glyphicon glyphicon-remove btn-xs" aria-hidden="true"></span>';
    addfield += '</button>';
    addfield += '</div>';
    addfield += '</div>';
    localStorage.setItem("currentIteration", newIteration);
    $('#midSFEditForm').append(addfield)
}

// Fonction de chargement du bloc salesforce
function ajaxGenerateSalesforce()
{
    $('#createActionWindowsPart').addClass('hide').removeClass('show');
    $('#createActionAramisPart').addClass('hide').removeClass('show');
    $('#createActionSalesforcePart').addClass('hide').removeClass('show');
    $('#midSFEditForm').addClass('hide').removeClass('show');
    $('#bottomSFEditForm').addClass('hide').removeClass('show');
    $('#windowsToggle').removeClass('active');
    $('#aramisToggle').removeClass('active');
    $('#salesforceToggle').addClass('active');
    $('#loadingRight').removeClass('hide').addClass('show');
    document.getElementById("createActionSalesforcePart").innerHTML = '<div class="hide" id="midSFEditForm"></div><div class="hide" id="bottomSFEditForm"></div>';
    document.getElementById("createActionWindowsPart").innerHTML = '<div class="hide" id="midADEditForm"></div><div class="hide" id="bottomADEditForm"></div>';
    var editItem = localStorage.getItem("currentFonctionEdit");
    var checkBoxServiceCloud = '<div class="form-group">';
    checkBoxServiceCloud += '<label class="col-sm-4 control-label align_right font_exo_2" for="salesforce_service_cloud_acces">Service Cloud</label>';
    checkBoxServiceCloud += '<div class="col-sm-8">';
    checkBoxServiceCloud += '<input type="checkbox" class="form-control font_exo_2" name="salesforce[service_cloud_acces]" id="salesforce_service_cloud_acces">';
    checkBoxServiceCloud += '</div>';
    checkBoxServiceCloud += '</div>';
    var button = '<div class="form-group text-center" id="buttonSalesforceAdd"><button type="button" class="btn btn-info" onclick="addSfGroupeField();">Ajouter un Groupe Salesforce</button></div>';
    document.getElementById("midSFEditForm").innerHTML = checkBoxServiceCloud;
    urlajax ="/ajax/get/salesforce/service_cloud/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        if (result != '' && result['status'] == true) {
            document.getElementById("salesforce_service_cloud_acces").checked = true;
        } else {
            document.getElementById("salesforce_service_cloud_acces").checked = false;
        }
        urlajax ="/ajax/get/salesforce/groupe_fonction/"+editItem;
        $.ajax({url:urlajax,success:function(result){
            var i = 0;
            for (i in result) {
                addSfGroupeField();
                var z = parseInt(i) + parseInt('1');
                document.getElementById("salesforce_groupe"+z).value = result[i].id;
            }
            $('#loadingRight').addClass('hide').removeClass('show');
            $('#bottomSFEditForm').append(button).addClass('show').removeClass('hide');
            $('#midSFEditForm').addClass('show').removeClass('hide');
            $('#createActionSalesforcePart').addClass('show').removeClass('hide');
            localStorage.setItem("currentIteration", result.length);
        }});
    }});
}


// Fonction Unset territoire
function unsetSFField(fieldId)
{
    document.getElementById('salesforceGroupes_'+fieldId).innerHTML = '';
}

// Fonction d'ajout de champ groupe active directory
function addADGroupeField()
{
    var currentADIteration = localStorage.getItem("currentADIteration");
    var listeOfADOptions = localStorage.getItem("listeOfADOptions");
    var newADIteration = parseInt(currentADIteration) + parseInt('1');
    var addfield = '<div class="form-group" id="activedirectoryGroupes_'+newADIteration+'">';
    addfield += '<label class="col-sm-4 control-label align_right font_exo_2" for="activedirectory_groupe'+newADIteration+'">Groupe AD '+newADIteration+'</label>';
    addfield += '<div class="col-sm-7">';
    addfield += '<select name="activedirectory[groupe'+newADIteration+']" id="activedirectory_groupe'+newADIteration+'" class="form-control">';
    addfield += listeOfADOptions;
    addfield += '</select>';
    addfield += '</div>';
    addfield += '<div class="col-sm-1" style="padding-top: 0.5%">';
    addfield += '<button type="button" class="btn btn-default btn-xs" onclick="unsetADField('+newADIteration+');" aria-label="Left Align">';
    addfield += '<span class="glyphicon glyphicon-remove btn-xs" aria-hidden="true"></span>';
    addfield += '</button>';
    addfield += '</div>';
    addfield += '</div>';
    localStorage.setItem("currentADIteration", newADIteration);
    $('#midADEditForm').append(addfield);
}

// Fonction de chargement du bloc active directory
function ajaxGenerateWindows() {
    $('#createActionWindowsPart').addClass('hide').removeClass('show');
    $('#createActionAramisPart').addClass('hide').removeClass('show');
    $('#createActionSalesforcePart').addClass('hide').removeClass('show');
    $('#midADEditForm').addClass('hide').removeClass('show');
    $('#bottomADEditForm').addClass('hide').removeClass('show');
    $('#windowsToggle').addClass('active');
    $('#aramisToggle').removeClass('active');
    $('#salesforceToggle').removeClass('active');
    $('#loadingRight').removeClass('hide').addClass('show');
    document.getElementById("createActionSalesforcePart").innerHTML = '<div class="hide" id="midSFEditForm"></div><div class="hide" id="bottomSFEditForm"></div>';
    document.getElementById("createActionWindowsPart").innerHTML = '<div class="hide" id="midADEditForm"></div><div class="hide" id="bottomADEditForm"></div>';
    var editItem = localStorage.getItem("currentFonctionEdit");
    var button = '<div class="form-group text-center" id="buttonSalesforceAdd"><button type="button" class="btn btn-info" onclick="addADGroupeField();">Ajouter un Groupe Active Directory</button></div>';
    urlajax = "/ajax/get/active_directory/group_fonction/" + editItem;
    $.ajax({
        url: urlajax, success: function (result) {
            var i = 0;
            for (i in result) {
                addADGroupeField();
                var z = parseInt(i) + parseInt('1');
                document.getElementById("activedirectory_groupe" + z).value = parseInt(result[i].id);
            }
            $('#loadingRight').addClass('hide').removeClass('show');
            $('#midADEditForm').addClass('show').removeClass('hide');
            $('#bottomADEditForm').append(button).addClass('show').removeClass('hide');
            localStorage.setItem("currentADIteration", 0);
            $('#createActionWindowsPart').addClass('show').removeClass('hide');
        }
    });
}

// Fonction Unset territoire
function unsetADField(fieldId)
{
    document.getElementById('activedirectoryGroupes_'+fieldId).innerHTML = '';
}

// Fonction de chargement Standard Edit
function ajaxFonctionEdit(editItem)
{
    $('#mainEditForm').addClass('hide').removeClass('show');
    $('#midEditForm').addClass('hide').removeClass('show');
    $('#bottomEditForm').addClass('hide').removeClass('show');
    $('#loading').addClass('show').removeClass('hide');
    $('#windowsToggle').removeClass('active');
    $('#aramisToggle').removeClass('active');
    $('#salesforceToggle').removeClass('active');
    urlajax ="/ajax/fonction/get/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        var frm = $("#form-edit");
        var i = 0;
        for (i in result) {
            frm.find('[name="fonction[' + i + ']"]').val(result[i]);
        }
        $('#loading').addClass('hide').removeClass('show');
        $('#mainEditForm').addClass('show').removeClass('hide');
        localStorage.setItem("currentFonctionEdit", editItem);
    }});
}