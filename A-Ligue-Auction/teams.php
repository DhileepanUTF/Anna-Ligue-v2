<?php
    $team1=isset($_POST['team1'])?$_POST : false;
    $n=isset($_POST['n'])?$_POST['n']:0;
    $conn= new mysqli('localhost','root',"",'auctionsss');
    
        
    
    // echo json_encode( $row);
    // echo $team1;
    if($team1 == true){
        
        //echo $n;
        if($n == 1){
            $res1=$conn->query("select Name, Position1,Dept,Year from players where C_Team = 'Dribbling Demons' ");
            //$conn->query("update players set Status = 'Sold' where ID= 3");
        }
        else if($n == 2){
            $res1=$conn->query("select Name, Position1,Dept,Year from players where C_Team = 'Soccer Hooligans' ");
            
        }
        else if($n == 3){
            $res1=$conn->query("select Name, Position1,Dept,Year from players where C_Team = 'Juggling Giants' ");
            
        }
        else if($n == 4){
            $res1=$conn->query("select Name, Position1,Dept,Year from players where C_Team = 'Faking Phantoms' ");
            
        }
        else{
            $res1=$conn->query("select Name, Position1,Dept,Year from players where C_Team = 'Net Busters' ");
            
        }
        $a = array();
        
        while ($row=mysqli_fetch_array($res1)){
            
            array_push($a,$row['Name'],$row['Position1'],$row['Dept'],$row['Year']);
            
        }
        echo json_encode($a);
        
    }


?>