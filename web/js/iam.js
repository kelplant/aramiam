/**
 * Created by Xavier on 11/04/2016.
 */
// Fonction de chargement Standard Edit
function ajaxCoreEdit(url, editItem)
{
    if (url == 'utilisateur') {
        localStorage.setItem("emailState", null);
        localStorage.setItem("ableToShowOdigo", null);
    }
    urlajax ="/ajax/"+url+"/get/"+editItem;
    $.ajax({url:urlajax,success:function(result){
        var frm = $("#form-edit");
        var i;
        for (i in result) {
            if (url == 'utilisateur') {
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
            }
            if (url == 'candidat' && i == 'predecesseur') {
                localStorage.setItem("currentPredecesseurId", result[i])
            }
            if (url == 'odigo_tel_liste' && i == 'inUse') {
                document.forms[1].elements[5].checked = result[i];
            } else if (url == 'orange_tel_liste' && i == 'inUse'){
                document.forms[1].elements[4].checked =  result[i];
            }
            else {
                frm.find('[name="'+url+'[' + i + ']"]').val(result[i]);
            }
        }
    }});
}

// Fonction de mise en session du user éditer en cours
function resetEditItem()
{
    localStorage.clear();
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
        var nom = localStorage.getItem("currentName").toLowerCase().replace(' ', '').replace('-', '');
        var prenom = localStorage.getItem("currentSurname").substring(0,3).toLowerCase();
        document.getElementById("windows_identifiant").value = prenom+nom;
        $('#loading').addClass('hide').removeClass('show');
        $('#createActionWindowsPart').addClass('show').removeClass('hide');
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

// Fonction de chargement du bloc de gestion gmail
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

// Fonction de lien vers le predecesseur
function setViewUtilisateur()
{
    var currentEditItem = localStorage.getItem("currentPredecesseurId");
    localStorage.setItem("currentEditItem",currentEditItem);
    window.location = "/admin/utilisateur?isArchived=0";
}

function ajaxCreateViaAPI()
{
    var currentEditItem = localStorage.getItem("currentEditItem");
}

// Fonction Show Password
function replaceT(formName)
{
    var newO = document.getElementById(formName).elements["utilisateur_mainPassword"];
    newO.setAttribute('type', 'text');
}

// Fonction de Generation de mot de passe
function generatePassword(formName)
{
    var chars = "ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var string_length = 8;
    var randomstring = '';
    var charCount = 0;
    var numCount = 0;
    for (var i=0; i<string_length; i++) {
        // If random bit is 0, there are less than 3 digits already saved, and there are not already 5 characters saved, generate a numeric value.
        if((Math.floor(Math.random() * 2) == 0) && numCount < 3 || charCount >= 5) {
            var rnum = Math.floor(Math.random() * 10);
            randomstring += rnum;
            numCount += 1;
        } else {
            // If any of the above criteria fail, go ahead and generate an alpha character from the chars string
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum,rnum+1);
            charCount += 1;
        }
    }
    document.getElementById(formName).elements["utilisateur_mainPassword"].value = randomstring;
}

// Fonction Process Bulk Import Orange Numbers
function processCsvFile(url) {
    $('#progressBarBulkImportDiv').addClass('show').removeClass('hide');
    $('#fileSelectDiv').addClass('hide');
    $('#fileUploadInfos').addClass('hide');
    $('#upload').addClass('hide');
    document.getElementById('progressBarBulkImport').innerHTML = '0%';
    var fileUpload = document.getElementById("fileUpload");
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;
    if (regex.test(fileUpload.value.toLowerCase())) {
        if (typeof (FileReader) != "undefined") {
            var reader = new FileReader();
            reader.onload = function (e) {
                var rows = e.target.result.split("\n");
                var totalRows = rows.length - 1;
                localStorage.setItem("totalRows", totalRows);
                var successRows = 0;
                var currentRow = 0;
                for (var i = 1; i < rows.length; i++) {
                    var cells = rows[i].split(",");
                    urlajax = url + cells;
                    $.ajax({
                        url: urlajax, success: function (result) {
                            currentRow = parseInt(currentRow) + parseInt('1');
                            var reglede3 = Math.round(parseInt(currentRow) * parseInt('100') / parseInt(totalRows)).toString();
                            document.getElementById('progressBarBulkImport').innerHTML = reglede3+'%';
                            $('#progressBarBulkImport').width(reglede3+'%').attr('aria-valuenow', reglede3);
                            successRows = parseInt(successRows) + parseInt(result);
                            if (parseInt(currentRow) == parseInt(totalRows))
                            {
                                localStorage.setItem("successRows",successRows);
                                $('#resultInsertFile').addClass('show').removeClass('hide');
                                document.getElementById('resultInsertFile').innerHTML = localStorage.getItem("successRows")+"/"+localStorage.getItem("totalRows")+' correctement inséré(s)';
                                $('#progressBarBulkImport').removeClass('active');
                            }
                        }
                    });

                }
            };
            reader.readAsText(fileUpload.files[0]);
        } else {
            alert("This browser does not support HTML5.");
        }
    } else {
        alert("Please upload a valid CSV file.");
    }
}

//Fonction de rechargement des profiles Sf
function reloadProfilesFromSf()
{
    $("#waiting").removeClass("hide").addClass("show");
    $("#reloadSfProfiles").removeClass("show").addClass("hide");
    urlajax = "/ajax/get/credentials";
    $.ajax({
        url: urlajax, success: function (result) {
            urlajax = "/batch/salesforce/profile/reload/"+result['user']+"/"+result['password'];
            $.ajax({
                url: urlajax, success: function (result) {
                    $("#waiting").removeClass("show").addClass("hide");
                    $("#reloadSfProfiles").removeClass("hide").addClass("show");
                    window.location = "/app/salesforce/profile_liste";
                }
            });
        }
    });
}

//Fonction de rechargement des groupes Sf
function reloadGroupesFromSf()
{
    $("#waiting").removeClass("hide").addClass("show");
    $("#reloadSfGroupes").removeClass("show").addClass("hide");
    urlajax = "/ajax/get/credentials";
    $.ajax({
        url: urlajax, success: function (result) {
            urlajax = "/batch/salesforce/groupe/reload/"+result['user']+"/"+result['password'];
            $.ajax({
                url: urlajax, success: function (result) {
                    $("#waiting").removeClass("show").addClass("hide");
                    $("#reloadSfGroupes").removeClass("hide").addClass("show");
                    window.location = "/app/salesforce/groupe_liste";
                }
            });
        }
    });
}