<?php

$servername = "abuloc";
$database = "DB_scheduling";

$uid = "";
$password = "";

$connection = [
    "Database" => $database,
    "Uid" => $uid,
    "PWD" => $password,
];

$conn = sqlsrv_connect($servername, $connection);
// if (!$conn)
//     die(print_r(sqlsrv_errors(), true));


// $sql = "SELECT * 
//   FROM [DB_Scheduling].[dbo].[CTU_Sched]";
// $stmt = sqlsrv_query($conn, $sql);

// if ($stmt == false) {
//     echo "Error in query: " . $sql;
// }

// while ($obj = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
//     echo $obj['TS_Section'] . '</br>';
// }
// sqlsrv_free_stmt($stmt);
// sqlsrv_close($conn);
?>