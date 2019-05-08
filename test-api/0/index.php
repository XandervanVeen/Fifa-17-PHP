<?PHP
// I get all the file names in the current folder
$filepath = scandir(getcwd());
// I select all files that end with .json
$jsonFile = glob("*.json");
// I convert the 1 left json name to a string so it is easier to use in the next code
$value = array_shift( $jsonFile );
// I get all the text in the selected file
$json = file_get_contents($value);
// I Decode the JSON which is in the selected file
$json_data = json_decode($json,true);
// I select the content-type which is json in this case
header('Content-Type: application/json');
// I put all the decoded json on the website which can be used later on
echo json_encode($json_data);