// Fonction de chargement Standard Edit
function ajaxUtilisateurEdit(url, editItem)
{
    $('#mainEditForm').addClass('hide').removeClass('show');
    $('#loadingMain').addClass('show').removeClass('hide');
    $('#gmailToggle').removeClass('active');
    $('#odigoToggle').removeClass('active');
    $('#windowsToggle').removeClass('active');
    $('#aramisToggle').removeClass('active');
    $('#salesforceToggle').removeClass('active');
    $('#createActionWindowsPart').addClass('hide').removeClass('show');
    $('#createActionAramisPart').addClass('hide').removeClass('show');
    $('#createActionOdigoPart').addClass('hide').removeClass('show');
    $('#createActionGmailPart').addClass('hide').removeClass('show');
    $('#createActionSalesforcePart').addClass('hide').removeClass('show');
    $('#createActionSalesforcePartEdit').addClass('hide').removeClass('show');
    $('#createActionSalesforcePartNew').addClass('hide').removeClass('show');
    localStorage.setItem("emailState", null);
    localStorage.setItem("ableToShowOdigo", null);
    urlajax ="/ajax/"+url+"/get/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        var frm = $("#form-edit");
        var i;
        for (i in result) {
            if (i == 'id') {
                localStorage.setItem("currentEditItem", result[i])
            }
            if (i == 'name') {
                localStorage.setItem("currentName", result[i])
            }
            if (i == 'surname') {
                localStorage.setItem("currentSurname", result[i])
            }
            if (i == 'service') {
                localStorage.setItem("service", result[i])
            }
            if (i == 'fonction') {
                localStorage.setItem("fonction", result[i])
            }
            if (i == 'isCreateInGmail') {
                localStorage.setItem("isCreateInGmail", result[i])
            }
            if (i == 'isCreateInOdigo') {
                localStorage.setItem("isCreateInOdigo", result[i])
            }
            if (i == 'isCreateInWindows') {
                localStorage.setItem("isCreateInWindows", result[i])
            }
            if (i == 'email') {
                localStorage.setItem("email", result[i])
            }
            frm.find('[name="'+url+'[' + i + ']"]').val(result[i]);
        }
        $('#mainEditForm').addClass('show').removeClass('hide');
        $('#loadingMain').addClass('hide').removeClass('show');
    }});
}

// Fonction de chargement du bloc Windows
function ajaxGenerateWindows()
{
    $('#createActionWindowsPart').addClass('hide').removeClass('show');
    $('#createActionSalesforcePart').addClass('hide').removeClass('show');
    $('#createActionAramisPart').addClass('hide').removeClass('show');
    $('#createActionOdigoPart').addClass('hide').removeClass('show');
    $('#createActionGmailPart').addClass('hide').removeClass('show');
    $('#gmailToggle').removeClass('active');
    $('#odigoToggle').removeClass('active');
    $('#windowsToggle').addClass('active');
    $('#aramisToggle').removeClass('active');
    $('#salesforceToggle').removeClass('active');
    if (localStorage.getItem("isCreateInWindows") == 0) {
        $('#loading').removeClass('hide').addClass('show');
        urlajax ="/ajax/get/active_directory/organisation_units";
        $.ajax({
            url:urlajax,success:function(result) {
                var i;
                var nom = localStorage.getItem("currentName").toLowerCase().replace(' ', '').replace('-', '');
                var prenom = localStorage.getItem("currentSurname").substring(0,3).toLowerCase();
                var orgaUnitsListe = '<div class="form-group font_exo_2">' +
                    '<label class="font_exo_2 col-sm-4">Identifiant :' +
                    '<input type="text" name="windows[identifiant]" id="windows_identifiant" class="form-control" value="'+prenom+nom+'">' +
                    '</label>' +
                    '</div>';
                orgaUnitsListe += '<div class="form-group font_exo_2">' +
                    '<label class="font_exo_2 col-sm-4">Dn de l\'Utilisateur:' +
                    '<select name="windows[dn]" id="windows_dn" class="form-control">';
                for (i in result) {
                    orgaUnitsListe += '<option value="' + result[i].id + '">' + result[i].name + '</option>';
                }
                orgaUnitsListe += '</select>' +
                    '</label>' +
                    '</div>';
                document.getElementById("InsertWindowsField").innerHTML = orgaUnitsListe;
                $('#loading').addClass('hide').removeClass('show');
                $('#createActionWindowsPart').addClass('show').removeClass('hide');
            }
        });
    }
}

// Fonction de chargement du bloc salesforce
function ajaxGenerateSalesforce()
{
    $('#createActionWindowsPart').addClass('hide').removeClass('show');
    $('#createActionAramisPart').addClass('hide').removeClass('show');
    $('#createActionOdigoPart').addClass('hide').removeClass('show');
    $('#createActionGmailPart').addClass('hide').removeClass('show');
    $('#createActionSalesforcePart').addClass('hide').removeClass('show');
    $('#createActionSalesforcePartEdit').addClass('hide').removeClass('show');
    $('#createActionSalesforcePartNew').addClass('hide').removeClass('show');
    $('#gmailToggle').removeClass('active');
    $('#odigoToggle').removeClass('active');
    $('#windowsToggle').removeClass('active');
    $('#aramisToggle').removeClass('active');
    $('#salesforceToggle').addClass('active');
    $('#loading').removeClass('hide').addClass('show');
    urlajax ="/ajax/get/salesforce/utilisateur/"+localStorage.getItem("email");
    $.ajax({
        url:urlajax,success:function(result) {
            if (result['totalSize'] == 1)
            {
                $('#createActionSalesforceParNew').addClass('hide').removeClass('show');

                $('#loading').removeClass('show').addClass('hide');
                $('#createActionSalesforcePartEdit').addClass('show').removeClass('hide');
                $('#createActionSalesforcePart').addClass('show').removeClass('hide');
            } else {
                $('#createActionSalesforcePartEdit').addClass('hide').removeClass('show');
                urlajax ="/ajax/get/salesforce/profiles";
                $.ajax({
                    url:urlajax,success:function(result) {
                        var i;
                        var profilesListe = '<label class="font_exo_2 col-sm-4">Numéro Prosodie:';
                        profilesListe += '<select name="salesforce[profile]" id="salesforce_profile" class="form-control">';
                        for (i in result) {
                            profilesListe += '<option value="'+result[i].profileId+'">'+result[i].profileName+'</option>';
                        }
                        profilesListe += '</select>';
                        profilesListe += '</label>';
                        document.getElementById("salesforceProfilesListe").innerHTML = profilesListe;

                        $('#loading').removeClass('show').addClass('hide');
                        $('#createActionSalesforcePartNew').addClass('show').removeClass('hide');
                        $('#createActionSalesforcePart').addClass('show').removeClass('hide');
                    }
                });
            }
        }
    });
}

// Fonction de chargement du bloc aramis
function ajaxGenerateAramis()
{
    $('#createActionWindowsPart').addClass('hide').removeClass('show');
    $('#createActionSalesforcePart').addClass('hide').removeClass('show');
    $('#createActionOdigoPart').addClass('hide').removeClass('show');
    $('#createActionGmailPart').addClass('hide').removeClass('show');
    $('#gmailToggle').removeClass('active');
    $('#odigoToggle').removeClass('active');
    $('#windowsToggle').removeClass('active');
    $('#aramisToggle').addClass('active');
    $('#salesforceToggle').removeClass('active');
    $('#createActionAramisPart').addClass('show').removeClass('hide');
}

// Fonction de chargement du bloc de gestion gmail
function ajaxGenerateEmail()
{
    $('#createActionGmailPart').addClass('hide').removeClass('show');
    $('#createActionWindowsPart').addClass('hide').removeClass('show');
    $('#createActionSalesforcePart').addClass('hide').removeClass('show');
    $('#createActionAramisPart').addClass('hide').removeClass('show');
    $('#createActionOdigoPart').addClass('hide').removeClass('show');
    $('#windowsToggle').removeClass('active');
    $('#aramisToggle').removeClass('active');
    $('#salesforceToggle').removeClass('active');
    $('#odigoToggle').removeClass('active');
    $('#gmailToggle').addClass('active');
    $('#loading').removeClass('hide').addClass('show');
    urlajax = "/ajax/check/google/isexist/" + localStorage.getItem("email");
    $.ajax({
        url: urlajax, success: function (result) {
            localStorage.setItem("emailState",result);
            if (localStorage.getItem("emailState") == "nouser") {
                var currentEditItem = localStorage.getItem("currentEditItem");
                urlajax ="/ajax/generate/email/"+currentEditItem;
                $.ajax({
                    url:urlajax,success:function(result) {
                        var i;
                        var textToAppend = '';
                        for (i in result) {
                            textToAppend += '<div class="form-group font_exo_2" onclick="showhide();"><label class="font_exo_2 col-sm-3"><input class="font_exo_2 col-sm-2" type="radio" name="genEmail" value="'+result[i]+'">' +result[i]+'</label></div>';
                        }
                        document.getElementById("actionGmailList").innerHTML = textToAppend;
                        $('#loading').addClass('hide').removeClass('show');
                        $('#createActionGmailPart').addClass('show').removeClass('hide');
                    }
                });
            }
        }
    });
}

// Fonction de chargement du bloc de gestion odigo
function ajaxGenerateOdigo()
{
    $('#createActionGmailPart').addClass('hide').removeClass('show');
    $('#createActionWindowsPart').addClass('hide').removeClass('show');
    $('#createActionSalesforcePart').addClass('hide').removeClass('show');
    $('#createActionAramisPart').addClass('hide').removeClass('show');
    $('#createActionOdigoPart').addClass('hide').removeClass('show');
    $('#gmailToggle').removeClass('active');
    $('#windowsToggle').removeClass('active');
    $('#aramisToggle').removeClass('active');
    $('#salesforceToggle').removeClass('active');
    $('#odigoToggle').addClass('active');
    $('#loading').removeClass('hide').addClass('show');
    var service = localStorage.getItem("service");
    var fonction = localStorage.getItem("fonction");
    urlajax = "/ajax/check/odigo/isabletouse/" + service + "/" + fonction;
    $.ajax({
        url: urlajax, success: function (result) {
            localStorage.setItem("ableToShowOdigo",result);
            if (localStorage.getItem("isCreateInOdigo") == 0 && localStorage.getItem("ableToShowOdigo") == 1) {
                var nom = localStorage.getItem("currentName").toLowerCase().replace(' ', '').replace('-', '');
                var prenom = localStorage.getItem("currentSurname").substring(0,3).toLowerCase();
                document.getElementById("prosodie_identifiant").value = prenom+nom;
                var currentEditItem = localStorage.getItem("currentEditItem");
                urlajax = "/ajax/generate/odigo/" + service + "/" + fonction;
                $.ajax({
                    url: urlajax, success: function (result) {
                        var i;
                        var prosodieListe = '<label class="font_exo_2 col-sm-4">Numéro Prosodie:';
                        prosodieListe += '<select name="prosodie[numProsodie]" id="prosodie_numProsodie" class="form-control">';
                        if (result.length >= 1) {
                            prosodieListe += '<option value="">Numéro Prosodie</option>';
                            for (i in result) {
                                prosodieListe += '<option value="' + result[i] + '">' + result[i] + '</option>';
                            }
                        } else {
                            prosodieListe += '<option value="">Pas de Numéros</option>';
                        }
                        prosodieListe += '</select>';
                        prosodieListe += '</label>';
                        document.getElementById("prosodieListe").innerHTML = prosodieListe;

                        urlajax = "/ajax/generate/orange/" + service;
                        $.ajax({
                            url: urlajax, success: function (result) {
                                var i;
                                var orangeListe = '<label class="font_exo_2 col-sm-2">Numéro Orange:';
                                orangeListe += '<select name="prosodie[numOrange]" id="prosodie_numOrange" class="form-control">';
                                if (result.length >= 1) {
                                    orangeListe += '<option value="">Numéro Orange</option>';
                                    for (i in result) {
                                        orangeListe += '<option value="'+result[i]+'">'+result[i]+'</option>';
                                    }
                                } else {
                                    orangeListe += '<option value="">Pas de Numéros</option>';
                                }
                                orangeListe += '</select>';
                                orangeListe += '</label>';
                                orangeListe += '<button type="button" onclick="showOtherNum();" class="otherNumButton btn btn-info font_exo_2">Autre Num</button>';
                                document.getElementById("orangeliste").innerHTML = orangeListe;

                                $('#loading').addClass('hide').removeClass('show');
                                $('#createActionOdigoPart').addClass('show').removeClass('hide');
                            }
                        });
                    }
                });
            } else {
                $('#loading').addClass('hide').removeClass('show');
            }
        }
    });
}

// Fonction d'affichage du champ autre email pendant création gmail
function showhide()
{
    if($('#otherMail').prop('checked')) {
        $('#otherEmail').addClass('show').removeClass('hide');
    } else {
        $('#otherEmail').addClass('hide').removeClass('show');
    }
}

// Fonction Affiche Autre numéro Field
function showOtherNum()
{
    $('#otherNumField').addClass('show').removeClass('hide');
}