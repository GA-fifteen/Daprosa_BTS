$(document).ready(function(){

//---------- view number!
    $.ajax({
        type: "POST",
        url: "view_name.php",
        success: function(data){
            $("#name_teller").append(data);
        },
        error: function(data){
            alert(data);
        }
    });

//----------  view customers
    $.ajax({
        type: "POST",
        url: "view_teller_customers.php",
        success: function(data){
            $("#admin_customers").append(data);
        },
        error: function(data){
            alert(data);
        }
    });

//---------- log out
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

// ---------- search customer---------
    $("#search").keyup(function(){
        var wordObj = {"search":$(this).val()};
        $.ajax({
            type: "POST",
            url: "search.php",
            data: wordObj,
            success: function(data){
                //console.log(data);
                $(document.getElementById("admin_customers")).html(data);
            },
            error: function(data){
                alert(data);
            }
        });

    });

//----------- ADD CUSTOMER
    $("#btnAddCustomer").click(function(){
        var objReg = {
            "firstName":$("input[name='firstName']").val(),
            "lastName":$("input[name='lastName']").val(),
            "gender":$("select[name='gender']").val(),
            "address":$("input[name='address']").val(),
            "contact":$("input[name='contact']").val(),
            "userName":$("input[name='add_userName']").val(),
            "password":$("input[name='password']").val(),
            "confirm_password":$("input[name='confirm_password']").val()
        };
        if (objReg.firstName == ""){
            alert("please input firstname!");
        }else if(objReg.lastName == ""){
            alert("please input lastname!");
        }else if(objReg.address == ""){
            alert("please input address!");
        }else if(objReg.contact == ""){
            alert("please input contact!");
        }else if(objReg.userName == ""){
            alert("please input username!");
        }else if(objReg.password == ""){
            alert("please input password!");
        }else if(objReg.password != objReg.confirm_password){
            alert("password did'nt match!");
        }else{
            $.ajax({
                type: "POST",
                url: "add_customer.php",
                data: objReg,
                success: function(data){
                    $("#viewCustomer").append(data);
                    alert(data);
                    $(document.location.reload(true));
                },
                error: function(data){
                    alert(data);
                }
            });
        }
    });

// ---------- DEPOSIT FORM
    $("#deposit").hide();
    $("#Deposit").click(function(){
        $("#deposit").dialog({
            show: "bounce",
            hide: "blind",
            draggable: false,
            resizable: false,
            modal: true,
            width: 550,
            buttons: {
                "Deposit":function(){
                    var objAdd = {
                        "deposit_amount":$("input[name='deposit_amount']").val(),
                        "userName":$("input[name='deposit_userName']").val()
                    };
                    if(objAdd.deposit_amount == 0){
                        alert("please enter an amount!");
                    }else if(objAdd.userName == ""){
                        alert("please input username!");
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "deposit.php",
                            data: objAdd,
                            success: function(data){
                                $("#records").append(data);
                                alert(data);
                                $(document.location.reload(true));
                            },
                            error: function(data) {
                                alert(data);
                            }
                        });
                    }
                },
                "Cancel": function(){
                    $(this).dialog("close");
                }
            }
        });
    });

//----------- WITHDRAWAL FORM
   $("#withdraw").hide();
    $("#Withdraw").click(function(){
        $("#withdraw").dialog({
            show: "bounce",
            hide: "blind",
            draggable: false,
            resizable: false,
            modal: true,
            width: 550,
            buttons: {
                "Withdraw":function(){
                    var objAdd = {
                        "withdraw_amount":$("input[name='withdraw_amount']").val(),
                        "userName":$("input[name='withdraw_userName']").val()
                    };
                    if(objAdd.withdraw_amount == 0){
                        alert("please enter an amount!");
                    }else if(objAdd.userName == ""){
                        alert("please input username!");
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "withdraw.php",
                            data: objAdd,
                            success: function(data){
                                $("#records").append(data);
                                alert(data);
                                $(document.location.reload(true));
                            },
                            error: function() {
                                alert(data);
                            }
                        });
                    }
                },
                "Cancel": function(){
                    $(this).dialog("close");
                }
            }
        });
    });

});

function editCustomers(customers_id){
    var objEdit = {"id":customers_id};
    $.ajax({
        type: "POST",
        data: objEdit,
        url: "edit_customer.php",
        success: function(data){
            var obj = JSON.parse(data);
            $("input[name = 'customers_id']").val(obj.customers_id);
            $("input[name = 'firstName']").val(obj.firstName);
            $("input[name = 'lastName']").val(obj.lastName);
            $("select[name = 'gender']").val(obj.gender);
            $("input[name = 'address']").val(obj.address);
            $("input[name = 'contact']").val(obj.contact);
            $("input[name = 'userName']").val(obj.userName);
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
                    "customers_id":$("input[name='customers_id']").val(),
                    "firstName":$("input[name='firstName']").val(),
                    "lastName":$("input[name='lastName']").val(),
                    "gender":$("select[name='gender']").val(),
                    "address":$("input[name='address']").val(),
                    "contact":$("input[name='contact']").val(),
                    "userName":$("input[name='userName']").val()
                };
                $.ajax({
                    type: "POST",
                    data: ObjSave,
                    url: "save_customer.php",
                    success: function(data){
                        $(document.getElementById(ObjSave.id)).html(data);
                        //$(document.location.reload(true));
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

function viewCustomersInfo(id){
    var objView = {"id":id};
    $.ajax({
        type: "POST",
        data: objView,
        url: "view_customers_info.php",
        success: function(data){
            $("#viewInfo").append(data);
        },
        error: function(data){
            alert(data);
        }
    });
    $("#viewCusInfo").dialog({
        show: "scale",
        hide: "explode",
        draggable: false,
        resizable: false,
        modal: true,
        width: 530,
        buttons: {
            "close":function(){
                $( this ).dialog("close");
                $(document.location.reload(true));
            }
        }
    });
}

function viewSavingsRecords(id){
    var objView = {"id":id};
    $.ajax({
        type: "POST",
        data: objView,
        url: "view_savings_records.php",
        success: function(data){
            $("#view_savings").append(data);
        },
        error: function(data){
            alert(data);
        }
    });
    $("#view_savingRecords").dialog({
        show: "scale",
        hide: "explode",
        resizable: false,
        modal: true,
        draggable: false,
        width: 750,
        buttons: {
            "close":function(){
                $( this ).dialog("close");
                $(document.location.reload(true));
            }
        }
    });
}