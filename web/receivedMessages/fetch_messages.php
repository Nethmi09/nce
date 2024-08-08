include '../../function.php';

<!--call db connection variable-->
$db = dbConn();

$sql = "SELECT * FROM messages ORDER BY timestamp DESC";
$result = $db->query($sql);

$messages = array();
while ($row = $result->fetch_assoc()) {
$messages[] = $row;
}

<!-- Ensure we return valid JSON-->
<!--header('Content-Type: application/json');-->
<!--convert to JavaScript friendly array-->
echo json_encode($messages);