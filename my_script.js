$("#sub").click( function() {
	
 var data = $("#myForm: input").serializeArray();
 $.post($("#myForm").attr("action")), data, function(info) {
 	$("#result").html(info);}
clearInput();
 }


);

$("#myForm").submit(function() {
	return false;
}) ;
function clearInput() {
	$("#myForm :input").each(function() {
		$(this).val('');
	});
}