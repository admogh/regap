/**  js for Regap Admin Page
 *
 * @author	rabbits <rbtsgm at gmail.com>
 * @package	Regap1
 */

$(function(){
	var strUA = "";
	strUA = navigator.userAgent.toLowerCase();
	if (strUA.indexOf("msie")!=-1) {
		$.ajaxSetup({ ifModified: true });
	}
        // window name
	window_name = "regap_template";
	for( i=0; i<16; i++ ) {
	    window_name += Math.floor(Math.random()*16).toString(16);
	}
	window.name = window_name; 

	$("#action-menu-change input[@type=submit]").click(function(){
		if (!confirm('<?php print(REGAP_STRING_TEMPLATE_ACTION_CHANGE_CONFIRM); ?>')) {
			return false;
		}
		$("form").attr('action',"<?php print(get_action_link()); ?>"+$(this).attr('name'));
	});

	$("#check-action-menu-delete input[@type=submit]").click(function(){
		if (!confirm('<?php print(REGAP_STRING_EDIT_TEMPLATE_ACTION_DELETE_CONFIRM); ?>')) {
			return false;
		}
		var b = false;
		$("td.check input[@type=checkbox]").each(function(){
			if ($(this).attr('checked')) {
				b = true;
			}
		});
		if (!b) {
			alert('<?php print(REGAP_STRING_TEMPLATE_ACTION_DELETE_ALERT); ?>');
			return false;
		}

		$("form").attr('action',"<?php print(get_action_link()); ?>"+$(this).attr('name'));
	});

	$("th input[@type=checkbox]").click(function(){
		if ($(this).attr('checked')) {
			check = true;
		}
		else {
			check = false;
		}

		$("td input[@type=checkbox]").attr('checked', check);
	});

	$("#action-menu-upload a").click(function(){
		wn = windowOpen(400, 250, "location=no, menubar=no, status=no, scrollbars=yes, resizable=yes, toolbar=no", "regap_template_upload_");
		$(this).attr('target',wn);
	});

	$("span.expander").click(function(){
		if ($(this).filter(".expanded").length) {
			$(this).removeClass("expanded").addClass("collapsed");
			$(this).siblings().hide();
			$(this).attr("title","<?php print(REGAP_STRING_TEMPLATE_LIST_EXPAND); ?>");
			return;
		}

		if ($(this).filter(".collapsed").length) {
			$(this).removeClass("collapsed").addClass("expanded");
			$(this).siblings().show();
		}
		else {
			$(this).addClass("expanded");
			$(this).after('<br><span class="loading">Loading...</span>');
			var loading = $(this).next().next();
			//loading.find("span.loading").text("Loading ...");
			var url = "<?php print(get_action_link("edit_template")); ?>"+"&edit_template_id="+$(this).parent("td").parent("tr").children("td.edit_template_id").text();
			$.ajax({
				type: "GET",
				url: url,
				dataType: "html",
				success: function(data) {
					var datas = data.replace(/^<!DOCTYPE[^>]+>/, "").split("</ul>");
					if (datas.length) {
						$(datas).each(function() {
							var list = $(this+"");
							loading.before(list);
						});
						loading.prev("br").remove();
						loading.remove();
					}
					else {
						loading.find("span.loading").text("").append("<i>(empty)</i>").removeClass("loading");
					}
				},
				error: function(req, err, exc) {
					loading.find("span.loading").text("").append("<i>(error)</i>").removeClass("loading");
				}
			});
		}
		$(this).attr("title","<?php print(REGAP_STRING_TEMPLATE_LIST_FOLD); ?>");
	});

	$("#page-menu-edit").click(function(){
		var template_path = $("select[@name=template] option:selected").val();
		this.href += '&template=' + template_path;
	});

	$("#all-select-field-value").click(function(){
		$("input[@type=checkbox]").attr('checked', true);
	});

	$("#all-reset-field-value").click(function(){
		$("input[@type=checkbox]").attr('checked', false);
	});
});


