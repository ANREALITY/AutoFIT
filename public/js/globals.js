/**
 * Global accessible constants and varibales.
 */
const SERVER_PLACE_INTERNAL = 'internal';
const SERVER_PLACE_EXTERNAL = 'external';
const SERVER_QUANTITY_ONE = 'single_server';
const SERVER_QUANTITY_MANY = 'multiple_servers';
const ADDRESS_TYPE_DNS = 'dns_address';
const ADDRESS_TYPE_IP = 'ip';

var global = {
	sourceServerPlace: '', // internal|external
	targetServerPlace: '', // internal|external
	sourceServerQuantity: '', // single_server|multiple_servers
	targetServerQuantity: '', // single_server|multiple_servers
	sourceAddressType: '', // dns_address|ip
	targetAddressType: '', // dns_address|ip
};
