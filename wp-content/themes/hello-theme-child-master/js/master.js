	debugger;
	 jQuery(function () {
      jQuery(".nm").click(function () {
				  var number_selected = ""; 
          if (jQuery(this).attr("class") == "nm") {
              jQuery(this).attr("class", "nm selected")
							number_selected = jQuery(this).text();
          } else {
              jQuery(this).attr("class", "nm")
							number_selected = jQuery(this).text();
          }
          var a = "";
          jQuery.each(jQuery(".nm"), function (b, c) {
              if (jQuery(this).attr("class") == "nm selected") {
                a += ((a != "") ? (".") : ("")) + (((b + 1) < 10) ? ("0") : ("")) + (b + 1);
              }
          });
				// number_selected = a.split();
				jQuery.each(jQuery(".num"), function (b, c) {
							if (jQuery(this).text() == number_selected) {
								if (jQuery(this).attr("class").search("evidenzia_lotto") > -1){
										jQuery(this).removeClass("evidenzia_lotto" );
									} else {
										jQuery(this).addClass("evidenzia_lotto" );
									}
							}
             
          });
          jQuery("[name=formazione]").val(a);
          jQuery("#sel_num").html(a);
      })
  });