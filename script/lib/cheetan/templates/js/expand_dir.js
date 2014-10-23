// modified for Regap by rabbits.
// Enable expanding/folding folders in TracBrowser

(function($){
  var FOLDERID_COUNTER = 0;
  var SUBFOLDER_INDENT = 20;
  
  // enableExpandDir adds the capability to folder rows to be expanded and folded
  // It also teach the rows about their ancestors. It expects:
  //  - `parent_tr`, the logical parent row (`null` if there's no ancestor)
  //  - a `rows` jQuery object matching the newly created entry rows
  //  - `qargs`, additional parameters to send to the server when expanding
  
  window.enableExpandDir = function(parent_tr, rows, qargs) {
    // the ancestors folder ids are present in the parent_tr class attribute
    var ancestor_folderids = [];
    parent_check = false;
    if (parent_tr) {
      ancestor_folderids = $.grep(parent_tr.attr("class").split(" "), 
                                  function(c) { return c.match(/^f\d+$/)});
      parent_check = parent_tr.children("td.name").children("div").children("input[@type=checkbox]").attr('checked');				  	
    }
    rows.each(function () {
      var a = $(this).find("a.dir");
  
      if (a.length) { // then the entry is a folder
        // create new folder id
        var folderid = "f" + FOLDERID_COUNTER++;
        this.id = folderid;
        $(this).addClass(folderid);
  
        // add the expander icon
        a.wrap('<div></div>');
	if (parent_check) {
		checkbox = '<input type="checkbox" checked name="check[]" value="' + a.text() + '">';
	}
	else {
		checkbox = '<input type="checkbox" name="check[]" value="' + a.text() + '">';
	}
        var expander = a.before('<span class="expander">&nbsp;</span>'+checkbox).prev();
	a.prev("input[@type=checkbox]").click(function(){
		var check = false;
		if($(this).attr('checked')) {	
			check = true;
		}
		else {
			check = false;
		}

		// child check
		var cur_tr = $(this).parents("tr");
		var cur_id = cur_tr.attr('id');
		var cur_class = cur_tr.attr('class');
		// for child
		cur_tr.siblings("tr").each(function(){
			if ($(this).hasClass(cur_id)) {
				//alert($(this).attr('class'));
				// dir
				$(this).children("td.name").children("div").children("input[@type=checkbox]").attr('checked',check);
				// file
				$(this).children("td.name").children("input[@type=checkbox]").attr('checked',check);
			}
		});
		
		// parent check
		if (<?php print((REGAP_PAGE_LIST_PARENT_CHECK)? 1 : 0); ?>) {

		// 親のIDを調べて（複数）、そのIDを持つクラス（子供）が全てチェック済みなら、その親もチェック。逆も叱り。  
               parent_ids = new Array();
               // get parent ids
               cur_tr.siblings("tr").each(function(){
                       var id = $(this).attr('id');
                       if (id != "" && cur_class.indexOf(id)!=-1) {
                               parent_ids.push(id);
                       }
               });
               parent_ids.sort().reverse();
               // for parent
               for(i=0; i<parent_ids.length; i++) {
                       id = parent_ids[i];
                       all_select = true;
                       all_reset = true;
                       cur_tr.siblings("tr").each(function(){
                               if ($(this).attr('class').indexOf(id)!=-1 && $(this).attr('id') != id) {
                                       // child'class have parent_id
                                       if ($(this).attr('id')=="") {
                                               // file
                                               check = $(this).children("td.name").children("input[@type=checkbox]").attr('checked');
                                       }
                                       else {
                                               // dir
                                               check = $(this).children("td.name").children("div").children("input[@type=checkbox]").attr('checked');
                                       }
                                       if (check) {
                                               if (all_reset) all_reset = false;
                                       }
                                       else {
                                               if (all_select) all_select = false;
                                       }
                               }
                       });
		       //alert("all_select:"+all_select+",all_reset:"+all_reset);
                       // parent check(dir only)
			if (cur_tr.attr('class').indexOf(id)!=-1) {
				//alert(cur_tr.attr('class'));
				if (cur_tr.children("td.name").children("div").children("input[@type=checkbox]").attr('checked')) {
					all_reset = false;
				}
				else {
					all_select = false;
				}
			}
//alert("all_select:"+all_select+",all_reset:"+all_reset);
                       //alert(all_select);
                       //alert(all_reset);
                       //alert($("#"+id).attr('class'));
                       if (all_select) {
                               $("#"+id).children("td.name").children("div").children("input[@type=checkbox]").attr('checked',true);
                       }
//                       else if (all_reset) {
			else {
                               $("#"+id).children("td.name").children("div").children("input[@type=checkbox]").attr('checked',false);
                       }
               }

	       }


	});	// end of clidk

	a.after('<a href="<?php print(get_action_link('page_edit')); ?>&path='+a.text()+'"><img src="img/new.gif" title="<?php print(REGAP_STRING_LOGIN_CONTENTS_TREE_NEW); ?>"></a>');
        expander.prev().attr("title", "<?php print(REGAP_STRING_PAGE_LIST_EXPAND); ?>")
          .click(function() { toggleDir($(this), qargs); });
      }

 
      // tie that row to ancestor folders
      if (parent_tr)
        $(this).addClass(ancestor_folderids.join(" "));
    });	// end of row each
  }	// end of enableExpandDir
  
  // handler for click event on the expander icons
  window.toggleDir = function(expander, qargs) {
    var tr = expander.parents("tr");
    var folderid = tr.get(0).id;
  
    if ( tr.filter(".expanded").length ) { // then *fold*
      tr.removeClass("expanded").addClass("collapsed");
      tr.siblings("tr."+folderid).hide();
      expander.attr("title", "<?php print(REGAP_STRING_PAGE_LIST_EXPAND); ?>");
      return;
    }
  
    if ( tr.filter(".collapsed").length ) { // then *expand*
      tr.removeClass("collapsed").addClass("expanded");
      tr.siblings("tr."+folderid).show();
      // Note that the above will show all the already fetched subtree,
      // so we have to fold again the folders which were already collapsed.
      tr.siblings("tr.collapsed").each(function() {
        tr.siblings("tr."+this.id).not(this).hide();
      });
    } else {                                // then *fetch*
      var td = expander.parents("td");
      var td_class = td.attr("class");
      var a = expander.next().next("a");
      var depth = 
        parseFloat(td.css("padding-left").replace(/^(\d*\.\d*).*$/, "$1")) + 
        SUBFOLDER_INDENT;
  
      tr.addClass("expanded");
      // insert "Loading ..." row
      tr.after('<tr><td><span class="loading"></span></td></tr>');
      var loading_row = tr.next();
      loading_row.children("td").addClass(td_class)
        .attr("colspan", tr.children("td").length)
        .css("padding-left", depth);
      loading_row.find("span.loading").text("Loading " + a.text() + "...");
      // XHR for getting the rows corresponding to the folder entries
      $.ajax({
        type: "GET",
        url: a.attr("href"),
        data: qargs,
        dataType: "html",
        success: function(data) {
          // Safari 3.1.1 has some trouble reconstructing HTML snippets
          // bigger than 50k - splitting in rows before building DOM nodes
	  //alert(data);
          var rows = data.replace(/^<!DOCTYPE[^>]+>/, "").split("</tr>");
          if (rows.length) {
	  	/*
		alert(rows.length);
		for (var i = 0; i< rows.length; i++) {
			alert(rows[i]);
		}
		*/
            // insert entry rows 
            $(rows).each(function() {
              row = $(this+"</tr>");
              row.children("td."+td_class).css("padding-left", depth);
	      // expand check for file
	      var check = a.prev().attr('checked');
	      row.children("td.name").children("input[@type=checkbox]").attr('checked',check);
	      // parent check for file
	      row.children("td.name").children("input[@type=checkbox]").click(function(){

	      if (<?php print((REGAP_PAGE_LIST_PARENT_CHECK)? 1 : 0); ?>) { 
	      	var cur_tr = $(this).parents("tr");
	    	var check = false;
		if ($(this).attr('checked')) {
			check = true;
		}
		else {
			check = false;
		}

		parent_ids = new Array();
		// get parent ids 
		cur_tr.siblings("tr").each(function(){
			var id = $(this).attr('id');
			if (id != "" && cur_tr.attr('class').indexOf(id)!=-1) {
				parent_ids.push(id);
			}
		});
		parent_ids.sort().reverse();
		//alert(parent_ids.length);
		// for parent
		for(i=0; i<parent_ids.length; i++) {
			id = parent_ids[i];
			//alert(id);
			all_select = true;
			all_reset = true;
			cur_tr.siblings("tr").each(function(){
				if ($(this).attr('class').indexOf(id)!=-1 && $(this).attr('id') != id) {
					// child'class have parent_id
					if ($(this).attr('id')=="") {
						// file
						check = $(this).children("td.name").children("input[@type=checkbox]").attr('checked');
					}
					else {
						// dir
						check = $(this).children("td.name").children("div").children("input[@type=checkbox]").attr('checked');
					}
					if (check) {
						if (all_reset) all_reset = false;
					}
					else {
						if (all_select) all_select = false;
					}
				}
			});
			if(cur_tr.attr('class').indexOf(id)!=-1) {
				if (cur_tr.children("td.name").children("input[@type=checkbox]").attr('checked')) {
					all_reset = false;
				}
				else {
					all_select = false;
				}
			}
			if (all_select) {
				$("#"+id).children("td.name").children("div").children("input[@type=checkbox]").attr('checked',true);
			}
			//else if (all_reset) {
			else {
				$("#"+id).children("td.name").children("div").children("input[@type=checkbox]").attr('checked',false);
			}
		}
		}
	      });	// end of click
	      


              // make all entry rows collapsible but only subdir rows expandable
              enableExpandDir(tr, row, qargs); 
              loading_row.before(row);
            });	// end of rows.each
           // remove "Loading ..." row
            loading_row.remove();
          } else {	// rows.length
            loading_row.find("span.loading").text("").append("<i>(empty)</i>")
              .removeClass("loading");
            // make the (empty) row collapsible
            enableExpandDir(tr, loading_row, qargs); 
          }	// rows.length
        },	// success
        error: function(req, err, exc) {
          loading_row.find("span.loading").text("").append("<i>(error)</i>")
            .removeClass("loading");
          enableExpandDir(tr, loading_row, qargs);
        }
      });
    }
    expander.attr("title", "<?php print(REGAP_STRING_PAGE_LIST_FOLD); ?>");
  }

})(jQuery);
