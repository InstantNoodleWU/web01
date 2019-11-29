<?php
include_once "../base.php";

// $id=$_POST['id'];
foreach ($_POST['id'] as $key => $id) {
    if (!empty($_POST['del']) && in_array($id,$_POST['del'])) {
       del("title",$id);
    //    unlink(img); 刪除img內檔案
    } else {
        $data=find("title",$id);
        $data['text']=$_POST['text'][$key];
        $data['sh']=($_POST['sh']==$id)?1:0;
        save("title",$data);
    }
    
}

to("../admin.php?do=title");
?>