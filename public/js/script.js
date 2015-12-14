
var method;
var customFieldsWrapper         = $(".input_fields_wrap"); //fields wrapper

var firstContact = false;

var x = 1; //initlal text box count

$(document).ready(function() {
    var maxFields      = 5; //maximum fields allowed
    var addButton      = $("#add_field_button"); //Add button ID

    $(addButton).click(function(e){ //on add field button click
        e.preventDefault();

        var numFields = $(customFieldsWrapper).find('div').length;

        if(x <= maxFields && numFields < maxFields){
            $(customFieldsWrapper).append('<div class="form-group custom-field-wrapper"><input type="text" class="form-control custom-field" name="custom_field_' + ($(customFieldsWrapper).children().length + 1) + '"/><a href="#" class="remove_field btn btn-default pull-right"><i class="fa fa-minus"></i></a></div><br><br>'); //add input box
            x++; //text box increment
        }
    });

    $(customFieldsWrapper).on("click",".remove_field", function(e){ //user clicked on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })

    $("#first_contact_button").click(function() {
        firstContact = true;
    });

    $(".edit-form-button").click(function() {
        if($(customFieldsWrapper).find('div').length < maxFields) {
            $("#add_field_button").prop('disabled', false);
        }

        $("#modal_errors").html('');
    });
    
    $("#edit_form").submit(function(e) {

        e.preventDefault();

        $.ajax({
            type: method,
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                if(firstContact) {
                    window.location = 'contacts';
                }
                if(data.indexOf("errors") > -1) {
                    $("#modal_errors").html(data);
                } else {
                    updateTable();
                    closeModal();

                    $("#messages").html(data);
                }
            }
        });
    });

    $("#search_form").submit(function(e) {
        e.preventDefault();

        $("#m_alert").alert('close');

        $.ajax({
            type: 'get',
            url: $(this).attr('action'),
            data: {search: $("#search").val()},
            success: function(data) {
                if(data != '') {
                    $("#contacts_table").find('tbody').html(data);
                } else {
                    alert('Your search returned no results.');
                }
            }
        });
    });

});

function newContact() {
    method = 'post';
    $("#edit_form").attr('action', 'contacts');

    $(".edit-form-field").each(function() {
        $(this).val('');
    });

    $(customFieldsWrapper).find('div').each(function() {
        $(this).remove();
    });

}

function editContact(id) {
    $(customFieldsWrapper).find('div').each(function() {
        $(this).remove();
    });

    var fields = getFields(id);

    var customFieldPattern = new RegExp('custom_field_');

    var count = 1;

    $.each(fields, function(key, val) {

        if(customFieldPattern.test(key) && val != '' && val != null) {
            $(customFieldsWrapper).append('<div class="form-group custom-field-wrapper"><input type="text" class="form-control custom-field" name="custom_field_' + ($(customFieldsWrapper).children().length + 1) + '"/><a href="#" class="remove_field btn btn-default pull-right"><i class="fa fa-minus"></i></a></div><br><br>'); //add input box
            count++;
        }

        $("#" + key).val(val);
    });

    $("#edit_form").attr('action', 'contacts/' + id);
    method = 'put';
}

function getFields(id) {
    return $.parseJSON(
        $.ajax({
            type: 'GET',
            async: false,
            url: 'contacts/' + id
        }).responseText
    );
}

function updateTable() {
    $.ajax({
        type: 'get',
        url: 'contacts/table',
        success: function(data) {
            $("#contacts_table").find('tbody').html(data);
        }
    });
}

function closeModal() {
    x = 1;
    $("#form_modal").modal('hide');
}

function deleteContact(id) {
    if(confirm("Are you sure you want to delete this contact?")) {
        $.ajax({
            type: "delete",
            url: "contacts/" + id,
            success: function(data) {
                $("#messages").html(data);
            }
        });

        updateTable();

        if($("#conatcts_table").find('tbody').children().length == 0) {
            window.location = 'contacts';
        }
    }
}