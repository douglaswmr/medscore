<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script>
setTimeout(function() {
  location.reload();
}, 5000);
</script>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>

<body>

<center>
<?php
echo "<table style='text-align: center ; padding: 5 px ; border: solid 1px #ddd;'>";
 echo "<tr><th>ID</th><th>PACIENTE</th><th>SCORE</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width: 150px; border: 1px solid #ddd;'>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "santacasa";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, nome,
				(IDADE+
				CARDIOPATIA+
				DPOC+
				CORPUMONALI+
				ENFISEMA_PULMONAR+
				ASMA+
				ACID_VASC_ENCEF+
				TABAGISTA+
				DISFASICO+
				DISFAGICO+
				CIR_TORACO_ABDOMINAIS+
				CIR_ORTOPEDICAS+
				ALTERACAO_COGNITIVA+
				ALZHEIMER+
				OUTRAS_DEMENCIAS+
				DEPENDENCIA_ACAMADOS+
				POLITRAUMATIZADOS+
				QUEDA+
				FRATURA+
				CATETER_NASOENTERAL) AS TOTAL FROM usuarios where STATUS='1' ORDER BY TOTAL DESC");
 	
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
	echo $sql;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?> 

</center>
</body>
</html>
