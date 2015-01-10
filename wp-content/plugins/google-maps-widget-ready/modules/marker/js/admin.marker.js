var gmpMarkersTblColumns = []
,	gmpMarkersTbl = null;
jQuery(document).ready(function(){
	jQuery('.gmp_marker_address').mapSearchAutocompleateGmp({
		msgEl: '.gmpAddrErrors'
	,	onSelect: function(item) {
			jQuery('#gmp_marker_coord_y').val(item.lat);
			jQuery('#gmp_marker_coord_x').val(item.lng);
		}
	});
	/*jQuery('.gmp_marker_address').keydown(function(){
		//clearTimeout(gmpTypeInterval);
	});
	jQuery('.gmp_marker_address').keyup(function(){
		var addr = jQuery(this).val()
		,	form = jQuery(this).parents('form:first');
		gmpTypeInterval = setTimeout(function(){
			startSearchAddress(addr, form);
		}, 1200);
		startSearchAddress(addr, form, '.gmpAddrErrors', jQuery(this));
	});*/
	gmpRefreshMarkerList();
});
function gmpRemoveMarkerItemFromMarkerForm() {
	var markerId = parseInt(jQuery('#gmpAddMarkerToEditMap').find('[name="marker_opts[id]"]').val());
	gmpRemoveMarkerItem(markerId, {
		msgEl: '#gmpUpdateMarkerItemMsg'
	,	returnToMarkersList: true
	,	clearForm: true
	});
}
function gmpRemoveMarkerItemFromMapForm() {
	var markerId = parseInt(jQuery('#gmpAddMarkerToEditMap').find('[name="marker_opts[id]"]').val());
	gmpRemoveMarkerItem(markerId, {
		msgEl: '#gmpSaveEditedMapMsg'
	,	clearForm: true
	,	onSuccess: function() {
			gmpRemoveMarkerFromMapMarkersTable(markerId);
			jQuery('.removeMarkerFromForm').attr('disabled', 'disabled');
		}
	});
}
function gmpRemoveMarkerItem(markerId, params) {
	if(!markerId)
		return false;
	if(confirm(toeLangGmp('Are you sure want to remove marker?'))) { 
		params = params || {};
		var sendData = {
			mod: 'marker'
		,	action: 'removeMarker'
		,	reqType: 'ajax'
		,	id:  markerId
		}
		,	msgEl = params.msgEl ? params.msgEl : jQuery('#gmpMarkerListTableLoader_'+ markerId);
		if(typeof(msgEl) === 'string')
			msgEl = jQuery(msgEl);
		jQuery.sendFormGmp({
			msgElID: msgEl
		,	data: sendData
		,	onSuccess: function(res) {
				if(!res.error) {
					gmpRefreshMarkerList();
					if(msgEl.parents('#gmpTableMarkers').size()) {	// For case when we remove it from table
						setTimeout(function(){
							msgEl.parents('tr:first').hide('500', function(){
								jQuery(this).remove();
							});
						}, 500);
					}
					if(params.returnToMarkersList) {
						setTimeout(function(){
							jQuery('.gmpCancelMarkerEditing').trigger('click');
						}, 500);
						msgEl.html('');
					}
					if(params.clearForm) {
						gmpClearMarkerForm();
					}
					if(params.onSuccess && typeof(params.onSuccess) === 'function') {
						params.onSuccess();
					}
				}
			}
		});
	}
}
function gmpMarkerDescSetContent(content) {
	if(tinyMCE.get('marker_opts_description'))
		tinyMCE.get('marker_opts_description').setContent(content);
}
function gmpMarkerDescGetContent() {
	if(tinyMCE.get('marker_opts_description'))
		return tinyMCE.get('marker_opts_description').getContent();
	return '';
}

function gmpEditMarkerItem(markerId) {
	selectTabMainGmp('gmpMarkerList');
	gmpAddMarkerFormToMarker();
	gmpClearMarkerForm();
	jQuery('#gmpAddMarkerToEditMap').find('.gmapMarkerFormControlButtons').show();
    gmpCurrentMarkerForm = jQuery('#gmpAddMarkerToEditMap');
    //var removeBtn = gmpCurrentMarkerForm.find('.gmpDeleteMarker');
	
	//removeBtn.removeAttr('onclick');
	//removeBtn.attr('onclick', 'return gmpDeleteMarker('+ markerId+ ')');

    jQuery('.markerListConOpts').removeClass('active');
    jQuery('.gmpMarkerEditForm').addClass('active');
    
    /*if(typeof(gmpExistsMarkers) == 'undefined') {
        return false;
    }*/
    var currentMarker = getDataTableRow(gmpMarkersTbl, markerId);
    /*,	currentMarkerForm = jQuery('#gmpEditMarkerForm')*/
	
    /*for(var i in gmpExistsMarkers){
        if(gmpExistsMarkers[i].id == markerId){
            currentMarker = gmpExistsMarkers[i];
			break;
        }
    }*/
	var showMarkerForm = function(currentMarker){
		if(currentMarker) {
			fillFormData({
				form: '#gmpAddMarkerToEditMap'
			,	data: currentMarker
			,	arrayInset: 'marker_opts'
			});
			fillFormData({
				form: '#gmpAddMarkerToEditMap'
			,	data: currentMarker.params
			,	arrayInset: 'marker_opts[params]'
			});
			setcurrentIconToForm(currentMarker.icon, jQuery('#gmpAddMarkerToEditMap'));
			// Clear description in any case
			gmpMarkerDescSetContent('');
			if(currentMarker.description)
				gmpMarkerDescSetContent(currentMarker.description);
			jQuery('#gmpAddMarkerToEditMap').find('[name="marker_opts[params][title_is_link]"]').trigger('change');
			// For prev. versions - those parameters is just undefined, and will not be in fillFormData(), so uncheck this manualy here
			if(typeof(currentMarker.params.more_info_link) === 'undefined') {
				jQuery('#marker_optsparamsmore_info_link_check').removeAttr('checked').trigger('change');
			}
			if(typeof(currentMarker.params.more_info_link) === 'undefined') {
				jQuery('#marker_optsparamsmore_info_link_check').removeAttr('checked').trigger('change');
			}
			gmpDrawMap({
				mapContainerId: 'gmpMapForMarkerEdit'
			,	options: {
					center: {
						lat: currentMarker.coord_y
					,	lng: currentMarker.coord_x
					}
				,	zoom: 15
				}
			});
			drawMarker(jQuery.extend(currentMarker, {
				icon: currentMarker.icon
			,	position: {
					coord_x: currentMarker.coord_x
				,	coord_y: currentMarker.coord_y
				}
			,	title: currentMarker.title
			,	desc: currentMarker.description
			,	id: currentMarker.id
			,	group_id: currentMarker.marker_group_id
			,	animation: currentMarker.animation
			//,	titleLink: currentMarker.titleLink
			}));
			gmpIsMapEditing.state = false;
			//gmpIsMapEditing.markerData = jQuery(gmpAdminOpts.forms.gmpEditMarkerForm.formObj).serialize();
			jQuery('#gmpEditMarkerForm').find('input,select,textarea').change(function(){
				gmpIsMapEditing.state = true;
			});
			// Scroll to top in case we were on the bottom of the page
			window.scrollTo(0, 0);
		} else
			window.location.reload();
	};
	if(!currentMarker) {
		jQuery.sendFormGmp({
			msgElID: jQuery('<div class="gmpFullScreenLoader" id="gmpGetMarkerLoader" />').appendTo('body')
		,	data: {page: 'marker', action: 'getMarker', reqType: 'ajax', id: markerId}
		,	onSuccess: function(res) {
				if(!res.error) {
					showMarkerForm(res.data.marker);
				}
				jQuery('#gmpGetMarkerLoader').hide(500, function(){
					jQuery('#gmpGetMarkerLoader').remove();
				});
			}
		});
	} else {
		showMarkerForm(currentMarker);
	}
}
function gmpRefreshMarkerList() {
	if(gmpMarkersTbl) {
		gmpMarkersTbl.fnDestroy();
	}

	var columns = [];
	if(gmpMarkersTblColumns) {
		for(var key in gmpMarkersTblColumns) {
			columns.push({
				mData: key, sClass: key/*, sWidth: (gmpMarkersTblColumns[key].width ? gmpMarkersTblColumns[key].width : false)*/
			});
		}
	}
	var iDisplayLength = gmpGetDataTableDefDisplayLen('gmpTableMarkers');
	gmpMarkersTbl = jQuery('#gmpTableMarkers').dataTable({
		bProcessing: true
	,	bServerSide: true
	,	sAjaxSource: createAjaxLinkGmp({page: 'marker', action: 'getListForTable', reqType: 'ajax'})
	,	aoColumns: columns
	,	sPaginationType: 'full_numbers'
	,	iDisplayLength: iDisplayLength
	,	fnDrawCallback: function(dataTbl){
			gmpSetDataTableDefDisplayLen(jQuery(dataTbl.nTable).attr('id'), dataTbl._iDisplayLength);
			gmpSwitchDataTablePagination(dataTbl);
		}
	});

   /* var sendData ={
        mod     :   'marker',
        action  :   'refreshMarkerList',
        reqType :   'ajax'
    }
    jQuery("#GmpTableMarkers").remove();
    jQuery(".gmpMTablecon").addClass("gmpMapsTableListLoading");
    jQuery.sendFormGmp({
        msgElID:"",
        data:sendData,
        onSuccess:function(res){
            if(!res.error){
                jQuery(".gmpMTablecon").removeClass("gmpMapsTableListLoading")
                jQuery(".gmpMTablecon").html(res.html);
                datatables.reCreateTable("GmpTableMarkers");
            }else{
               
            }
        }
    })   */  
}
/*function gmpGetEditMarkerFormData(form) {
    if(typeof(form)=='undefined'){
        form=jQuery("#gmpEditMarkerForm");
    }
    var params={
        goup_id     :   form.find("#gmp_marker_group").val(),
        title       :   form.find("#gmp_marker_title").val(),
        address     :   form.find("#gmp_marker_address").val(),
        desc        :   tinyMCE.activeEditor.getContent(),
        position    :{
                        coord_x     :   form.find("#gmp_marker_coord_x").val(),
                        coord_y     :   form.find("#gmp_marker_coord_y").val(),            
                    },
        animation   :   form.find("input[type='hidden'].marker_opts_animation").val()
    }
    
         params.titleLink={
               linkEnabled:false
         }
        if(form.find('.title_is_link').is(":checked")){
             params.titleLink.linkEnabled = true;
             params.titleLink.link = form.find(".marker_title_link").val();
        }
    
        params.icon={
             id:form.find("#gmpSelectedIcon").val()
            }
        try{
            params.icon.path=gmpExistsIcons[params.icon.id].path;
        }catch(e){
            
        }
    
    return params;
}
function gmpDrawEditedMarker(markerId){
        var params = gmpGetEditMarkerFormData();
        var currentMarker = markerArr[markerId];
        updateMarker({
            icon:params.icon,
            id  :markerId,
            coord_x:params.position.coord_x,
            coord_y:params.position.coord_y,
            animation:params.animation,
            icon:params.icon.id,
            title:params.title,
            description:params.desc,
            group_id:params.group_id,
            titleLink:params.titleLink,
     },jQuery("#gmpEditMarkerForm"),true);    
}
function gmpSaveUpdatedMarker(markerId){
//    var params = gmpGetEditMarkerFormData();
    var params = gmpAdminOpts.getMarkerFormData("gmpEditMarkerForm");
    params.desc = gmpGetEditorContent(1);
    params.goup_id = params.group_id;
	var icon_id = params.icon;
	params.icon={
		id:icon_id
	} 
    params.id=markerId;
    params.address = gmpAdminOpts.forms.gmpEditMarkerForm.formObj.find(".gmpMarkerAddressOpt").val();
    var sendData={
                 mod            : "marker",
                 action         : "updateMarker",
                 reqType        : "ajax",
                 markerParams   : params
    }

    var respElem = jQuery("#gmpEditMarkerForm").find("#gmpUpdateMarkerItemMsg");
    jQuery.sendFormGmp({
        msgElID:respElem,
        data:sendData,
        onSuccess:function(res){
            if(res.error){
                respElem.html(res.errors.join(","));
            }else{
                //setTimeout(function(){
                   // jQuery(".markerListConOpts").toggleClass('active');
                   // clearMarkerForm(jQuery("#gmpEditMarkerForm"));
                   // gmpRefreshMarkerList();
                   // respElem.empty();
                //},800);
            }
        }
    })
    return false;
}*/
function cancelEditMarkerItem(params) {
    clearMarkerForm(jQuery('#gmpEditMarkerForm'));
    gmpRefreshMarkerList();
	if(typeof(params) != 'undefined' && params.changeTab) {
    
    } else {
		jQuery('.markerListConOpts').toggleClass('active');
    }
    return false;
}
/*function gmpDeleteMarker(markerId) {
        var marker=markerArr[markerId];
        gmpRemoveMarkerObj(marker);
        cancelEditMarkerItem();
}*/
var gmpTypeInterval;                //timer identifier
var gmpDoneTypingInterval = 5000;  //time in ms, 5 second for example

function gmpIsMarkerFormEditing(){
    if(gmpCurrentMarkerForm.find(".gmpMarkerTitleOpt").val()!=""){
        return true;
    }
    if(gmpCurrentMarkerForm.find(".gmpMarkerTitleIsLinkOpt").prop("checked")){
        return true;
    }
    if(gmpCurrentMarkerForm.find(".marker_optsanimation").prop("checked")){
        return true;
    }
    if(tinyMCE.activeEditor.getContent()!=""){
        return true;
    }
    if(gmpCurrentMarkerForm.find(".gmpMarkerAddressOpt").val()!=""){
        return true;
    }
    if(gmpCurrentMarkerForm.find(".gmpMarkerTitleOpt").val()!=""){
        return true;
    }
    if(gmpCurrentMarkerForm.find(".gmpMarkerCoordXOpt").val()!=""){
        return true;
    }
    if(gmpCurrentMarkerForm.find(".gmpMarkerCoordYOpt").val()!=""){
        return true;
    }
    return false;  
}
function gmpAddNewMarker(param){
	var canClearMarkerForm = !isAdminFormChanged('gmpAddMarkerToEditMap') || confirm(toeLangGmp('Cancel Editind And Add New Marker'));
	if(canClearMarkerForm) {
		var markerForm = param.markerForm ? param.markerForm : gmpCurrentMarkerForm;
		clearMarkerForm(markerForm);
		// In any case - changes will be erased
		adminFormSavedGmp(jQuery(markerForm).attr('id'));
	}
    /*if(isAdminFormChanged('gmpAddMarkerToEditMap')) {
        if(confirm(toeLangGmp('Cancel Editind And Add New Marker'))) {
            
        }
    }*/
	
    /*if(gmpIsMarkerFormEditing()) {
        if(confirm(toeLangGmp('Cancel Editind And Add New Marker'))) {
            clearMarkerForm(param.markerForm ? param.markerForm : gmpCurrentMarkerForm);
        }
    }*/
}
function gmpClearMarkerForm() {
	jQuery('#gmpAddMarkerToEditMap')[0].reset();
	jQuery('#gmpAddMarkerToEditMap').find('[name="marker_opts[id]"]').val(0);
	jQuery('#gmpAddMarkerToEditMap').find('[name="marker_opts[map_id]"]').val(0);
	jQuery('#gmpAddMarkerToEditMap').find('[name="marker_opts[description]"]').val('');
	jQuery('#gmpAddMarkerToEditMap').find('.gmapMarkerFormControlButtons').hide();
	jQuery('.removeMarkerFromForm').attr('disabled', 'disabled');
}