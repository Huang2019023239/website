<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="css/normalize.css" />
<link rel="stylesheet" type="text/css" href="css/default0.css">
<head>
    <meta charset="UTF-8">
    <title>Acknowledgements</title>
</head>
<body>
<h2 align="center">Acknowledgements</h2>
<div class="htmleaf-links" align="center">
    <a class="htmleaf-icon icon-htmleaf-home-outline" href="index.php" title="homepage" target="_blank"><span>Homepage</span></a>
    <a class="htmleaf-icon icon-htmleaf-arrow-forward-outline" href="files_submission.html" title="files_submission" target="_blank"><span>files_submission</span></a>
</div>
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
    echo "<a href=acknowledge.php?page=1><button>Fist Page</button></a>&nbsp;";
    echo "<a href=acknowledge.php?page=".($page-1)."><button>Page Up</button></a>&nbsp;";
    echo "<a href=acknowledge.php?page=".($page+1)."><button>Page Down</button></a>&nbsp;";
    echo "<a href=acknowledge.php?page=".$page_count."><button>Last Page</button></a>&nbsp;";
    mysqli_free_result($sql);
    mysqli_close($mysqli);
    ?></td>
<!--<h2>Zebra stripes, footer</h2>
<table class="zebra">
    <thead>
    <tr>
        <th>#</th>
        <th>IMDB Top 10 Movies</th>
        <th>Year</th>

    </tr>
    </thead>
    <tfoot>
    <tr>
        <td> </td>
        <td></td>
        <td></td>
    </tr>
    </tfoot>
    <tr>

        <td>1</td>
        <td>The Shawshank Redemption</td>
        <td>1994</td>
    </tr>
    <tr>
        <td>2</td>
        <td>The Godfather</td>
        <td>1972</td>

    </tr>
    <tr>
        <td>3</td>
        <td>The Godfather: Part II</td>
        <td>1974</td>
    </tr>
    <tr>
        <td>4</td>
        <td>The Good, the Bad and the Ugly</td>

        <td>1966</td>
    </tr>
    <tr>
        <td>5</td>
        <td>Pulp Fiction</td>
        <td>1994</td>
    </tr>

    <tr>
        <td>6</td>
        <td>12 Angry Men</td>
        <td>1957</td>
    </tr>
    <tr>
        <td>7</td>
        <td>Schindler's List</td>

        <td>1993</td>
    </tr>
    <tr>
        <td>8</td>
        <td>One Flew Over the Cuckoo's Nest</td>
        <td>1975</td>
    </tr>
    <tr>

        <td>9</td>
        <td>The Dark Knight</td>
        <td>2008</td>
    </tr>
    <tr>
        <td>10</td>
        <td>The Lord of the Rings: The Return of the King</td>

        <td>2003</td>
    </tr>
</table>-->
</body>
</html>
<style>

    body {
        width: 800px;
        margin: 40px auto;
        font-family: 'trebuchet MS', 'Lucida sans', Arial;
        font-size: 14px;
        color: #444;
    }

    table {
        *border-collapse: collapse; /* IE7 and lower */
        border-spacing: 0;
        width: 100%;
    }

    .bordered {
        border: solid #ccc 1px;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        border-radius: 6px;
        -webkit-box-shadow: 0 1px 1px #ccc;
        -moz-box-shadow: 0 1px 1px #ccc;
        box-shadow: 0 1px 1px #ccc;
    }

    .bordered tr:hover {
        background: #fbf8e9;
        -o-transition: all 0.1s ease-in-out;
        -webkit-transition: all 0.1s ease-in-out;
        -moz-transition: all 0.1s ease-in-out;
        -ms-transition: all 0.1s ease-in-out;
        transition: all 0.1s ease-in-out;
    }

    .bordered td, .bordered th {
        border-left: 1px solid #ccc;
        border-top: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    .bordered th {
        background-color: #dce9f9;
        background-image: -webkit-gradient(linear, left top, left bottom, from(#ebf3fc), to(#dce9f9));
        background-image: -webkit-linear-gradient(top, #ebf3fc, #dce9f9);
        background-image: -moz-linear-gradient(top, #ebf3fc, #dce9f9);
        background-image: -ms-linear-gradient(top, #ebf3fc, #dce9f9);
        background-image: -o-linear-gradient(top, #ebf3fc, #dce9f9);
        background-image: linear-gradient(top, #ebf3fc, #dce9f9);
        -webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;
        -moz-box-shadow:0 1px 0 rgba(255,255,255,.8) inset;
        box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;
        border-top: none;
        text-shadow: 0 1px 0 rgba(255,255,255,.5);
    }

    .bordered td:first-child, .bordered th:first-child {
        border-left: none;
    }

    .bordered th:first-child {
        -moz-border-radius: 6px 0 0 0;
        -webkit-border-radius: 6px 0 0 0;
        border-radius: 6px 0 0 0;
    }

    .bordered th:last-child {
        -moz-border-radius: 0 6px 0 0;
        -webkit-border-radius: 0 6px 0 0;
        border-radius: 0 6px 0 0;
    }

    .bordered th:only-child{
        -moz-border-radius: 6px 6px 0 0;
        -webkit-border-radius: 6px 6px 0 0;
        border-radius: 6px 6px 0 0;
    }

    .bordered tr:last-child td:first-child {
        -moz-border-radius: 0 0 0 6px;
        -webkit-border-radius: 0 0 0 6px;
        border-radius: 0 0 0 6px;
    }

    .bordered tr:last-child td:last-child {
        -moz-border-radius: 0 0 6px 0;
        -webkit-border-radius: 0 0 6px 0;
        border-radius: 0 0 6px 0;
    }

    /*----------------------*/

    .zebra td, .zebra th {
        padding: 10px;
        border-bottom: 1px solid #f2f2f2;
    }

    .zebra tbody tr:nth-child(even) {
        background: #f5f5f5;
        -webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;
        -moz-box-shadow:0 1px 0 rgba(255,255,255,.8) inset;
        box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;
    }

    .zebra th {
        text-align: left;
        text-shadow: 0 1px 0 rgba(255,255,255,.5);
        border-bottom: 1px solid #ccc;
        background-color: #eee;
        background-image: -webkit-gradient(linear, left top, left bottom, from(#f5f5f5), to(#eee));
        background-image: -webkit-linear-gradient(top, #f5f5f5, #eee);
        background-image: -moz-linear-gradient(top, #f5f5f5, #eee);
        background-image: -ms-linear-gradient(top, #f5f5f5, #eee);
        background-image: -o-linear-gradient(top, #f5f5f5, #eee);
        background-image: linear-gradient(top, #f5f5f5, #eee);
    }

    .zebra th:first-child {
        -moz-border-radius: 6px 0 0 0;
        -webkit-border-radius: 6px 0 0 0;
        border-radius: 6px 0 0 0;
    }

    .zebra th:last-child {
        -moz-border-radius: 0 6px 0 0;
        -webkit-border-radius: 0 6px 0 0;
        border-radius: 0 6px 0 0;
    }

    .zebra th:only-child{
        -moz-border-radius: 6px 6px 0 0;
        -webkit-border-radius: 6px 6px 0 0;
        border-radius: 6px 6px 0 0;
    }

    .zebra tfoot td {
        border-bottom: 0;
        border-top: 1px solid #fff;
        background-color: #f1f1f1;
    }

    .zebra tfoot td:first-child {
        -moz-border-radius: 0 0 0 6px;
        -webkit-border-radius: 0 0 0 6px;
        border-radius: 0 0 0 6px;
    }

    .zebra tfoot td:last-child {
        -moz-border-radius: 0 0 6px 0;
        -webkit-border-radius: 0 0 6px 0;
        border-radius: 0 0 6px 0;
    }

    .zebra tfoot td:only-child{
        -moz-border-radius: 0 0 6px 6px;
        -webkit-border-radius: 0 0 6px 6px
        border-radius: 0 0 6px 6px
    }

</style>