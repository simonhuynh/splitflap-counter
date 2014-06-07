<?php #tally.php
$filename='tally.txt';
function setReverseRead($filename) {
    return popen("tac $filename", 'r'); // osx version: tail -r
}
$rfp = setReverseRead($filename);

$firstlineisnotempty=rtrim(fgets($rfp));
if ($firstlineisnotempty) $tally=$firstlineisnotempty;
else $tally = rtrim(fgets($rfp));
$previous = rtrim(fgets($rfp)); 
pclose($rfp);

$json = array( 'tally'=> $tally, 'previous'=> $previous);
header('Content-type: application/json');
echo json_encode($json);

?>