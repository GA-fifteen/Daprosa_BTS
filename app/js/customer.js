$(document).ready(function(){

//---------- view name
    $.ajax({ 
        type: "POST",
        url: "view_name.php",
        success: function(data){
            $("#name_customer").append(data);
        },
        error: function(data){
            alert(data);
        }
    });

//------------  view customer's profile
    $("#myProfile").hide();
    $("#Profile").click(function(){
        $.ajax({
            type: "POST",
            url: "view_customer.php",
            success: function(data){
                $("#viewProfile").append(data);
            },
            error: function(data){
                alert(data);
            }
        });
        $("#myProfile").dialog({
            show: "bounce",
            hide: "blind",
            draggable: false,
            resizable: false,
            modal: true,
            width: 550,
            buttons: {
                "close":function(){
                    $(this).dialog("close");
                    $(document.location.reload(true));
                }
            }
        });
    });

//------------  log out
    $("#logout").click(function(){
        $.ajax({
            type: "POST",
            url: "logout.php",
            data: {"userName":$("input[name='userName']").val()},
            success: function (data){
                $(document.location.reload(true));
            },
            error: function(data){
                //alert(data);
            }
        });
    });

//------------  view customer's savings account
     $.ajax({
         type: "POST",
         url: "view_savings.php",
         success: function(data){
            $("#records").append(data);
         },
         error: function(data){
            alert(data);
         }
     });

});

//------------ edit customer's profile
function editCustomers(users_id){
    var objEdit = {"id":users_id};
    $.ajax({
        type: "POST",
        data: objEdit,
        url: "edit_customer.php",
        success: function(data){
            var obj = JSON.parse(data);
            $("input[name = 'users_id']").val(obj.users_id);
            $("input[name = 'firstName']").val(obj.firstName);
            $("input[name = 'lastName']").val(obj.lastName);
            $("select[name = 'gender']").val(obj.gender);
            $("input[name = 'address']").val(obj.address);
            $("input[name = 'contact']").val(obj.contact);
            $("input[name = 'userName']").val(obj.userName);
            $("input[name = 'password']").val(obj.password);
            $("input[name = 'confirm_password']").val(obj.confirm_password);
        },
        error: function(data){
            alert(data);
        }
    });
    $("#editing").dialog({
        show: "clip",
        hide: "explode",
        draggable: false,
        resizable: false,
        modal: true,
        width: 550,
        buttons: {
            "save":function(){
                var ObjSave = {
                    "users_id":$("input[name='users_id']").val(),
                    "firstName":$("input[name='firstName']").val(),
                    "lastName":$("input[name='lastName']").val(),
                    "gender":$("select[name='gender']").val(),
                    "address":$("input[name='address']").val(),
                    "contact":$("input[name='contact']").val(),
                    "userName":$("input[name='userName']").val(),
                    "password":$("input[name='password']").val(),
                    "confirm_password":$("input[name='confirm_password']").val()

                };
                $.ajax({
                    type: "POST",
                    data: ObjSave,
                    url: "save_customer.php",
                    success: function(data){
                        $(document.getElementById(ObjSave.id)).html(data);
                        alert(data);
                        $(document.location.reload(true));
                    },
                    error: function(data){
                        alert(data);
                    }
                });
                $( this ).dialog("close");
            },
            "never":function(){
                $( this ).dialog("close");

            }
        }
    });
}