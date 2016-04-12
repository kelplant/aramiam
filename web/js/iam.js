/**
 * Created by Xavier on 11/04/2016.
 */

// Fonction de chargement d'un Service pendant Edit
function ajaxServiceEdit(editItem) {
    urlajax ="/ajax/service/get/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        var frm = $("#form-edit");
        var i;
        for (i in result) {
            frm.find('[name="service[' + i + ']"]').val(result[i]);
        }
    }});
}

// Fonction de chargement d'une Agence pendant Edit
function ajaxEdit(editItem) {
    urlajax ="/ajax/agence/get/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        var frm = $("#form-edit");
        var i;
        for (i in result) {
            frm.find('[name="agence[' + i + ']"]').val(result[i]);
        }
    }});
}

// Fonction de chargement d'une Fonction pendant Edit
function ajaxFonctionEdit(editItem) {
    urlajax ="/ajax/fonction/get/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        var frm = $("#form-edit");
        var i;
        for (i in result) {
            frm.find('[name="fonction[' + i + ']"]').val(result[i]);
        }
    }});
}

// Fonction de chargement d'une EntiteHolding pendant Edit
function ajaxEntiteHoldingEdit(editItem) {
    urlajax ="/ajax/entite_holding/get/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        var frm = $("#form-edit");
        var i;
        for (i in result) {
            frm.find('[name="entite_holding[' + i + ']"]').val(result[i]);
        }
    }});
}

// Fonction de chargement d'un Candidat pendant Edit
function ajaxCandidatEdit(editItem) {
    urlajax ="/ajax/candidat/get/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        var frm = $("#form-edit");
        var i;
        for (i in result) {
            if (i == 'predecesseur')
            {
                sessionStorage.setItem("currentPredecesseurId",result[i])
            }
            frm.find('[name="candidat[' + i + ']"]').val(result[i]);
        }
    }});
}

// Fonction de chargement d'un Utilisateur pendant Edit
function ajaxUtilisateurEdit(editItem) {
    urlajax ="/ajax/utilisateur/get/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        var frm = $("#form-edit");
        var i;
        for (i in result) {
            if (i == 'id')
            {
                sessionStorage.setItem("currentEditItem",result[i])
            }
            if (i == 'name')
            {
                sessionStorage.setItem("currentName",result[i])
            }
            if (i == 'surname')
            {
                sessionStorage.setItem("currentSurname",result[i])
            }
            if (i == 'agence')
            {
                sessionStorage.setItem("agence",result[i])
            }
            if (i == 'fonction')
            {
                sessionStorage.setItem("fonction",result[i])
            }
            frm.find('[name="utilisateur[' + i + ']"]').val(result[i]);
        }
    }});
}

// Fonction de mise en session du user éditer en cours
function resetEditItem() {
    sessionStorage.setItem("currentEditItem",null)
    sessionStorage.setItem("currentName",null)
    sessionStorage.setItem("currentSurname",null)
    sessionStorage.setItem("agence",null)
    sessionStorage.setItem("fonction",null)
}

// Fonction de chargement du bloc de gestion gmail
function ajaxGenerateEmail() {
    var currentEditItem = sessionStorage.getItem("currentEditItem");
    urlajax ="/ajax/generate/email/"+currentEditItem;
    $.ajax({url:urlajax,success:function(result){
        var i;
        var textToAppend = '';
        for (i in result) {
            textToAppend += '<div class="form-group font_exo_2" onclick="showhide();"><label class="font_exo_2 col-sm-3"><input class="font_exo_2 col-sm-2" type="radio" name="genEmail" value="'+result[i]+'">' +result[i]+'</label></div>';
        }
        document.getElementById("actionGmailList").innerHTML = textToAppend;
        $('#actionGmailPart').addClass('show');
        $('#odigoToggle').removeClass('active');
        $('#gmailToggle').addClass('active');
        $('#actionGmailPart').removeClass('hide');
        $('#actionOdigoPart').removeClass('show');
        $('#actionOdigoPart').addClass('hide');
    }});
}

function getMeElem(elem)
{
    var liste;
    liste = document.getElementById(elem);
    return liste.options[liste.selectedIndex].value;
}

// Fonction de chargement du bloc de gestion gmail
function ajaxGenerateOdigo() {
    $('#actionGmailPart').addClass('hide');
    $('#gmailToggle').removeClass('active');
    $('#odigoToggle').addClass('active');
    $('#actionGmailPart').removeClass('show');
    $('#actionOdigoPart').removeClass('hide');
    var agence = sessionStorage.getItem("agence");
    var fonction = sessionStorage.getItem("fonction");
    var nom = sessionStorage.getItem("currentName").toLowerCase().replace(' ', '').replace('-', '');
    var prenom = sessionStorage.getItem("currentSurname").substring(0,3).toLowerCase();
    document.getElementById("prosodie_identifiant").value = prenom+nom;
    var currentEditItem = sessionStorage.getItem("currentEditItem");
    urlajax = "/ajax/generate/odigo/" + agence + "/" + fonction;
    $.ajax({
        url: urlajax, success: function (result) {
            var i;
            var prosodieListe = '<label class="font_exo_2 col-sm-4">Numéro Prosodie:';
            prosodieListe += '<select name="prosodie[numProsodie]" id="prosodie_numProsodie" class="form-control">';
            for (i in result) {
                prosodieListe += '<option value="'+result[i]+'">'+result[i]+'</option>';
            }
            prosodieListe += '</select>';
            prosodieListe += '</label>';
            document.getElementById("prosodieListe").innerHTML = prosodieListe;
        }
    });
    urlajax = "/ajax/generate/orange/" + agence;
    $.ajax({
        url: urlajax, success: function (result) {
            var i;
            var orangeListe = '<label class="font_exo_2 col-sm-4">Numéro Prosodie:';
            orangeListe += '<select name="prosodie[numOrange]" id="prosodie_numOrange" class="form-control">';
            for (i in result) {
                orangeListe += '<option value="'+result[i]+'">'+result[i]+'</option>';
            }
            orangeListe += '</select>';
            orangeListe += '</label>';
            document.getElementById("orangeliste").innerHTML = orangeListe;
        }
    });
}
// Fonction d'affichage du champ autre email pendant création gmail
function showhide() {
    if($('#otherMail').prop('checked')) {
        $('#otherEmail').addClass('show');
        $('#otherEmail').removeClass('hide');
    } else {
        $('#otherEmail').addClass('hide');
        $('#otherEmail').removeClass('show');
    }
}

// Fonction de lien vers le predecesseur
function setViewUtilisateur(){
    var currentEditItem = sessionStorage.getItem("currentPredecesseurId");
    sessionStorage.setItem("currentEditItem",currentEditItem);
    window.location = "/admin/utilisateur?isArchived=0";
}

function ajaxCreateGmailviaAPI() {
    var currentEditItem = sessionStorage.getItem("currentEditItem");
}