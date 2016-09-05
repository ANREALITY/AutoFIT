// CD ZOS EndpointTarget #start#
const BLOCKING_VARIABLE = 'vb';
const BLOCKING_FIXED = 'fb';

$(document).ready(function() {
	initBlockingFieldsTarget();
});

function toggleFieldBlockSizeTarget(field) {
	if ($(field).prop('checked') && $(field).val() === BLOCKING_FIXED) {
		console.log($(field).val());
		fieldBlockSizeTarget.parent().fadeIn('slow');
	} else if ($(field).prop('checked') && $(field).val() === BLOCKING_VARIABLE) {
		console.log($(field).val());
		fieldBlockSizeTarget.val('');
		fieldBlockSizeTarget.parent().fadeOut('slow');
	}
}

var initBlockingFieldsTarget = function() {
	console.log('initBlockingFieldsTarget');
	fieldBlockSizeTarget = $('#fieldgroup-specific-endpoint-target .field-block-size');
	fieldBlockingTarget = $('#fieldgroup-specific-endpoint-target .field-blocking');
	fieldBlockingTarget.change(function() {
		toggleFieldBlockSizeTarget(this);
	});
	fieldBlockingTarget.trigger('change');
};
// CD ZOS EndpointTarget #stop#
