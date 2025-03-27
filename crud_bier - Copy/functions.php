<?php
// auteur: Vul hier je naam in
// functie: algemene functies tbv hergebruik

include_once "config.php";

function connectDb(){
    $servername = SERVERNAME;
    $username = USERNAME;
    $password = PASSWORD;
    $dbname = DATABASE;

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function crudMain(){
    $txt = "
    <h1>CRUD brouwers</h1>
    <nav>
        <a href='insert.php'>Toevoegen nieuwe brouwer</a>
    </nav><br>";
    echo $txt;

    $result = getData(CRUD_TABLE);
    printCrudTabel($result);
}

function getData($table){
    $conn = connectDb();
    $sql = "SELECT * FROM $table";
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetchAll();
    return $result;
}

function getRecord($brouwcode) {
    $conn = connectDb();
    $stmt = $conn->prepare("SELECT * FROM brouwers WHERE brouwcode = :brouwcode");
    $stmt->execute(['brouwcode' => $brouwcode]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function printCrudTabel($result){
    $table = "<table border='1' style='background-color: lightcyan;'>";
    $headers = array_keys($result[0]);
    $table .= "<tr>";
    
    foreach($headers as $header){
        $table .= "<th>" . $header . "</th>";
    }
    $table .= "<th>Actie</th></tr>";

    foreach ($result as $row) {
        $table .= "<tr>";
        foreach ($row as $cell) {
            $table .= "<td>" . $cell . "</td>";
        }
        
        $brouwcode = $row['brouwcode'];

        $table .= "<td>
                    <a href='update.php?brouwcode=$brouwcode'>Wijzigen</a> |
                    <a href='delete.php?brouwcode=$brouwcode' onclick='return confirm(\"Weet je zeker dat je dit wilt verwijderen?\")'>Verwijderen</a>
                  </td>";
        $table .= "</tr>";
    }

    $table .= "</table>";
    echo $table;
}

function updateRecord($row){
    $conn = connectDb();
    $sql = "UPDATE " . CRUD_TABLE . " SET
        naam = :naam,
        land = :land
    WHERE brouwcode = :brouwcode";
    $stmt = $conn->prepare($sql);
    $stmt->execute([ 
        ':naam'=>$row['naam'],
        ':land'=>$row['land'],
        ':brouwcode'=>$row['brouwcode']
    ]);
    return ($stmt->rowCount() == 1) ? true : false;
}

function insertRecord($post){
    $conn = connectDb();
    $naam = isset($post['naam']) ? $post['naam'] : '';
    $land = isset($post['land']) ? $post['land'] : '';

    $sql = "INSERT INTO brouwers (naam, land)
        VALUES (:naam, :land)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':naam' => $naam,
        ':land' => $land
    ]);
    return ($stmt->rowCount() == 1) ? true : false;
}

function deleteRecord($brouwcode){
    $conn = connectDb();
    $sql = "DELETE FROM " . CRUD_TABLE . " WHERE brouwcode = :brouwcode";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':brouwcode'=>$brouwcode]);
    return ($stmt->rowCount() == 1) ? true : false;
}
?>
