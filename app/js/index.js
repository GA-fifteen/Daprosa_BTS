$(document).ready(function(){

//--- VIEW CUSTOMERS
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
//--- VIEW TELLERS
    $.ajax({
        type: "POST",
        url: "view_admin_tellers.php",
        success: function(data){
            $("#view_tellers").append(data);
        },
        error: function(data){
            alert(data);
        }
    });

//---------   ADD TELLER
    $("#btnAddTeller").click(function(){
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
                url: "add_teller.php",
                data: objReg,
                success: function(data){
                    $("#view_tellers").append(data);
                    alert(data);
                    $(document.location.reload(true));
                },
                error: function(data){
                    alert(data);
                }
            });
        }
    });

//--- SEARCH customers
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

//--- SEARCH tellers
    $("#searchTellers").keyup(function(){
        var wordObj = {"searchTellers":$(this).val()};
        $.ajax({
            type: "POST",
            url: "searchTeller.php",
            data: wordObj,
            success: function(data){
                console.log(data);
                $(document.getElementById("view_tellers")).html(data);
            },
            error: function(data){
                alert(data);
            }
        });

    });

});

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