<?php
require_once __DIR__ . '/core.php';

db_param_push();
$project = db_query( 'SELECT id FROM {project} WHERE name=' . db_param(), array( 'Northstar Commerce' ) );
if( db_num_rows( $project ) !== 1 ) {
	fwrite( STDERR, "Expected one Northstar Commerce project\n" );
	exit( 1 );
}
$project_id = (int)db_result( $project );
$expected = array(
	'Checkout error response is unclear' => NEW_,
	'Password reset email copy needs review' => FEEDBACK,
	'Search results pagination loses selected filters' => RESOLVED,
);
foreach( $expected as $summary => $status ) {
	db_param_push();
	$result = db_query( 'SELECT status FROM {bug} WHERE project_id=' . db_param() . ' AND summary=' . db_param(), array( $project_id, $summary ) );
	if( db_num_rows( $result ) !== 1 || (int)db_result( $result ) !== $status ) {
		fwrite( STDERR, "Missing or wrong-status issue: $summary\n" );
		exit( 1 );
	}
}
db_param_push();
$notes = db_query( 'SELECT COUNT(*) FROM {bugnote} n JOIN {bug} b ON b.id=n.bug_id WHERE b.project_id=' . db_param(), array( $project_id ) );
if( (int)db_result( $notes ) !== 1 ) {
	fwrite( STDERR, "Expected one Northstar Commerce note\n" );
	exit( 1 );
}
echo "Verified Northstar Commerce: 3 issues (new, feedback, resolved), 1 public note\n";

$expected_fields = array(
	'Resolution Summary' => array( 'display_update' => 0, 'display_resolved' => 1, 'require_resolved' => 1 ),
	'Backlog Rank' => array( 'display_update' => 1, 'display_resolved' => 0, 'require_resolved' => 0 ),
);
foreach( $expected_fields as $field_name => $flags ) {
	db_param_push();
	$field = db_query( 'SELECT id, display_update, display_resolved, require_update, require_resolved FROM {custom_field} WHERE name=' . db_param(), array( $field_name ) );
	if( db_num_rows( $field ) !== 1 ) {
		fwrite( STDERR, "Missing custom field: $field_name\n" );
		exit( 1 );
	}
	$row = db_fetch_array( $field );
	foreach( $flags as $flag => $expected_value ) {
		if( (int)$row[$flag] !== $expected_value ) {
			fwrite( STDERR, "Wrong flag $flag for custom field: $field_name\n" );
			exit( 1 );
		}
	}
	db_param_push();
	$link = db_query( 'SELECT project_id FROM {custom_field_project} WHERE field_id=' . db_param() . ' AND project_id=' . db_param(), array( (int)$row['id'], $project_id ) );
	if( db_num_rows( $link ) !== 1 ) {
		fwrite( STDERR, "Custom field not linked to Northstar Commerce: $field_name\n" );
		exit( 1 );
	}
}
db_param_push();
$linked_count = db_query( 'SELECT COUNT(*) FROM {custom_field_project} p JOIN {custom_field} f ON f.id=p.field_id WHERE p.project_id=' . db_param(), array( $project_id ) );
if( (int)db_result( $linked_count ) !== 2 ) {
	fwrite( STDERR, "Expected exactly 2 custom fields linked to Northstar Commerce\n" );
	exit( 1 );
}
echo "Verified Northstar Commerce custom fields: Resolution Summary (resolve display+require), Backlog Rank (update display only)\n";
