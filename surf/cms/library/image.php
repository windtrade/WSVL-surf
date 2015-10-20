<?php
function makethumb($file,$des,$q, $sz) {
//    header("Content-type: image/jpeg");
//    header("Cache-Control: no-cache");
    $im = imagecreatefromjpeg($file);
    $im_width=imageSX($im);
    $im_height=imageSY($im);

//    if($im_width >= $im_height) {
//        $factor = $sz / $im_width;
//        $new_width = $sz;
//        $new_height = $im_height * $factor;
//    } else {
        $factor = $sz / $im_height;
        $new_height = $sz;
        $new_width = $im_width * $factor;
//    }

    $new_im=imagecreate($new_width,$new_height);
    ImageCopyResized($new_im, $im, 0, 0, 0, 0, $new_width, $new_height, $im_width, $im_height);
imagejpeg ($new_im,$des,$q);
ImageDestroy($im);
ImageDestroy($new_im);
}

include('config.php');
$uploaddir = '../www/images/';
//echo $plaatje_name;
//$query1 = mysql_query("select * from wsvlfoto where link='$plaatje_name'");
//$rows = mysql_num_rows($query1);
//if ($rows <> 0){
//echo "Er bestaat al een plaatje met deze bestandsnaam";
//}
//else{

//if (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $_FILES['plaatje']['name'])) {
$query = mysql_query("select * from wsvlfoto where groep='$groep'");
$n = mysql_num_rows($query);
$n = $n +1;
$file = "$groep$n.jpg";
$file2 = "$groep$n.jpg";

//while (list($key,$value)= each ($plaatje)){

//while ($plaatje){
if (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)) {

//while ($files = $HTTP_POST_FILES['plaatje']){
//foreach (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)){
//if (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)) {

    print "File is valid, and was successfully uploaded.  Here's some more debugging info:\n";
//    print_r($_FILES);
      $datum=date("d-m-y");
    makethumb("../www/images/$file","../www/images/small$file2",80,100);
//    makethumb("../www/images/$file","../www/images/$file2",60,500);
    mysql_query("insert into wsvlfoto (link, groep, titel, bericht, datum) values ('$file', '$groep', '$titel', '$bericht', '$datum')") or die ("error");
    $totaal = mysql_num_rows(mysql_query("select * from wsvlfoto where groep='$groep'"));
    mysql_query("update wsvlgroep set totaal='$totaal' where id='$groep'");



//echo $plaatje_name;

}




//***********************
$query = mysql_query("select * from wsvlfoto where groep='$groep'");
$n = mysql_num_rows($query);
$n = $n +1;
$file = "$groep$n.jpg";
$file2 = "$groep$n.jpg";

//while (list($key,$value)= each ($plaatje)){

//while ($plaatje){
if (move_uploaded_file($_FILES['plaatje2']['tmp_name'], $uploaddir . $file)) {

//while ($files = $HTTP_POST_FILES['plaatje']){
//foreach (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)){
//if (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)) {

    print "File is valid, and was successfully uploaded.  Here's some more debugging info:\n";
//    print_r($_FILES);
      $datum=date("d-m-y");
    makethumb("../www/images/$file","../www/images/small$file2",80,100);
//    makethumb("../www/images/$file","../www/images/$file2",60,500);
    mysql_query("insert into wsvlfoto (link, groep, titel, bericht, datum) values ('$file', '$groep', '$titel', '$bericht', '$datum')") or die ("error");
    $totaal = mysql_num_rows(mysql_query("select * from wsvlfoto where groep='$groep'"));
    mysql_query("update wsvlgroep set totaal='$totaal' where id='$groep'");



//echo $plaatje_name;

}

$query = mysql_query("select * from wsvlfoto where groep='$groep'");
$n = mysql_num_rows($query);
$n = $n +1;
$file = "$groep$n.jpg";
$file2 = "$groep$n.jpg";

//while (list($key,$value)= each ($plaatje)){

//while ($plaatje){
if (move_uploaded_file($_FILES['plaatje3']['tmp_name'], $uploaddir . $file)) {

//while ($files = $HTTP_POST_FILES['plaatje']){
//foreach (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)){
//if (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)) {

    print "File is valid, and was successfully uploaded.  Here's some more debugging info:\n";
//    print_r($_FILES);
      $datum=date("d-m-y");
    makethumb("../www/images/$file","../www/images/small$file2",80,100);
//    makethumb("../www/images/$file","../www/images/$file2",60,500);
    mysql_query("insert into wsvlfoto (link, groep, titel, bericht, datum) values ('$file', '$groep', '$titel', '$bericht', '$datum')") or die ("error");
    $totaal = mysql_num_rows(mysql_query("select * from wsvlfoto where groep='$groep'"));
    mysql_query("update wsvlgroep set totaal='$totaal' where id='$groep'");



//echo $plaatje_name;

}

$query = mysql_query("select * from wsvlfoto where groep='$groep'");
$n = mysql_num_rows($query);
$n = $n +1;
$file = "$groep$n.jpg";
$file2 = "$groep$n.jpg";

//while (list($key,$value)= each ($plaatje)){

//while ($plaatje){
if (move_uploaded_file($_FILES['plaatje4']['tmp_name'], $uploaddir . $file)) {

//while ($files = $HTTP_POST_FILES['plaatje']){
//foreach (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)){
//if (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)) {

    print "File is valid, and was successfully uploaded.  Here's some more debugging info:\n";
//    print_r($_FILES);
      $datum=date("d-m-y");
    makethumb("../www/images/$file","../www/images/small$file2",80,100);
//    makethumb("../www/images/$file","../www/images/$file2",60,500);
    mysql_query("insert into wsvlfoto (link, groep, titel, bericht, datum) values ('$file', '$groep', '$titel', '$bericht', '$datum')") or die ("error");
    $totaal = mysql_num_rows(mysql_query("select * from wsvlfoto where groep='$groep'"));
    mysql_query("update wsvlgroep set totaal='$totaal' where id='$groep'");



//echo $plaatje_name;

}

$query = mysql_query("select * from wsvlfoto where groep='$groep'");
$n = mysql_num_rows($query);
$n = $n +1;
$file = "$groep$n.jpg";
$file2 = "$groep$n.jpg";

//while (list($key,$value)= each ($plaatje)){

//while ($plaatje){
if (move_uploaded_file($_FILES['plaatje5']['tmp_name'], $uploaddir . $file)) {

//while ($files = $HTTP_POST_FILES['plaatje']){
//foreach (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)){
//if (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)) {

    print "File is valid, and was successfully uploaded.  Here's some more debugging info:\n";
//    print_r($_FILES);
      $datum=date("d-m-y");
    makethumb("../www/images/$file","../www/images/small$file2",80,100);
//    makethumb("../www/images/$file","../www/images/$file2",60,500);
    mysql_query("insert into wsvlfoto (link, groep, titel, bericht, datum) values ('$file', '$groep', '$titel', '$bericht', '$datum')") or die ("error");
    $totaal = mysql_num_rows(mysql_query("select * from wsvlfoto where groep='$groep'"));
    mysql_query("update wsvlgroep set totaal='$totaal' where id='$groep'");



//echo $plaatje_name;

}

$query = mysql_query("select * from wsvlfoto where groep='$groep'");
$n = mysql_num_rows($query);
$n = $n +1;
$file = "$groep$n.jpg";
$file2 = "$groep$n.jpg";

//while (list($key,$value)= each ($plaatje)){

//while ($plaatje){
if (move_uploaded_file($_FILES['plaatje6']['tmp_name'], $uploaddir . $file)) {

//while ($files = $HTTP_POST_FILES['plaatje']){
//foreach (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)){
//if (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)) {

    print "File is valid, and was successfully uploaded.  Here's some more debugging info:\n";
//    print_r($_FILES);
      $datum=date("d-m-y");
    makethumb("../www/images/$file","../www/images/small$file2",80,100);
//    makethumb("../www/images/$file","../www/images/$file2",60,500);
    mysql_query("insert into wsvlfoto (link, groep, titel, bericht, datum) values ('$file', '$groep', '$titel', '$bericht', '$datum')") or die ("error");
    $totaal = mysql_num_rows(mysql_query("select * from wsvlfoto where groep='$groep'"));
    mysql_query("update wsvlgroep set totaal='$totaal' where id='$groep'");



//echo $plaatje_name;

}

$query = mysql_query("select * from wsvlfoto where groep='$groep'");
$n = mysql_num_rows($query);
$n = $n +1;
$file = "$groep$n.jpg";
$file2 = "$groep$n.jpg";

//while (list($key,$value)= each ($plaatje)){

//while ($plaatje){
if (move_uploaded_file($_FILES['plaatje7']['tmp_name'], $uploaddir . $file)) {

//while ($files = $HTTP_POST_FILES['plaatje']){
//foreach (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)){
//if (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)) {

    print "File is valid, and was successfully uploaded.  Here's some more debugging info:\n";
//    print_r($_FILES);
      $datum=date("d-m-y");
    makethumb("../www/images/$file","../www/images/small$file2",80,100);
//    makethumb("../www/images/$file","../www/images/$file2",60,500);
    mysql_query("insert into wsvlfoto (link, groep, titel, bericht, datum) values ('$file', '$groep', '$titel', '$bericht', '$datum')") or die ("error");
    $totaal = mysql_num_rows(mysql_query("select * from wsvlfoto where groep='$groep'"));
    mysql_query("update wsvlgroep set totaal='$totaal' where id='$groep'");



//echo $plaatje_name;

}

$query = mysql_query("select * from wsvlfoto where groep='$groep'");
$n = mysql_num_rows($query);
$n = $n +1;
$file = "$groep$n.jpg";
$file2 = "$groep$n.jpg";

//while (list($key,$value)= each ($plaatje)){

//while ($plaatje){
if (move_uploaded_file($_FILES['plaatje8']['tmp_name'], $uploaddir . $file)) {

//while ($files = $HTTP_POST_FILES['plaatje']){
//foreach (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)){
//if (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)) {

    print "File is valid, and was successfully uploaded.  Here's some more debugging info:\n";
//    print_r($_FILES);
      $datum=date("d-m-y");
    makethumb("../www/images/$file","../www/images/small$file2",80,100);
//    makethumb("../www/images/$file","../www/images/$file2",60,500);
    mysql_query("insert into wsvlfoto (link, groep, titel, bericht, datum) values ('$file', '$groep', '$titel', '$bericht', '$datum')") or die ("error");
    $totaal = mysql_num_rows(mysql_query("select * from wsvlfoto where groep='$groep'"));
    mysql_query("update wsvlgroep set totaal='$totaal' where id='$groep'");



//echo $plaatje_name;

}

$query = mysql_query("select * from wsvlfoto where groep='$groep'");
$n = mysql_num_rows($query);
$n = $n +1;
$file = "$groep$n.jpg";
$file2 = "$groep$n.jpg";

//while (list($key,$value)= each ($plaatje)){

//while ($plaatje){
if (move_uploaded_file($_FILES['plaatje9']['tmp_name'], $uploaddir . $file)) {

//while ($files = $HTTP_POST_FILES['plaatje']){
//foreach (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)){
//if (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)) {

    print "File is valid, and was successfully uploaded.  Here's some more debugging info:\n";
//    print_r($_FILES);
      $datum=date("d-m-y");
    makethumb("../www/images/$file","../www/images/small$file2",80,100);
//    makethumb("../www/images/$file","../www/images/$file2",60,500);
    mysql_query("insert into wsvlfoto (link, groep, titel, bericht, datum) values ('$file', '$groep', '$titel', '$bericht', '$datum')") or die ("error");
    $totaal = mysql_num_rows(mysql_query("select * from wsvlfoto where groep='$groep'"));
    mysql_query("update wsvlgroep set totaal='$totaal' where id='$groep'");



//echo $plaatje_name;

}

$query = mysql_query("select * from wsvlfoto where groep='$groep'");
$n = mysql_num_rows($query);
$n = $n +1;
$file = "$groep$n.jpg";
$file2 = "$groep$n.jpg";

//while (list($key,$value)= each ($plaatje)){

//while ($plaatje){
if (move_uploaded_file($_FILES['plaatje10']['tmp_name'], $uploaddir . $file)) {

//while ($files = $HTTP_POST_FILES['plaatje']){
//foreach (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)){
//if (move_uploaded_file($_FILES['plaatje']['tmp_name'], $uploaddir . $file)) {

    print "File is valid, and was successfully uploaded.  Here's some more debugging info:\n";
//    print_r($_FILES);
      $datum=date("d-m-y");
    makethumb("../www/images/$file","../www/images/small$file2",80,100);
//    makethumb("../www/images/$file","../www/images/$file2",60,500);
    mysql_query("insert into wsvlfoto (link, groep, titel, bericht, datum) values ('$file', '$groep', '$titel', '$bericht', '$datum')") or die ("error");
    $totaal = mysql_num_rows(mysql_query("select * from wsvlfoto where groep='$groep'"));
    mysql_query("update wsvlgroep set totaal='$totaal' where id='$groep'");



//echo $plaatje_name;

}

//*************************



// else {
//    print "Possible file upload attack!  Here's some debugging info:\n";
//
 //   }

    ?>
</pre>
<form enctype="multipart/form-data" action="" method="post">
<?php
$query = mysql_query("select * from wsvlgroep");
while ($obj = mysql_fetch_object($query)){
if ($obj->id == '$groep'){
$check = "checked";
}
echo "<input type=\"radio\" name=\"groep\" value=\"$obj->id\" $check>$obj->titel<br />";
}?>
<input type="hidden" name="MAX_FILE_SIZE" value="30000000000000000000000000000" />
titel:<input type="text" name="titel" /><br />
Bericht:<TEXTAREA NAME="bericht" ROWS="4" COLS="50"></TEXTAREA><BR />
Send this file: <input name="plaatje" type="file" /><br />
Send this file: <input name="plaatje2" type="file" /><br />
Send this file: <input name="plaatje3" type="file" /><br />
Send this file: <input name="plaatje4" type="file" /><br />
Send this file: <input name="plaatje5" type="file" /><br />
Send this file: <input name="plaatje6" type="file" /><br />
Send this file: <input name="plaatje7" type="file" /><br />
Send this file: <input name="plaatje8" type="file" /><br />
Send this file: <input name="plaatje9" type="file" /><br />
Send this file: <input name="plaatje10" type="file" /><br />
<!--Send this file: <input name="plaatje[]" type="file" /><br />
Send this file: <input name="plaatje[]" type="file" /><br />
Send this file: <input name="plaatje[]" type="file" /><br />
Send this file: <input name="plaatje[]" type="file" /><br />-->

<input type="submit" value="Send File" />
</form>
<?php
?>