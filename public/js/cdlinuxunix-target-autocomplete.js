/**
 * Autocompletion for the field target-cluster-vitrual-node-name.
 */
$(function() {
	$('#fieldgroup-specific-endpoint-target .field-cluster-virtual-node-name')
		.autocomplete({
			autoFocus : true,
			delay : 500,
			minLength : 0,
			source : function(request, response) {
				$.get(
					"/order/ajax/provide-clusters?"
					+ "&data[virtual_node_name]=" + request.term,
					{},
					function(data) {
						response($.map(data, function(item) {
							return {
								label : item.virtual_node_name,
								value : item.id
							}
						}));
					}
				);
			},
			select: function (event, ui) {
				$('#fieldgroup-specific-endpoint-target .field-cluster-virtual-node-name').val(ui.item.label);
				$('#fieldgroup-specific-endpoint-target .field-cluster-id').val(ui.item.value);
				return false;
			},
			focus: function (event, ui) {
				this.value = ui.item.label;
				return false;
			},
		}).on('focus', function(event) {
			console.log(new Date());
			console.log($(this));
		$(this).autocomplete("search", this.value);
	});
});
