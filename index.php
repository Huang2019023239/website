<!DOCTYPE html>
<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.0.0/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/body-pix@1.0.0"></script>
<script src="newindex.js"></script>
<link rel="stylesheet" type="text/css" href="css/index.css">
<?php
$host='127.0.0.1';
$username='root';
$password='xuehao';
$dbname='db_book_php_15';
$mysqli = mysqli_connect($host, $username, $password,$dbname);
$query = "select count(*) as total from usercount";
$total_views_result=mysqli_query($mysqli,$query);
$view_result=mysqli_fetch_array($total_views_result);
$totalviews=$view_result['total'];
$month=date('Y-m');
$now=date('Y-m-d H:i:s');
$query="select count(*) as total from usercount where time>= '{$month}.-01 00:00:01' and time<= '{$now}'";
$month_views_result=mysqli_query($mysqli, $query);
$month_views=mysqli_fetch_array($month_views_result);
$month_views=$month_views['total'];
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title class="title0">P-E loop discriminator</title>

<script>
    window.onload = function () {
        var div1 = document.getElementById("div1");
        //拖拽进入
        div1.addEventListener("dragenter", function () {
            div1.innerHTML = "mouseup";
        }, false);
        //拖拽离开
        div1.addEventListener("dragleave", function () {
            div1.innerHTML = "drop file here";
        }, false);
        //悬停
        div1.addEventListener("dragover", function (ev) {
            ev.preventDefault();//取消事件的默认动作，防止浏览器打开文件
        }, false);
    }



</script>
</head>
<br>
<div align="center"><h class="head"><h class="header"><i>P-E</i> loop discriminator</h></h><h class="version">Version 1.0</h><br>
    <h class="update">Updated on 07/2020.&nbsp;&nbsp;&nbsp;&nbsp;Dataset size: 1193 samples.&nbsp;&nbsp;&nbsp;&nbsp;Accuracy: 97%.&nbsp;&nbsp;&nbsp;&nbsp;Times of use:&nbsp;<?php echo $totalviews;?>.</h>
</div>
<div>
    <div class="title"><strong>1. Upload the file containing the <i>P-E</i> loop data below</strong>
    </div>
        <div class="title"><strong>2. After uploading the file, the <i>P-E</i> loop will be displayed below</strong>
    </div>
</div>
<div>
    <div id="div1">Please drop your file here</div>
    <div id="div2" ><canvas id="myCanvas" width="400" height="400"></canvas></div>
    <div id="div3"><strong>Result:</strong><p></p><p id="red"></p></div>
    <div >
        *If you are interested in contributing </br>your data to our dataset, please click<a href="files_submission.html" > here</a>.</br>
        *All contributions will be acknowledged. See <a href="#roll" >here.</a></br>
    </div>
</div>
</br>
<strong>Instructions</strong>
<p>1. Please upload only one file each time.</br>
    2. The uploaded file should be in the format of .dat. The file should have two columns listing the voltage and polarization values, respectively.
    The number of data points in each file should be 100*n+1 (n is an integer), which is in agreement with that of the file output by the Radiant tester.</br>
    3. If you wish to keep your original data confidential, you may normalize the voltage and polarization values to [-1,1].
    This can be done by simply dividing the voltage and polarization values by their respective maximum values.</br>
    4. If you find any issues when using this website, please contact 2019023239@m.scnu.edu.cn.
</p>
<br>
<strong>Background Theory</strong>
<p>Please refer to https://doi.org/10.1002/adts.202000106, or download the paper <a href="paper/ML.pdf" target="_blank">here</a>.</p>
<br>
<strong>Declarations</strong>
<p>We promise not to use the data in any individual uploaded file for publication or any commercial purposes.
    However, we may use the statistical results obtained from the whole dataset.
</p>
<br>
<strong>Developers</strong>
<p>➢Qicheng Huang (黄啟成), Master Student, South China Normal University, 2019023239@m.scnu.edu.cn.<br>
    ➢Zhen Fan (樊贞), Associate Professor, South China Normal University, fanzhen@m.scnu.edu.cn.</p>
<div id="roll">
<h2 align="center">Acknowledgements</h2>
<table class="bordered">
    <thead>

    <tr>
        <th>Name</th>
        <th>Supervisor</th>
        <th>University</th>
        <th><center>Date<a href="?orderBy=timedesc">↓</a>/<a href="?orderBy=timeasc">↑</a></center></th>
        <th>Files<a href="?orderBy=countdesc">↓</a>/<a href="?orderBy=countasc">↑</a></th>
    </tr>
    </thead>
    <?php
$host='127.0.0.1';
$username='root';
$password='2019023239';
$dbname='db_book_php_15';
$mysqli = mysqli_connect($host, $username, $password,$dbname);
if(isset($_GET["page"]))
    $page = $_GET["page"];
else
    $page = "";
if ($page==""){
    $page=1;}
    if (is_numeric($page)){
        $page_size=50;
        $query = "select count(*) as total from test order by count desc, time asc";
        $result=mysqli_query($mysqli,$query);
        $message_count=mysqli_fetch_array($result);
        $message_count=$message_count['total'];
        $page_count=ceil($message_count/$page_size);
        $offset=($page-1)*$page_size;
        $sql = "select * from test";
        if($_GET['orderBy'] == 'timeasc')
        {
            $sql = "select * from test order by time asc limit $offset, $page_size";
        }elseif($_GET['orderBy'] == 'timedesc'){
            $sql = "select * from test order by time desc limit $offset, $page_size";
        }elseif($_GET['orderBy'] == 'countasc'){
            $sql = "select * from test order by count asc limit $offset, $page_size";
        }else{
            $sql = "select * from test order by count desc limit $offset, $page_size";
        }
        $sqli = mysqli_query($mysqli,$sql);
        $row = mysqli_fetch_object($sqli);
        if (!$row){
            echo "<script language='JavaScript'>alert('There is no record');history.back();</script>";
}else{
        ?>


<?php
        do{
                ?>
        <tr>
            <td><?php echo $row->name;?></td>
            <td><?php echo $row->teacher;?></td>
            <td><?php echo $row->school;?></td>
            <td><?php echo $row->time;?></td>
            <td><?php echo $row->count;?></td>
            </tr>
            <?php
        }while($row=mysqli_fetch_object($sqli));

        ?>


</table>
    <?php
}
}
    ?>
<br><br>
<td width="37%">&nbsp;&nbsp;Pages:<?php echo $page;?>/<?php echo $page_count;?>Page
&nbsp;Record:<?php echo $message_count;?>item&nbsp;</td>
<td width="63%" align="right"><?php
    echo "<a href=index.php?page=1><button>Fist Page</button></a>&nbsp;";
    echo "<a href=index.php?page=".($page-1)."><button>Page Up</button></a>&nbsp;";
    echo "<a href=index.php?page=".($page+1)."><button>Page Down</button></a>&nbsp;";
    echo "<a href=index.php?page=".$page_count."><button>Last Page</button></a>&nbsp;";
mysqli_free_result($sql);
mysqli_close($mysqli);
    ?></td>
</div>
<p1>@2020 peloop.top版权所有ICP证：<a href="http://www.beian.miit.gov.cn" >粤ICP备20057654号</a></p1>
<div style="width:300px;margin:0 auto; padding:20px 0;">
    <a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=44011302002560" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="img/beian.png" style="float:left;"/><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">粤公网安备 44011302002560号</p></a>
</div>
</body>
</html>
<script>
    //松手
    var div1 = document.getElementById("div1");
    div1.addEventListener("drop", function (ev) {
    ev.preventDefault();//取消事件的默认动作。
    div1.innerHTML = "Please drop another file here" ;
    var xmlHttp;
    xmlHttp=new XMLHttpRequest();
    if (xmlHttp==null)
        {
            alert ("Browser does not support HTTP Request")
            return
        }
    var url="usercount.php";
    xmlHttp.onreadystatechange=function () {
        if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
        {
            console.log("ok");
        }
    };
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
    let file = ev.dataTransfer.files[0] ;
    filePath = file.name.toString();
    let index= filePath.lastIndexOf(".");
    let ext = filePath.substr(index+1);
    if (ext != 'dat'){
    alert('File must be fellow with dat');
        return;
    }
    var errorutf16;
    let fileReader = new FileReader() ;
    fileReader.readAsText(file,'UTF-16');
    fileReader.onload = function(e){
        var datalast = read_and_stddata(this.result);
    if (datalast){
        errorutf16=false;
    loadmodel(datalast);
    drawloop(this.result);
    }
    else{
        errorutf16 =true;
    }

    }
    fileReader.onerror = function(){
    alert("读取失败");
    }
    let fileReader2 = new FileReader() ;
    fileReader2.readAsText(file,'UTF-8');
    fileReader2.onload = function(e){
        var datalast = read_and_stddata(this.result);
    if (datalast){
    loadmodel(datalast);
    drawloop(this.result);
    }
    else{
    alert('false read you file');
    }
    }
    fileReader2.onerror = function(){
    alert("读取失败");
    }

    }, false);
</script>
