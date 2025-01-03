<?php
$n=isset($_POST['n'])?$_POST['n']:0;
$nxt=isset($_POST['nxt'])?$_POST : false;
$sv=isset($_POST['sv'])?$_POST : false;
$team=isset($_POST['team'])?$_POST : false;
$conn= new mysqli('localhost','root',"",'auctionsss');
if($nxt)
{
    $res1=$conn->query("select * from players where Status = 'Not_Sold' and Base =2 order by rand() limit 1;");
    if($res1->num_rows==0){
        $res1=$conn->query("select * from players where Status = 'Not_Sold' and Base =1 order by rand() limit 1;");
    }
    if($res1->num_rows==0){
        $res1=$conn->query("select * from players where Status = 'Unsold' order by rand() limit 1");

    }
    $row = $res1->fetch_assoc();
    $id = $row['ID'];
    $name = $row['Name'];
    $dept = $row['Dept'];
    $pos1 = $row['Position1'];
    $pos2 = $row['Position2'];
    $mlt = $row['Mini_Ligue'];
    $ph = $row['Phone'];
    $cteam = $row['C_Team'];
    $base = $row['Base'];
    $yr = $row['Year'];
    $status = $row['Status'];
    if($status === 'Unsold'){
        $conn->query("update player set ID =$id,Name='$name',Dept='$dept',Position1='$pos1',Position2='$pos2',Mini_Ligue='$mlt',Phone='$ph',Sold_Price=0,C_Team='None',Base=$base,Year='$yr',Status='Unsold_Sell' where 1;");
    }
    else{
        $conn->query("update player set ID =$id,Name='$name',Dept='$dept',Position1='$pos1',Position2='$pos2',Mini_Ligue='$mlt',Phone='$ph',Sold_Price=0,C_Team='None',Base=$base,Year='$yr',Status='$status' where 1;");
    
    }
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
if($team){
    $result=$conn->query("select * from player");
    $row=$result->fetch_assoc();
    if($row['Sold_Price']==0){
        $cp=$row['Base'];
    }
    else{
        $cp=$row['Sold_Price']+0.25;
    }
    if($n==1){
        $conn->query("update player set Sold_Price=$cp;");
        $conn->query("update player set Status='Selling';");
        $conn->query("update player set C_Team='Dribbling Demons';");
    }
    else if($n==2 && ($row['Status']!=='Sold' || $row['Status']!=='Unsold')){
        $conn->query("update player set Sold_Price=$cp;");
        $conn->query("update player set Status='Selling';");
        $conn->query("update player set C_Team='Soccer Hooligans';");
    }
    else if($n==3 && ($row['Status']!=='Sold' || $row['Status']!=='Unsold')){
        $conn->query("update player set Sold_Price=$cp;");
        $conn->query("update player set Status='Selling';");
        $conn->query("update player set C_Team='Juggling Giants';");
    }
    else if($n==4 && ($row['Status']!=='Sold' || $row['Status']!=='Unsold')){
        $conn->query("update player set Sold_Price=$cp;");
        $conn->query("update player set Status='Selling';");
        $conn->query("update player set C_Team='Faking Phantoms';");
    }
    else if($n==5 && ($row['Status']!=='Sold' || $row['Status']!=='Unsold')){
        $conn->query("update player set Sold_Price=$cp;");
        $conn->query("update player set Status='Selling';");
        $conn->query("update player set C_Team='Net Busters';");
    }
    echo json_encode(
        array(
            'cp' => $cp
        )
    );
}
if($sv){
    $result=$conn->query("select * from player");
    $row=$result->fetch_assoc();
    $cp=$row['Sold_Price'];
    $ct=$row['C_Team'];
    $id=$row['ID'];
    $year = $row['Year'];
    //Update Purse
    
    $resultnew = $conn->query("select * from teams where Team_Name = '$ct' ");
    $rownew = $resultnew->fetch_assoc();
    $amt = $rownew['Purse'];
    $remaining = $amt - $cp; 

    $first = $rownew['Firstyr_Pl'];
    $second = $rownew['Secondyr_Pl'] ;
    $third = $rownew['Thirdyr_Pl'];
    $fourth = $rownew['Fourthyr_Pl'];
    $total = $rownew['Total_Pl'];
    $year = $row['Year'];
    $total = $total + 1;
    
    $conn->query("update teams SET Purse = '$remaining' WHERE Team_Name = '$ct'");
    if($year === '2nd'){
        $second = $second + 1;
        $conn->query("update teams SET Secondyr_Pl = $second WHERE Team_Name = '$ct'");
    }
    else if($year === '1st'){
        $first = $first + 1;
        $conn->query("update teams SET Firstyr_Pl = $first WHERE Team_Name = '$ct'");
    }
    else if($year === '4th'){
        $fourth = $fourth + 1;
        $conn->query("update teams SET Firstyr_Pl = $third WHERE Team_Name = '$ct'");
    }
    else if($year === '3rd'){
        $third = $third + 1;
        $conn->query("update teams SET Thirdyr_Pl = $fourth WHERE Team_Name = '$ct'");
    }
    $conn->query("update teams SET Total_Pl = $total WHERE Team_Name = '$ct'");
    

    
    $conn->query("update players set C_Team = '$ct' where ID=$id;");
    $conn->query("update players set Sold_Price = $cp where ID=$id;");
    if($row['Status']==="Selling"){
        $conn->query("update players set Status = 'Sold' where ID=$id ;");
        $conn->query("update player set Status = 'Sold'");
    }    
    else if($row['Status'] === "Not_Sold"){
        $conn->query("update players set Status='Unsold' where ID=$id;");
        $conn->query("update player set Status = 'Unsold';");
    }
    else {
        $conn->query("update players set Status='Again_Unsold' where ID=$id;");
        $conn->query("update player set Status = 'Again_Unsold';");

    }
    $result=$conn->query("select * from players where ID=$id;");
    $row=$result->fetch_assoc();
    echo json_encode(
        array(
            'ct' => $row['C_Team'],
            'pr' => $row['Sold_Price']
        )
        );
}
?>