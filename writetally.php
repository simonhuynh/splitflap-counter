<?php #writetally.php
$filename='tally.txt';

function setReverseRead($filename) {
    return popen("tac $filename", 'r'); // osx version: tail -r
}

$fp = fopen($filename, 'a+');
$rfp = setReverseRead($filename);
//$rfp=popen("tail -r $filename", 'r');
//while ($line = fgets($rfp)) echo "<br/>".$line."right here is where things are";
//pclose($rfp);

if ($_POST['verify']==="totallyverifiedforsureforsuresesamesauce") {
    if ($_POST['newtally'])
        $newtally=$_POST["newtally"];
    if ($_POST['addmore'])
        $newtally = $_POST['addmore']+fgets($rfp);
    if ($_POST['reset']) {
        $newtally=$_POST['reset'];
        fwrite($fp, $newtally."\n");
    }    
    fwrite($fp, $newtally."\n");
    pclose($rfp);
    $rfp = setReverseRead($filename);
}

//fseek($fp, 0, SEEK_SET); //MOVES THE CURSOR 0 PLACES FROM START OF THE FILE


?>

<!DOCTYPE HTML>
<html>
<head>
    <title>CFM Donatometer Admin</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    
    <style>
        form#tallyform{
            width:400px;
        }
        
        .formlabel{
            float:left;
            width:200px;
        }
        form#tallyform input[type=text]{
        }
        
        form#tallyform input[type=submit]{
            left: 290px;
            position: relative;
        }
    </style>
</head>
<body>
    
    <form id="tallyform" name="tally" action="writetally.php" method="POST">
        <input type="hidden" name="verify" value="totallyverifiedforsureforsuresesamesauce">
        
        <div class="formline"> <span class="formlabel"> add more donations: </span> <input type="text" name="addmore"> </div>
        <div class="formline"> <span class="formlabel"> new tally sum: </span> <input type="text" name="newtally"> </div>
        <div class="formline"> <span class="formlabel"> reset counter target: </span> <input type="text" name="reset" placeholder='<?php echo fgets($rfp);?>'> </div>
        <br/>
        <input type="submit" value="go" style="">
        
    </form>
    <br/><br/>
    
    <b>Previous Entries:</b><br/><br/>
<span>
<?php
    pclose($rfp);
    $rfp = setReverseRead($filename);
    while ($nextline = fgets($rfp)) echo $nextline."<br/>";
        
?>
</span>
    
</body>