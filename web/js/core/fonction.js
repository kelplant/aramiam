// Fonction d'ajout de champ groupe salesforce
function addGroupeField()
{
    var currentIteration = localStorage.getItem("currentIteration");
    var listeOfOptions = localStorage.getItem("listeOfOptions");
    var newIteration = parseInt(currentIteration) + parseInt('1');
    var addfield = '<div class="form-group" id="salesforceGroupes_'+newIteration+'">';
    addfield += '<label class="col-sm-3 control-label align_right font_exo_2" for="salesforce_groupe'+newIteration+'">Groupe SF '+newIteration+'</label>';
    addfield += '<div class="col-sm-8">';
    addfield += '<select name="salesforce[groupe'+newIteration+']" id="salesforce_groupe'+newIteration+'" class="form-control">';
    addfield += listeOfOptions;
    addfield += '</select>';
    addfield += '</div>';
    addfield += '</div>';
    localStorage.setItem("currentIteration", newIteration);
    $('#BottomEditForm').append(addfield)
}

// Fonction de chargement Standard Edit
function ajaxFonctionEdit(editItem)
{
    $('#mainEditForm').addClass('hide').removeClass('show');
    $('#BottomEditForm').addClass('hide').removeClass('show');
    $('#loading').addClass('show').removeClass('hide');
    document.getElementById("BottomEditForm").innerHTML = '';
    var button = '<div class="form-group text-center" id="buttonSalesforceAdd"><button type="button" class="btn btn-info" onclick="addGroupeField();">Ajouter un Groupe Salesforce</button></div>';
    urlajax ="/ajax/fonction/get/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        var frm = $("#form-edit");
        var i = 0;
        for (i in result) {
            frm.find('[name="fonction[' + i + ']"]').val(result[i]);
        }
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
                    console.log(result[i].groupeName);
                    addGroupeField();
                    var z = parseInt(i) + parseInt('1');
                    console.log(z);
                    document.getElementById("salesforce_groupe"+z).value = result[i].id;
                }
                $('#loading').addClass('hide').removeClass('show');
                $('#BottomEditForm').append(button).addClass('show').removeClass('hide')
                $('#mainEditForm').addClass('show').removeClass('hide');
                localStorage.setItem("currentIteration", '0');
            }});
        }});
    }});
}