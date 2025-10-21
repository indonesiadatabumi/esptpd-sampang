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

/**
 * getPajak
 * @returns
 */
var getPajak = function (objSptPajak, objDasarPengenaan, objPersen) {
	if ($('#' + objPersen).val() == "" && $('#' + objPersen).val() == 0) {
		var pajak = Math.round((unformatCurrency($('#' + objDasarPengenaan).val()) * 1)* (100 * 1) / 100);
	} else {
		if ($('#spt_jenis').val() == '2' && unformatCurrency($('#' + objDasarPengenaan).val()) < 2000000){
			var pajak = 0
		}else{
			var pajak = Math.round((unformatCurrency($('#' + objDasarPengenaan).val()) * 1)* (($('#' + objPersen).val() * 1) / 100));
		}
		
	}
	
	$('#'+objSptPajak).val(formatCurrency(pajak));
};

