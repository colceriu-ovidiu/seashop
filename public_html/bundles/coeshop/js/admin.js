$(function() {
	
	$(".act_delete").click(function() {
		return confirm("Sunteti sigur ca doriti sa stergeti <" + $(this).attr("alt") + "> ?");
	});

	$("#btn_send").click(function() {
		return confirm("Sunteti sigur ca doriti sa trimiteti ?");
	});


	$("table.listing td").hover(function() {
		$(this).parent().children().addClass('row_hover');
	}, function() {
		$(this).parent().children().removeClass('row_hover');
	});


	$(".order_row").click(function() {
	  alert("Handler for .click() called.");
	});

	/*$(".product_down").searchable({
		maxListSize: 100, 
		maxMultiMatch: 50,
		exactMatch: false,
		wildcards: true,
		ignoreCase: true,
		warnMultiMatch: 'top {0} matches ...',
		warnNoMatch: 'no matches ...',
		latency: 200,
		zIndex: '1000'
	});*/


});