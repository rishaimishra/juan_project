var vadilState = null;
var alphaPattern = /^[a-zA-Z ]+$/;
var stringPattern = /^[a-zA-Z0-9.-_&:\s]+$/;
var alphaNumericPattern = /^[a-zA-Z0-9. ]+$/;
var namePattern = /^[a-zA-Z.-\s]+$/;
var ifscPattern = /[a-zA-Z]{4}\d{7}/;
var numericPattern = /^[0-9]+$/;
var mobilePattern = /^[0-9]{10}$/;
var specialCharPattern = /^[a-zA-Z.-_:\s]+$/;
var pincodePattern = /^[0-9]{6}$/;
var datePattern = /^([0-2][0-9]|[3][0-1])\/|-([0-9][1-2])\/|-((19|20)[0-9]{2})$/;
var timePattern = /^[0-9:.-\s]+$/;
var heightPattern = /^[0-9.-\s]+$/;
var emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var websitePattern = /^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)$/;
function AjaxPost(formData, url, successCallBack, errorCallBack, args = null) {
    var request = new XMLHttpRequest;
    request.onreadystatechange = function () {
        try {
            if (this.readyState == 4 && this.status == 200) {
                var content = request.responseText.trim();
                if (args == null)
                    successCallBack(content)
                else {
                    successCallBack(content, args)
                }

            } else if (this.status == 404 || this.status == 403) {
                throw "Error: readyState= " + this.readyState + " status= " + this.status;
            }
        } catch (e) {
            errorCallBack(e);
        }
    }
    request.open("POST", url);
    request.send(formData);
}

function AjaxError(error) {
    showAlert("Please contact IT. ", 'error');
}

function showAlert(errorMessage = '', Type = 'success', Delay = 2000) {
    if (errorMessage != '') {
        $.notify({
            message: errorMessage
        }, {
            type: Type,
            animate: {
                enter: 'animated bounceIn',
                exit: 'animated bounceOut'
            },
            newest_on_top: true,
            delay: Delay
        });
        return false;
    } else {
        return true;
    }
};

function isNumberKeyWithMax(evt, text) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    var txt = text.value + String.fromCharCode(charCode);
    var max = parseFloat(text.max);
    max = isNaN(max) ? Number.MAX_VALUE : max;
    var val = parseFloat(txt);
    val = isNaN(val) ? 0 : val;
    console.log(val);

    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;

    if (val > max)
        return false;
    return true;
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;

    return true;
}