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
            frm.find('[name="utilisateur[' + i + ']"]').val(result[i]);
        }
    }});
}

// Fonction de mise en session du user éditer en cours
function resetEditItem() {
    var currentEditItem =  sessionStorage.setItem("currentEditItem",null)
    console.log(currentEditItem);
}

// Fonction de chargement du bloc de gestion gmail
function ajaxGenerateEmail() {
    var currentEditItem = sessionStorage.getItem("currentEditItem");
    urlajax ="/ajax/generate/email/"+currentEditItem;
    $.ajax({url:urlajax,success:function(result){
        var i;
        var textToAppend = '';
        for (i in result) {
            textToAppend += '<div class="form-group font_exo_2" onclick="showhide();"><label class="font_exo_2"><input class="font_exo_2" type="radio" name="genEmail" value="'+result[i]+'">' +result[i]+'</label></div>';
        }
        textToAppend += '<div class="form-group font_exo_2" onclick="showhide();"><label class="font_exo_2"><input type="radio" id="otherMail" name="genEmail">Autre</label></div>';
        textToAppend += '<div class="form-group font_exo_2"><div class="input-box hide actionPartInput" id="otherEmail" ><input class="form-control font_exo_2 " autofocus="autofocus" type="text" name="autreEmail"><span class="unit">@aramisauto.com</span></div></div>';
        textToAppend += '<button onclick="ajaxCreateGmailviaAPI();" class="btn btn-xs btn-warning align_right">Créer sur Gmail</button>';
        document.getElementById("actionPart").innerHTML = textToAppend;
    }});
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

