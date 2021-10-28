$(document).ready(function() {
	$("[data-toggle=offcanvas]").click(function() {
		$(".row-offcanvas").toggleClass("active")
	})
});
$(function() {
	$("a, button").click(function() {
		$(this).toggleClass("active")
	})
});
var number_selected = "";
$(function() {
	$(".number_check").click(
			function() {
				$("#group_num_selector").val("selected");
				if (typeof (number_exclusive) != "undefined"
						&& number_exclusive) {
					$.each($(".number_check"), function(b, c) {
						$(this).attr("class", "number_check")
					})
				}
				if ($(this).attr("class") == "number_check") {
					$(this).attr("class", "number_check selected")
				} else {
					$(this).attr("class", "number_check")
				}
				var a = "";
				$.each($(".number_check"), function(b, c) {
					if ($(this).attr("class") == "number_check selected") {
						a += ((a != "") ? (".") : (""))
								+ (((b + 1) < 10) ? ("0") : ("")) + (b + 1)
					}
				});
				$("[name=numbers_selected]").val(a);
				if (typeof (number_exclusive) != "undefined"
						&& number_exclusive) {
					$("#parameters_form").submit()
				}
			}).mouseover(function() {
		document.body.style.cursor = "pointer"
	})
});
$(document).ready(function() {
	$(".tree-toggler").click(function() {
		$(this).parent().parent().children(".tree.stem").toggle(300);
		$(this).toggleClass("glyphicon glyphicon-folder-open").animate(300);
		$(this).toggleClass("glyphicon glyphicon-folder-close").animate(300)
	})
});
var last_width = 0;
$(function() {
	if (typeof (last_width) == "undefined") {
		last_width = 0
	}
	last_width = $(window).width();
	if ($(window).width() > 767) {
		$("#accordion .collapse").addClass("in");
		$("#accordion-content .collapse").addClass("in");
		$(".accordion-toggle collapsed").toggleClass(".accordion-toggle")
	} else {
		$("#accordion .collapse").removeClass("in");
		$("#accordion-content .collapse").removeClass("in");
		$(".accordion-toggle").toggleClass(".accordion-toggle collapsed")
	}
	$("select").change(function(a) {
		$("#parameters_form").submit()
	});
	$("#parameters_form").submit(function(a) {
	});
	$(window).resize(function() {
		if ($(window).width() > 767) {
			if (last_width <= 767) {
				$("#accordion-content .collapse").addClass("in");
				$("#accordion .collapse").addClass("in");
				$(".accordion-toggle collapsed").collapse("hide")
			}
		} else {
			if (last_width > 767) {
				$("#accordion-content .collapse").removeClass("in");
				$("#accordion .collapse").removeClass("in");
				$(".accordion-toggle").collapse("show")
			}
		}
		last_width = $(window).width()
	})
});