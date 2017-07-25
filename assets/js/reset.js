$(function(){
            $("#reset").click(function () {
                $("#my_select1").val($("#my_select1").data("default-value"));
                $("#my_select2").val($("#my_select2").data("default-value"));
                $("#my_select3").val($("#my_select3").data("default-value"));
               	$('#filter-form').submit();

            });
        });



