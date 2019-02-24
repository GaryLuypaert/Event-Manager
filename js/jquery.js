$(document).ready(function() {

	console.log('test jQuery');

var ligne = $(".invite");
	name = $("#nom");
	firstname = $("#prenom");
	places = $(".value-place");
	send = $("#btn-send");

$("body").on("load", ".invite" ,function() {

	// On applique la couleur rouge à tout le monde de base
	// ligne.addClass("danger");

});

// $('#test tr').each(function() {
//     var nbrPlaces = $(this).find(".value-place").html();    
//     console.log(nbrPlaces);
//  });



// Check automatiquement les cases des invités dont la valeur est cochée dans la bdd



// var statutBox = $(".checkboxValue");
var statutBox = $(".checkboxValue input[name='statut-checkbox']");
statutBox.each(function() { 
	if ($(this).attr("value") == 1) {
		$(this).attr("checked", "checked");
		// Si la valeur vaut "IN", alors on ajoute la class success
			if ($(this).attr("value") == 1) {
				$(this).parent().parent().removeClass("danger");
				$(this).parent().parent().addClass("success");
			}
	}
});

// Vérification
$(".form-inserts").keyup(function() {
	if ($(this).val().length < 1) {
		$(this).css("border", "2px solid red");
	}
	else {
		$(this).css("border", "2px solid #27AE60");
	}
});


var auto_refresh = setInterval(
function ()
{

// Code below was here


// });
$.get( "ajax_call.php?id_event="+ $("table").attr("id"), function( data ) {
	
  $( "#box-table" ).html( data );
  // $("[name='statut-checkbox']").bootstrapSwitch('state');

	// Check automatiquement les cases des invités dont la valeur est cochée dans la bdd



	// var statutBox = $(".checkboxValue");
	var statutBox = $(".checkboxValue input[name='statut-checkbox']");

	statutBox.each(function() { 

		if ($(this).attr("value") == 1) {
			// $(this).bootstrapSwitch('state', true);
			$(this).attr("checked", "checked");
			$(this).parents('tr').removeClass("danger");
			$(this).parents('tr').addClass("success");
		}

	});

$("input[name='statut-checkbox']").on('switchChange.bootstrapSwitch', function (event, state) {

	var id = $(this).attr('id');
	var value = $(this).val();


    if ($(this).attr("value") == 1) {
    		$(this).parents('tr').removeClass("success");
			$(this).parents('tr').addClass("danger");
			changeStatut(event.target.id, event.target.value);
		} else if ($(this).attr("value") == 0) {
			$(this).parents('tr').removeClass("danger");
			$(this).parents('tr').addClass("success");
			changeStatut(event.target.id, event.target.value);
		}
	});

});


}, 2500)

// $(".etatINOUT").bootstrapSwitch('state');




// End
});
// $(document).ready(function() {

// var ligne = $(".invite");
// 	name = $("#nom");
// 	firstname = $("#prenom");
// 	places = $("#places");
// 	send = $("#btn-send");

// $("body").on("load", ".invite" ,function() {

// 	// On applique la couleur rouge à tout le monde de base
// 	ligne.addClass("danger");
// 	console.log("test");

// });


// $("input[name='statut-checkbox']").click(function() {
// 	// Si la case est cochée, on change la class de la ligne
// 	if ($(this).is(":checked")) {
// 		$(this).parent().parent().removeClass("danger");
// 		$(this).parent().parent().addClass("success");
// 	}
// 	else if ($(this).is(":not(:checked)")) {
// 		$(this).parent().parent().addClass("danger");
// 	}
// });

// // Check automatiquement les cases des invités dont la valeur est cochée dans la bdd
// var statutBox = $(".checkboxValue input[name='statut-checkbox']");
// statutBox.each(function() { 
// 	if ($(this).attr("value") == 1) {
// 		$(this).attr("checked", "checked");
// 		// Si la valeur vaut "IN", alors on ajoute la class success
// 			if ($(this).is(":checked")) {
// 				$(this).parent().parent().removeClass("danger");
// 				$(this).parent().parent().addClass("success");
// 			}
// 	}
// });

// // Vérification
// $(".form-inserts").keyup(function() {
// 	if ($(this).val().length < 1) {
// 		$(this).css("border", "2px solid red");
// 	}
// 	else {
// 		$(this).css("border", "2px solid #27AE60");
// 	}
// });

// // $('#box-table').on('switchChange.bootstrapSwitch', '[name="statut-checkbox"]', function(event, state) {
// //    // ... skipped ...
// // });

// var auto_refresh = setInterval(
// function ()
// {
// $('#list-events').load('event.php table',function() {


// 	// Check automatiquement les cases des invités dont la valeur est cochée dans la bdd
// 	var statutBox = $("[name='statut-checkbox']");
// 	statutBox.each(function() { 

// 		if ($(this).is(':checked')) {
// 			// Si la valeur vaut "IN", alors on ajoute la class success
// 				if ($(this).is(":checked")) {
// 					$(this).parent().parent().removeClass("danger");
// 					$(this).parent().parent().addClass("success");
// 				}
// 		}
// 	});

// 	$("input[name='statut-checkbox']").click(function() {
// 		// Si la case est cochée, on change la class de la ligne
// 		if ($(this).is(":checked")) {
// 			$(this).parent().parent().removeClass("danger");
// 			$(this).parent().parent().addClass("success");
// 		} else if ($(this).is(":not(:checked)")) {
// 		$(this).parent().parent().addClass("danger");
// 		}
// 	});

// });



// }, 1500)

// $("[name='statut-checkbox']").bootstrapSwitch('state');








// // var refresh_switch = setInterval(function() {
// //  $.ajax('index.php table', function() {
  
// //   $("[name='statut-checkbox']").bootstrapSwitch('state'); //code to init the switch again
// //  });

// // }, 1000)


// // $.get('index.php table', function(data) {
// //  $("#box-table").html(data);
// //  $("[name='statut-checkbox']").bootstrapSwitch('state'); //code to init the switch again
// // }










// // End
// });
