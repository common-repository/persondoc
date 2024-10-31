var check;
var URL = "https://fastcheck.persondoc.com/api/";
var dialog;

function iframeLoaded() {

    var iFrameID = document.getElementsByTagName('iframe');
    iFrameID = iFrameID[0];
    jQuery(iFrameID).css('height', '915px');
}

function PersonDoc(appID) {
    this.appID = appID;

    this.close = function () {
        dialog.dialog("close");
    }

    this.init = function (variables) {
        this.variables = variables;

        var jqueyuijs = jQuery('<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>');
        jQuery('head').append(jqueyuijs);
        var dialogTheme = jQuery('<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/cupertino/jquery-ui.min.css">');
        jQuery('head').append(dialogTheme);

        var btn = '<input type="button" id="loginpersondoc" data-dismiss="modal" onclick="PD.open()" class="btn btn-primary col-xs-12"  value="Persondoc" />';

        if (this.variables.boton == 'large') {
            jQuery('#loginpersondoc').replaceWith(btn);
            jQuery('#loginpersondoc').css('background-color', '#37519F');
            jQuery('#loginpersondoc').css('background-image', 'url("https://fastcheck.persondoc.com/api/clouds.svg")');
            jQuery('#loginpersondoc').css('background-repeat', 'no-repeat');
            jQuery('#loginpersondoc').css('background-position', '10px 0px');
            jQuery('#loginpersondoc').val('Sign In Persondoc');
            jQuery('#loginpersondoc').css('padding-left', '50px');
            jQuery('#loginpersondoc').css('padding-right', '50px');
        } else {
            jQuery('#loginpersondoc').replaceWith(btn);
            jQuery('#loginpersondoc').css('background-color', '#37519F');
            jQuery('#loginpersondoc').css('background-image', 'url("https://fastcheck.persondoc.com/api/clouds.svg")');
            jQuery('#loginpersondoc').css('background-repeat', 'no-repeat');
            jQuery('#loginpersondoc').css('background-position', '10px 0px');
            jQuery('#loginpersondoc').css('padding-left', '50px');
            jQuery('#loginpersondoc').css('padding-right', '50px');
        }

    };

    this.login = function foo(callback) {

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == XMLHttpRequest.DONE) {
                if (xmlhttp.status == 200) {
                    document.getElementById("myDiv").innerHTML = xmlhttp.responseText;
                }
                else if (xmlhttp.status == 400) {
                    alert('There was an error 400');
                }
                else {
                    alert('something else other than 200 was returned');
                }
            }
        };

        xmlhttp.open("GET", URL + "index.php", true);
        xmlhttp.send();

    };
    this.prepare = function () {
        var html = '<form name="PD.LoginForm" onsubmit="event.preventDefault(); validateLogin();"><label for="username">Email:</label><input type="email" id="username" /><br><label for="password">ContraseÃ±a:</label><input type="password" id="password" /><br><input type="submit" /></form>';
        document.getElementById("persondoc-root").innerHTML = html;
    };
    this.api = function (api, callback) {
        callback('true');
    };

    this.open = function () {

        var dialogStyle = jQuery('<style>.ui-widget {font-family:Verdana,Arial,sans-serif;font-size:.8em;}.ui-dialog {top:100px;left:0;outline:0 none;padding:0 !important;position:absolute;}#success {padding: 0;margin: 0;}.ui-dialog .ui-dialog-content {background: none repeat scroll 0 0 transparent;border: 0 none;overflow: auto;position: relative;padding: 0 !important;}.ui-widget-header {background:#37519F;border:none;border-bottom-right-radius:0;border-bottom-left-radius:0;}.ui-corner-all {border: none;border-radius: 0px;}.ui-button {background: white;color: #37519F;}</style>');
        jQuery('head').append(dialogStyle);

        function mi() {
            clearInterval(check);
        }

        var iframe = jQuery('<iframe onload="iframeLoaded()" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>');
        dialog = jQuery("<div id='persondoc-frame'></div>").append(iframe).appendTo("body").dialog({
            autoOpen: false,
            modal: true,
            resizable: false,
            width: "auto",
            height: "auto",
            close: function () {
                iframe.attr("src", "X");
            }
        });

        var session = makeid();
        var src = "https://fastcheck.persondoc.com/api/login.php?variables=" + JSON.stringify(this.variables) + "&session=" + session;
        iframe.attr({
            width: 500,
            height: 600,
            src: src
        });
        dialog.dialog({close: mi, closeText: ''}).dialog("open");

        check = setInterval(function () {
            comprobar(session);
        }, 1000);

        jQuery('[aria-describedby="persondoc-frame"]').css('top', '80px');

    };

}

function comprobar(session) {
    jQuery.ajax({
        url: URL,
        dataType: 'jsonp',
        data: {session: session},
        success: function (response) {
            if (response.success != 0) {
                clearInterval(check);
                dialog.dialog("close");
                getLoginStatus(response);
            }
        }
    });

}

function closeDialog() {
    PD.close();
}

function makeid() {

    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 5; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}


function validateLogin() {

    PD.username = document.getElementById("username").value;
    PD.password = document.getElementById("password").value;

    PD.login(function (result) {

        var response = JSON.parse(result);
        getLoginStatus(response);
    });
}


var PD = new PersonDoc('81dc9bdb52d04dc20036dbd8313ed055');


PD.init({
    appID: php_vars.appID,
    requisitos: "g1-g2-g3"
});

var eventClick = '0';
var dirId = '';

jQuery(document).ready(function () {
    jQuery("#prsdLogin").click(function () {
        eventClick = '1';
    });
});

function getLoginStatus(response) {
    if (eventClick == 1) {
        Object.keys(response.address).forEach(function (key) {
            dirId = key
        });

        result = response.address[dirId].json;
        if(result){
            var addressData = JSON.parse(result)
            jQuery("#billing_address_1").val(addressData.route + addressData.street_number);
            jQuery("#billing_address_2").val(addressData.administrative_area_level_1);
            jQuery("#billing_postcode").val(addressData.postal_code);
            jQuery("#billing_city").val(addressData.locality);
            jQuery('select#billing_country').val(addressData.country);
            jQuery('select#billing_country').trigger('change');
            jQuery("select#billing_state").val(addressData.administrative_area_level_2);
            jQuery('select#billing_state').trigger('change');
        }
       
        jQuery("#billing_phone").val(response.phone);
        jQuery("#billing_first_name").val(response.name);
        jQuery("#billing_last_name").val(response.surname);   
        jQuery("#username").val(response.emailUser);
        jQuery("#password").val(response.surname);
        jQuery(".login").find('[type=submit]').click();

    } else {

        Object.keys(response.address).forEach(function (key) {
            dirId = key
        });

        result = response.address[dirId].json;

        if(result){
                var addressData = JSON.parse(result)
                jQuery("#reg_billing_address_1").val(addressData.route + addressData.street_number);
                jQuery("#reg_billing_address_2").val(addressData.administrative_area_level_1);
                jQuery("#reg_billing_postcode").val(addressData.postal_code);
                jQuery("#reg_billing_city").val(addressData.locality);
                jQuery('select#regcountry').val(addressData.country);
                jQuery('select#regcountry').trigger('change');
                jQuery("select#regstate").val(addressData.administrative_area_level_2);
                jQuery('select#regstate').trigger('change');
        }

        jQuery("#reg_email").val(response.emailUser);
        jQuery("#reg_password").val(response.surname);
        jQuery("#reg_billing_phone").val(response.phone);
        jQuery("#reg_billing_first_name").val(response.name);
        jQuery("#reg_billing_last_name").val(response.surname);


        jQuery(".register").find('[type=submit]').click();


    }
}