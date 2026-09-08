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
