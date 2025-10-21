/**
 * Numbers Only
 */
var numbersonly = function (myfield, e, dec) {
	var key;
	var keychar;

	if (window.event) {
		 key = window.event.keyCode;
	} else if (e) {
		 key = e.which;
	} else {
		 return true;
	}

	keychar = String.fromCharCode(key);

	// control keys
	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) {
		return true;
	} else if ((("0123456789").indexOf(keychar) > -1)) { // numbers
		return true;
	} else if (dec && (keychar == ".")) { // decimal point jump
		myfield.form.elements[dec].focus();
		return false;
	} else {
		return false;
	}
};
/**
 * unformatedCurrency
 * @param num
 * @returns
*/
var unformatCurrency = function (num) {
	if (num != "" || num != "undefined") {
		num = num.toString().replace(/\$|\,00/g,'').replace(/\$|\./g,'');
	}
	return num;
};

/**
 * formatCurrency
 * @returns
*/
var formatCurrency = function(num, id) {
	if (num != "" || num != "undefined") {
		num = num.toString().replace(/\$|\,00/g,'').replace(/\$|\./g,'');
		if(isNaN(num)) {
			showWarning('Mohon Isi Dengan Angka');
			$('#' + id).focus();
			return(num);
		} else {
			sign = (num == (num = Math.abs(num)));
			num = Math.floor(num*100+0.50000000001);
			cents = num%100;
			num = Math.floor(num/100).toString();
			if(cents<10)
				cents = "0" + cents;
			for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
				num = num.substring(0,num.length-(4*i+3))+'.'+
			num.substring(num.length-(4*i+3));
			
			return (((sign)?'':'-') + num + ',' + cents);
		}
	}
};
/*
var insertOptionRekening = function(idSelect) {
	$.getJSON("get_korek_hiburan.php", function(data){
		var option = "";
		option += "<option value=''>--</option>";
		if (data.total!=undefined && data.total>0){
			$.each(data.list, function(id, obj){
				option += "<option value='"+ obj.key +"'>"+ obj.value +"</option>";
			});
		}
		$("#" + idSelect).append(option);
	});	
};
*/
/**
 * check kode rekening is exist
 * @param n
 * @returns
 */
var checkKorek = function(id) {
	var i = $('#detailTable tr').length - 3;
	for (k=1;k<=i;k++) {
		try {
			if (document.getElementById('spt_dt_korek'+k).value == document.getElementById('spt_dt_korek'+id).value && k!=id) {
				showWarning('Kode Rekening yang sama sudah terpilih. Mohon pilih kode rekening lainnya!');
				$('#spt_dt_korek'+id).val('');
				$('#spt_dt_korek'+id).focus();
				return false;
			}
		} catch (ex) {
		}
	}
};

/**
 * parsing string by comma
 * @param arr
 * @returns
 */
var parseComma = function(arr) {
	if (arr == "") arr = ',';
	var myString = new String(arr);
	var myStringList = myString.split(','); // split on commas
	return myStringList;
};

/**
 * get tarif by rekening
 * @returns
 */
var getTarif = function(objPersen, obTarifDasar, val) {
	$('#' + objPersen).val(parseComma(val)[1]);
};

/**
 * getPajak
 * @returns

var getPajak = function(objSptPajak, objPersen, objDasarPengenaan, objTarifDasar, objJumlahPajak) {
	if ($('#' + objJumlahPajak).val() != "" && $('#' + objTarifDasar).val() != "" && $('#' + objPersen).val() != "" && $('#' + objDasarPengenaan).val() != "") {
		tarifDasar = unformatCurrency($("#"+objTarifDasar).val());
		persenTarif = unformatCurrency($('#'+objPersen).val());
		var pajak = Math.round(tarifDasar * persenTarif  / 100);
		$('#'+objTarifDasar).val(formatCurrency($('#'+objTarifDasar).val()));
		$('#'+objSptPajak).val(formatCurrency(pajak));
	}
};
*/
var getPajak = function (objSptPajak, objDasarPengenaan, objPersen) {
	if ($('#' + objPersen).val() == "" && $('#' + objPersen).val() == 0) {
		var pajak = Math.round((unformatCurrency($('#' + objDasarPengenaan).val()) * 1)* (100 * 1) / 100);
	} else {
		var pajak = Math.round((unformatCurrency($('#' + objDasarPengenaan).val()) * 1)* (($('#' + objPersen).val() * 1) / 100));
	}
	
	$('#'+objSptPajak).val(formatCurrency(pajak));
};
/**
 * to calculate
 * @returns
 */
var calc1 = function() {
	var nilai="";
	var i=1;
	$('#spt_pajak').val("");
	var rowCount = $('#detailTable tr').length;
	while (i <= rowCount) {
		try {
			var pajak = ($('#spt_pajak').val().toString().replace(/\$|\,00/g,'').replace(/\$|\./g,'') * 1) + ($("#spt_dt_pajak"+i+"").val().toString().replace(/\$|\,00/g,'').replace(/\$|\./g,'') * 1);
			$('#spt_pajak').val(pajak);
		} catch (ex) { }
		i++;
		$('#spt_pajak').val(formatCurrency($('#spt_pajak').val()));
	}
};

/**
 * addForm field
 * @returns
 */
var addFormField = function() {
	var rowCount = $('#detailTable tr').length;
	var id = rowCount - 2;
	counter = 0;
	while (counter < 40) {
		if ($('#row_detail' + id).length == 0) {
			break;
		} else {
			id++;
		}
		counter++;
	}
	rowField = appendRowField(id);	
	
	//insertOptionRekening('spt_dt_korek'+id);
	$("#detailTable").append(rowField);
};

var appendRowField = function(id) {
	var rowField = 
		'<tr class="row0" id="row_detail'+ id +'" >'+
			/*
			'<td>'+
				'<select name="spt_dt_korek[]" id="spt_dt_korek'+ id +'" style="width: 300px" class="inputbox" ' +
					'onchange=" checkKorek('+ id +'); getTarif (\'spt_dt_persen_tarif'+ id +'\',\'spt_dt_tarif_dasar'+ id +'\',this.value); ' +
					'getPajak(\'spt_dt_pajak'+ id +'\',\'spt_dt_persen_tarif'+ id +'\',\'spt_dt_dasar_pengenaan'+ id +'\',\'spt_dt_tarif_dasar'+ id +'\',\'spt_dt_jumlah'+ id +'\');'+
					'calc1();">' +
				'</select>'+
			'</td>'+
			*/
			'<td>'+
				'<input type="text" name="gol_kamar[]" id="gol_kamar'+ id +'" class="inputbox" style="width:200px;" value=""  />'+
			'</td>'+
			'<td>'+
				'<input type="text" name="tarif_kamar[]" id="tarif_kamar'+ id +'" class="inputbox" size="16" value="" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" style="text-align:right; width:100px;" autocomplete="off"/>'+
			'</td>'+
			'<td align="center">'+
				'<input type="text" name="jml_kamar[]" id="jml_kamar'+ id +'" class="inputbox" size="3" value=""  style="text-align:right;"/>'+
			'</td>'+
			'<td><a href="#" onClick="removeFormField(\'#row_detail' + id + '\');return false;">Hapus</a></td>'+
		'</tr>';
	
	return rowField;
};

/**
 * removeFormField tr
 * @returns
 */
var removeFormField = function(idx) {
	//var x=window.confirm('Anda yakin akan menghapus detail tersebut?');
	//if (x)
		return $(idx).remove();
	//else
	//return;
};

/**
 * onCompletePage
 * @returns
 */
var completePage = function() {
	$('#btn_add_detail').click(function() {
		addFormField();
	});
	$(function() {
		$("#spt_tgl_proses, #spt_tgl_entry").datepicker({
		  dateFormat: "dd/mm/yy",
		  showOn: "button",
		  buttonImage: "images/calendar.gif",
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
		
	});

};

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

$(document).ready(function() {
	completePage();
	$("#btnSimpan").click(function(){
		/*
		var gol_kamar=[$("#gol_kamar0").val()];
		var tarif_kamar=[$("#tarif_kamar0").val()];
		var jml_kamar=[$("#jml_kamar0").val()];
		var rowCount = $('#detailTable tr').length;
		var x = rowCount - 2;
		if(x==0)
			$.messager.alert('Pajak Hotel','Silahkan lengkapi detail hotel !','warning');
		else if(gol_kamar=='' || tarif_kamar=='' || jml_kamar=='')
			$.messager.alert('Pajak Hotel','Silahkan lengkapi detail hotel !','warning');
		else
		*/
			$("#hotel_frm").submit();
	});
	
});