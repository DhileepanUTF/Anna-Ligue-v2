<?php
$conn = new mysqli("localhost","root","","auctionsss");
if(!$conn){
    echo "Connection failed";
}
else{
    $result=$conn->query("select * from player where 1");
        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            echo json_encode(
                array(
                    'name' => $row['Name'],
                    'dept' => $row['Dept'],
                    'pos1' => $row['Position1'],
                    'pos2' => $row['Position2'],
                    'mlt' => $row['Mini_Ligue'],
                    'ph' => $row['Phone'],
                    'cteam' => $row['C_Team'],
                    'cprice' => $row['Sold_Price'],
                    'base' => $row['Base'],
                    'yr' => $row['Year'],
                    'status' => $row['Status']
                )
            );
        }
    }
?>