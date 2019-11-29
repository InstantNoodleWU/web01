<?php
$dsn="mysql:host=localhost;charset=utf8;dbname=db99";
$pdo=new PDO($dsn,"root","");
session_start();

if(empty($_SESSION['total'])){
    $total=find("total",1);
    $total['total']=$total['total']+1;
    $_SESSION['total']=$total['total'];
    save("total",$total);
}




function find($table,...$arg){
    global $pdo;
    $sql="select * from $table where ";
    if(is_array($arg[0])){
        foreach ($arg[0] as $key => $value) {
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }
        $sql=$sql . implode(" && ",$tmp);
    }else{
        $sql=$sql . "id='".$arg[0]."'";
    }
    
    // echo $sql;
    return $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
}



function all($table,...$arg){
    global $pdo;

    $sql="select * from $table ";
    if(!empty($arg[0])){
        foreach ($arg[0] as $key => $value) {
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }
        $sql=$sql ." where ". implode(" && ",$tmp);
    }

    if(!empty($arg[1])){
        $sql=$sql . $arg[1];
    }

    // echo $sql . "<br>";
    return $pdo->query($sql)->fetchAll();
}


// $rows=all("admin");
// print_r($rows);

// $limit=all("admin",[]," limit 2");
// echo "<br>";
// print_r($limit);

// echo "<br>";

// $pw=all("admin",['pw'=>'1234']);
// print_r($pw);

// $pw2=all("admin",['pw'=>'1234']," limit 1");
// print_r($pw2);

function nums($table,...$arg){
    global $pdo;

    $sql="select count(*) from $table ";
    if(!empty($arg[0])){
        foreach ($arg[0] as $key => $value) {
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }
        $sql=$sql ." where ". implode(" && ",$tmp);
    }
    

    if(!empty($arg[1])){
        $sql=$sql . $arg[1];
    }

    // echo $sql . "<br>";
    return $pdo->query($sql)->fetchColumn();
}

function q($sql){
    global $pdo;

    return $pdo->query($sql)->fetchAll();
}

// print_r(q("select acc from admin "));

function del($table,...$arg){
    global $pdo;

    $sql="delete from $table where ";
    if(is_array($arg[0])){
        foreach ($arg[0] as $key => $value) {
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }

        $sql=$sql . implode(" && ",$tmp);
    }else{
        $sql=$sql . "id='".$arg[0]."'";
    }
    
    // echo $sql;
    return $pdo->exec($sql);    
}


function to($path){
    header("location:".$path);
}

function save($table,$data){
    global $pdo;
    
    if (!empty($data['id'])) {
        
        foreach ($data as $key => $value) {
            if($key!="id"){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }   
        }

        $sql="UPDATE $table SET ".implode(",",$tmp)." WHERE `id`='".$data['id']."'";
    } else {
        $keys=array_keys($data);
        $keys_str="`" . implode("`,`",$keys) . "`";
        $value_str="'" . implode("','",$data) . "'";

        $sql="INSERT INTO $table($keys_str) VALUES ($value_str)";
    }
    // echo $sql;
    return $pdo->exec($sql);
    
}

// $new=["acc"=>"judy","pw"=>"5678"];
// echo save("admin",$new);

// $user=find("admin",3);
// echo "<br>";
// print_r($user);
// echo "<br>---修改後---<br>";
// $user['pw']="9872";
// print_r($user);

// save("admin",$user);
?>