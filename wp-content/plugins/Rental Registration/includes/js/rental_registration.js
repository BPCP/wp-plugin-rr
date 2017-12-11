
jQuery(document).ready(function ($) {
    document.getElementById("defaultOpen").click();
})



function openTab(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active"
}

function updateField(obj, nonce)
{
    //alert(obj.checked);
    if (obj.type === 'checkbox') {
        obj.value = obj.checked;
    }
    jQuery.ajax({
        type: 'POST',
        url: ajax_url,
        data: {action: 'update_field',
            _ajax_nonce: nonce,
            table: jQuery(obj).data('table'),
            idx: jQuery(obj).data('idx'),
            field: obj.name,
            nVal: obj.value},
        success: function (data) {
            //alert(jQuery(obj).data('table'));
        }
    });
}
;



