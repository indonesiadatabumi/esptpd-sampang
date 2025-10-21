/**
 * getPengenaan
 * @returns
 */
var getPengenaan = function (objSptPajak, objDasarPengenaan, objPersen) {
	
	alert(objDasarPengenaan);
	if ($('#' + objPersen).val() == "" && $('#' + objPersen).val() == 0) {
		var pajak = Math.round((unformatCurrency($('#' + objSptPajak).val()) * 1));
	} else {
		var pajak = Math.round((unformatCurrency($('#' + objSptPajak).val()) * 1)* (100 / ($('#' + objPersen).val() * 1)));
	}
	
	$('#'+objDasarPengenaan).val(formatCurrency(pajak));
};
/*
	$("#fDate, #tDate").datepicker({
   	   	dateFormat: "dd-mm-yy",
   	 	showOn: "both",
		buttonImage: "images/calendar.gif",
		buttonImageOnly: true,
		constrainInput: true,
		duration: "fast",
		beforeShow: function(){
			$("#ui-datepicker-div").css("zIndex", 99999);
			
			if ( $.browser.msie && $.browser.version == "6.0") {
				setTimeout(function() {
					$('#ui-datepicker-div').css('position', "absolute");
					$('#ui-datepicker-div').bgiframe();
				}, 10);
			}
		},
		onSelect: function( selectedDate ) {
			if (this.id == "fDate") {
				ldmonth(this);
			}
		}
   	});
*/
var ldmonth = function(obj) {
	var T=obj.value;  
	var D=new Date();    
	var dt=T.split("/");  
	D.setFullYear(dt[2]);  //alert("__1_>"+D.toString());  
	D.setMonth(dt[1]-1); // alert("__2_>"+D.toString());  
	D.setDate("32");   
	var ldx = 32-D.getDate(); 
	var m=D.getMonth();
	if (m == "0") m="12"; 
	if (m<10) m="0"+m;
	var ldo = ldx +"/"+ m +"/"+ dt[2]; //D.getFullYear();
	if (ldo != "NaN-NaN-undefined") {
		$('input[name=spt_periode_jual2]').val(ldo);
	} else {
		$('input[name=spt_periode_jual2]').val('');
	}
};

$(function() {
    $("#spt_tgl_proses, #spt_tgl_entry").datepicker({
      dateFormat: "dd/mm/yy",
	  showOn: "button",
      buttonImage: "../images/calendar.gif",
      buttonImageOnly: true,
	  duration: "fast",
	  maxDate: "D",
      buttonText: "Select date"
    });
    $('#spt_tgl_proses, #spt_tgl_entry').datepicker('setDate', 'c');
	
	$("#fDate, #tDate").datepicker({
      dateFormat: "dd/mm/yy",
	  showOn: "button",
      buttonImage: "images/calendar.gif",
      buttonImageOnly: true,
      buttonText: "Select date",
	  onSelect: function( selectedDate ) {
	  	if (this.id == "fDate") {
			ldmonth(this);
		}
	  }
    });
	
	$("#spt_tgl_proses, #spt_tgl_entry, #fDate, #tDate").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
	
	$("#korek_persen_tarif").change(function() {
		getPengenaan('spt_pajak','spt_nilai','korek_persen_tarif');
	});
});
