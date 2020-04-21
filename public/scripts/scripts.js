// Displays row with info, optional labelName and inputfield visibility
function makeInfoRow(labelName, info, hide) {
	var outputText = "<div class=\"form-group row\">" + "<label for=\"inputAttribute\" class=\"col-sm-1 col-form-label\">" + labelName + "</label>" + "<div class=\"col-sm-2\">" + "<input type=\"text\" class=\"form-control\" id=\"inputAttribute\" name=\"inputAttribute\">" + "</div>" + "<div id=\"errorEmptyDiv\" class=\"alert-light p-2\"></div>" + "</div>" + "<div class=\"form-group row\">" + "<div class=\"col-sm-3\">" + "<p class=\"alert alert-secondary my-3\">" + info + "</p>" + "</div>" + "</div>";
	if(hide) {
		outputText = "<div class=\"d-none\">" + "<label for=\"inputAttribute\" class=\"d-none\">" + labelName + "</label>" + "<div class=\"d-none\">" + "<input type=\"text\" class=\"form-control\" id=\"inputAttribute\" name=\"inputAttribute\">" + "</div>" + "<div id=\"errorEmptyDiv\" class=\"d-none\"></div>" + "</div>" + "<div class=\"form-group row\">" + "<div class=\"col-sm-3\">" + "<p class=\"alert alert-secondary my-3\">" + info + "</p>" + "</div>" + "</div>";
	}
	return outputText;
}
// Displays only row with labelName and inputfield
function makeSingleRow(labelName, inpRegEx, inpHint, inpValue) {
	var outputText = "<div class=\"form-group row\">" + "<label for=\"input" + labelName + "\" class=\"col-sm-1 col-form-label\">" + labelName + "</label>" + "<div class=\"col-sm-2\">" + "<input type=\"text\" class=\"form-control\" id=\"input" + labelName + "\" name=\"input" + labelName + "\" value= \"" + inpValue + "\" onchange=\"validateInput('" + labelName + "', " + inpRegEx + ")\" required>" + "</div>" + "<div id=\"error" + labelName + "\" class=\"alert-light p-2\">" + inpHint + "</div>" + "</div>";
	return outputText;
}
// Validate inputField by provided RegEx
function validateInput(inpFieldName, inpRegEx) {
	if(inpRegEx.test($("#input" + inpFieldName).val())) {
		validateOk("#error" + inpFieldName);
		valid = true;
	} else {
		validateBad("#error" + inpFieldName);
		valid = false;
	}
	return valid;
}
// Change color for validation hint - green
function validateOk(inpField) {
	if($(inpField).hasClass("alert-light")) {
		$(inpField).removeClass("alert-light");
	}
	if($(inpField).hasClass("alert-danger")) {
		$(inpField).removeClass("alert-danger");
	}
	$(inpField).addClass("alert-success");
}
// Change color for validation hint -  red
function validateBad(inpField) {
	if($(inpField).hasClass("alert-light")) {
		$(inpField).removeClass("alert-light");
	}
	if($(inpField).hasClass("alert-success")) {
		$(inpField).removeClass("alert-success");
	}
	$(inpField).addClass("alert-danger");
}
// Change last fields based on selected type
function changeType() {
	var numRegEx = /^[1-9]\d*$/;
	var temp = "";
	var temp1 = "";
	var temp2 = "";
	var temp3 = "";
	switch($("#mySelector option:selected").val()) {
		case '1':
			if($("#inputSize").val()) {
				temp = $("#inputSize").val();
			}
			$("#emptyDiv").empty();
			$("#emptyDiv").append(makeSingleRow("Size", numRegEx, "Value must be a positive number", temp));
			$("#emptyDiv").append(makeInfoRow("Size", "Please provide size in MB.", true));
			break;
		case '2':
			if($("#inputWeight").val()) {
				temp = $("#inputWeight").val();
			}
			$("#emptyDiv").empty();
			$("#emptyDiv").append(makeSingleRow("Weight", numRegEx, "Value must be a positive number", temp));
			$("#emptyDiv").append(makeInfoRow("Weight", "Please provide weight in KG.", true));
			break;
		case '3':
			if($("#inputHeight").val()) {
				temp1 = $("#inputHeight").val();
			}
			if($("#inputWidth").val()) {
				temp2 = $("#inputWidth").val();
			}
			if($("#inputLength").val()) {
				temp3 = $("#inputLength").val();
			}
			$("#emptyDiv").empty();
			$("#emptyDiv").append(makeSingleRow("Height", numRegEx, "Value must be a positive number", temp1));
			$("#emptyDiv").append(makeSingleRow("Width", numRegEx, "Value must be a positive number", temp2));
			$("#emptyDiv").append(makeSingleRow("Length", numRegEx, "Value must be a positive number", temp3));
			$("#emptyDiv").append(makeInfoRow("Dimensions", "Please provide dimensions in HxWxL format.", true));
			break;
		default:
	}
}
// Validates dynamic fields
function validateDynamicFields() {
	var numRegEx = /^[1-9]\d*$/;
	var testValid = false;
	switch($("#mySelector option:selected").val()) {
		case '1':
			if(validateInput("Size", numRegEx)) {
				$("#inputAttribute").val($("#inputSize").val());
				testValid = true;
			} else {
				testValid = false;
			}
			break;
		case '2':
			if(validateInput("Weight", numRegEx)) {
				$("#inputAttribute").val($("#inputWeight").val());
				testValid = true;
			} else {
				testValid = false;
			}
			break;
		case '3':
			if(validateInput("Height", numRegEx) && validateInput("Width", numRegEx) && validateInput("Length", numRegEx)) {
				$("#inputAttribute").val($("#inputHeight").val() + "x" + $("#inputWidth").val() + "x" + $("#inputLength").val());
				testValid = true;
			} else {
				testValid = false;
			}
			break;
		default:
			testValid = false;
	}
	return testValid;
}
// Validates all form before send to server
function formValidator() {
	var skuRegEx = /^[A-Z]{3}\d{6}$/; // Custom regex for SKU
	var nameRegEx = /^[A-Z][a-zA-Z0-9āēšģīķļņčū\s]+$/; // RegEx for Name field
	var priceRegEx = /^\d*\.\d{2}$/; // RegEx for Price field
	var formValid = false; // Is form valid to send
	if($(document).ready()) {
		if(validateInput("SKU", skuRegEx)) {
			if(validateInput("Name", nameRegEx)) {
				if(validateInput("Price", priceRegEx)) {
					if(validateDynamicFields()) {
						formValid = true;
					} else {
						formValid = false;
					}
				} else {
					formValid = false;
				}
			} else {
				formValid = false;
			}
		} else {
			formValid = false;
		}
	} else {
		formValid = false;
	}
	return formValid;
}
$(document).ready(function() {
	changeType();
});
