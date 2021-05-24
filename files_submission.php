<?php
$host='127.0.0.1';
$username='root';
$password='xuehao';
$dbname='db_book_php_15';
if(!is_dir("./abc")){
    mkdir("./abc",0777);
}
if(isset($_POST["name"])&&isset($_POST["teacher"])&&isset($_POST["school"])){
    for($i=0;$i<count($_FILES["file"]['name']);$i++){
        if ($_FILES["file"]["error"][$i] != 0)
        {
         echo "<script language='JavaScript'>alert('fail to upload your files');history.back();</script>";
         break;
        }
        if(preg_match("/.dat/",strtolower($_FILES["file"]["name"][$i]))) {
            if (is_uploaded_file($_FILES["file"]["tmp_name"][$i])) {
                $upload_file = $_FILES["file"]["tmp_name"][$i];
                $arr = explode('.', $_FILES["file"]["name"][$i]);
                $upload_file_name = $_POST["name"].'_'.$_POST["teacher"].'_'.$_POST["school"]. $i .'_' .iconv("utf-8","gb2312",$_FILES["file"]["name"][$i]);
                //var_dump($_FILES["file"]["error"][$i]);

                copy($_FILES["file"]["tmp_name"][$i], "abc/" . $upload_file_name);
                chmod("abc/" . $upload_file_name, 0777);
            }
        }else{
            echo "<script language='JavaScript'>alert('you should upload .dat files!');history.back();</script>";
            break;
        }
    }
    $mysqli = mysqli_connect($host, $username, $password,$dbname);
    $name=$_POST["name"];
    $school=$_POST["school"];
    $teacher=$_POST["teacher"];
    $time=date('Y-m-d H:i:s');
    $count=count($_FILES["file"]['name']);
    $result = mysqli_query($mysqli,"SELECT * FROM test WHERE name='$name' and school='$school' and teacher='$teacher'");
    $info = mysqli_fetch_array($result);
    if ($info!=False){
        $old_count = $info['count'];
        $new_count = $old_count+$count;
        //echo "<script language='JavaScript'>alert('youle!');history.back();</script>";
        $result = mysqli_query($mysqli,"update test set count='$new_count' where name='$name' and school='$school' and teacher='$teacher'");
        if ($result){
            echo "<script language='JavaScript'>alert('successful');</script>";
        }else{
            "<script language='JavaScript'>alert('fail');</script>";
            return;
        }
    }else{
        $result = mysqli_query($mysqli,"insert into test(name, school, teacher, time, count) values ('$name', '$school', '$teacher', '$time', '$count')");
        if ($result){
            echo "<script language='JavaScript'>alert('successful');</script>";
        }else{
            "<script language='JavaScript'>alert('fail');</script>";
            return;
        }
    }
    $mysqli->close();
    //echo "<meta http-equiv=\"refresh\" content=\"1; url=form.html\">";
    echo "<script language='JavaScript'>alert('upload successful. Thanks, for your contribution');window.location.href='files_submission.html';</script>";
}else{
    echo "<script language='JavaScript'>alert('WTF?');history.back();</script>";
}

?>
