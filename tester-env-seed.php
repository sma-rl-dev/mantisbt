<?php
require_once __DIR__ . '/core.php';
require_api( 'project_api.php' );
require_api( 'category_api.php' );

$project_name = 'Northstar Commerce';
if( project_get_id_by_name( $project_name, 0 ) ) {
	echo "Seed already present: Northstar Commerce\n";
	exit( 0 );
}

$project_id = project_create( $project_name, 'Internal issue tracking for the Northstar Commerce storefront.', 10 );
category_add( $project_id, 'Checkout' );
category_add( $project_id, 'Account' );
echo "Seeded Northstar Commerce project and categories\n";
