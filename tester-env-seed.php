<?php
require_once __DIR__ . '/core.php';
require_api( 'project_api.php' );
require_api( 'category_api.php' );
require_api( 'custom_field_api.php' );

$project_name = 'Northstar Commerce';
if( project_get_id_by_name( $project_name, 0 ) ) {
	echo "Seed already present: Northstar Commerce\n";
	exit( 0 );
}

$project_id = project_create( $project_name, 'Internal issue tracking for the Northstar Commerce storefront.', 10 );
category_add( $project_id, 'Checkout' );
category_add( $project_id, 'Account' );
echo "Seeded Northstar Commerce project and categories\n";

$custom_fields = array(
	'Resolution Summary' => array(
		'type' => CUSTOM_FIELD_TYPE_STRING,
		'display_report' => false,
		'display_update' => false,
		'display_resolved' => true,
		'display_closed' => false,
		'require_report' => false,
		'require_update' => false,
		'require_resolved' => true,
		'require_closed' => false,
	),
	'Backlog Rank' => array(
		'type' => CUSTOM_FIELD_TYPE_STRING,
		'display_report' => false,
		'display_update' => true,
		'display_resolved' => false,
		'display_closed' => false,
		'require_report' => false,
		'require_update' => false,
		'require_resolved' => false,
		'require_closed' => false,
	),
);

foreach( $custom_fields as $field_name => $flags ) {
	$field_id = custom_field_get_id_from_name( $field_name );
	if( !$field_id ) {
		$field_id = custom_field_create( $field_name );
	}
	$definition = custom_field_get_definition( $field_id );
	foreach( $flags as $flag => $value ) {
		$definition[$flag] = $value;
	}
	custom_field_update( $field_id, $definition );
	custom_field_link( $field_id, $project_id );
}
echo "Seeded Northstar Commerce custom fields\n";
