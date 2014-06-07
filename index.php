<?php

$powersofmagnitude = array( 
    'ones', 
    'tens', 
    'hundreds',
    'thousands', 
    'tenthousands', 
    'hundredthousands',
    'millions',
    'tenmillions',
    'hundredmillions',
    'billions'
);

$duration =150;
//duration in milliseconds
$fontwidth=136;
$fontheight=120;
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>CFM Donatometer</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="generator" content="Geany 0.19.1" />
	<!-- Thanks Geany!
							cheers
							-simon -->
    <style>
        @-webkit-keyframes spin_w {
          0% { 	-webkit-transform-origin: 100% 100%; -webkit-transform: rotateX(0deg) skew(0deg, 0deg);}
          100%   { 	-webkit-transform-origin: 100% 100%; -webkit-transform: rotateX(90deg) skew(7deg, 2deg);}
        }

        @keyframes spin {
          0% { 	transform-origin: 100% 100%; transform: rotateX(0deg) skew(0deg, 0deg);}
          100%   { 	transform-origin: 100% 100%; transform: rotateX(90deg) skew(7deg, 2deg);}
        }
		
        @-webkit-keyframes spin2_w {
          0% { -webkit-transform-origin: 0% 0%; -webkit-transform: rotateX(90deg) skew(-7deg, 2deg); }
          100%   { -webkit-transform-origin: 0% 0%; -webkit-transform: rotateX(0deg) skew(0deg, 0deg); }
        }

        @keyframes spin2 {
          0% { transform-origin: 0% 0%; transform: rotateX(90deg) skew(-7deg, 2deg); }
          100%   { transform-origin: 0% 0%; transform: rotateX(0deg) skew(0deg, 0deg); }
        }

        body {
            background-color:black;
        }

        #mainpage {
            width:100%;
            font-family: 'Helvetica Neue',Helvetica,Arial,Sans-Serif;
            font-weight:bold; 
            color:white;
        }
        .center{
            width:900px;
            height:500px;
            margin-left:auto;
            margin-right:auto;
            margin-top:150px;
            position:relative;
            overflow:auto;
            overflow-x: hidden;
            clear:both;
        }
        #box-wrapper{
            width:auto;
            float:right;
            clear:both;
            overflow:visible;
            margin-right:<?php echo $fontwidth;?>px;
        }
        #box-wrapper div{
            float:none;
        }
        .box {
            width:auto;
            height:auto;
        }
        .spn {
            font-size: 185pt;
            font-smooth:always; 
            display:inline-block; 
        }
        .dv { 
/*              background-color: black; */ 
            border: solid black 1px; 
            display:block; 
            height:<?php echo $fontheight;?>px; 
            width:<?php echo $fontwidth;?>px; 
            overflow:hidden; 
            text-align: center;
            line-height:100%; 
        }
        .up { border-bottom:none;}
        .down {border-top:none;}

        .scale { -webkit-animation: spin_w <?php echo $duration;?>ms infinite linear; 
            animation: spin <?php echo $duration;?>ms infinite linear;
            border: solid white 1px; 
            border-bottom:none; 
            overflow-y:hidden; 
            background-color:black;
        }
        .scale2 { -webkit-animation: spin2_w <?php echo $duration;?>ms infinite linear; 
            animation: spin2 <?php echo $duration;?>ms infinite linear;
            border: solid white 1px; 
            border-top:none; 
            overflow-y:hidden; 
            background-color:black;
        }

        .loop_once { -webkit-animation: spin_w <?php echo $duration;?>ms 1 linear; 
            animation: spin <?php echo $duration;?>ms 1 linear;
            border: solid white 1px; 
            border-bottom:none; 
            overflow-y:hidden; 
            background-color:black;
        }
        .loop_once2 { -webkit-animation: spin2_w <?php echo $duration;?>ms 1 linear; 
            animation: spin2 <?php echo $duration;?>ms 1 linear;
            border: solid white 1px; 
            border-top:none; 
            overflow-y:hidden; 
            background-color:black;
        }

        .dv > div > span { 
            width:100%;
        /*    vertical-align:middle; */
        }
        .dv > div { height:200%; }
        .down > div { position:relative; top:-100%; }
        .spn { position:absolute; }
        .spn.top { z-index:20 }
        .spn.top > .dv { z-index:15 }
        .spn.bottom { z-index:10 }
        .spn.bottom > .dv { z-index:5 }
        
        <?php 
        foreach ($powersofmagnitude as $key => $power)
            echo "\n#".$power."{ position:relative; right:".($key * $fontwidth)."px;}";
        ?>
        
        #caption{
            float:right;
            margin-top:250px;
            font-weight:normal;
            font-size: 20px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" >
var tallytarget, currentshowing; 
var powers = ["ones","tens","hundreds","thousands","tenthousands",
        "hundredthousands","millions", "tenmillions","hundredmillions","billions"];
$(function() {
    var ctr, loop;
    

//    var letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ ";
    var letters =" ";
    var chars = "!\"#$%&'()*+,-./:;<=>?@[\]^_`{|}~";
    var numbers = "0123456789 ";

    var duration = <?php echo $duration;?>;
  
    <?php
    $first=true;
    echo "var ";
    foreach ($powersofmagnitude as $key=> $power) {
        if ($first) $first=false;
        else echo ', ';
        echo '$'.$power.' = $("#'.$power.'")';
    }
    echo ';';
    ?>

    function switchToNext(loopthis, end, box) {
        box.removeClass('normal').addClass('scale');
        box.text(loopthis.charAt(ctr));
        ctr++;
        if(ctr == end) clearInterval(loop);
        if(ctr > loopthis.length -1) ctr = 0;
    }

    function loopThrough(a, b, $digit, callback) {
        /* 
            A lot of variables -- such as counters $digit.a, $digit.b and $digit.counter --
            are stashed in the jquery object $digit so that variable closure and scope do not
            confuse the variables when multiple instances of loopThrough are running simultaneously.
        */
        var tmpStart, tmpEnd, stype, etype;
        stype = letters;
        tmpStart = stype.indexOf(a);
        if (tmpStart < 0) { stype = numbers; tmpStart = numbers.indexOf(a); }
        if (tmpStart < 0) { stype = chars; tmpStart = chars.indexOf(a); }
        etype = letters;
        tmpEnd = etype.indexOf(b);
        if (tmpEnd < 0) { etype = numbers; tmpEnd = numbers.indexOf(b);}
        if (tmpEnd < 0) { etype = chars; tmpEnd = chars.indexOf(b);}
        if (stype !== etype) { $digit.loopthis = stype + etype; tmpEnd = tmpEnd + stype.length } 
        else $digit.loopthis = stype;
        $digit.counter= tmpStart;
        $digit.a=tmpStart;
        $digit.b=tmpEnd;
        $digit.end = tmpEnd;        

        var delay;
        $digit.attr("setInterval_id", setInterval(function() {
            box = $digit.children("div.top").find("span");
            tmpbox = $digit.children("div.bottom").find("span");
            boxa = $digit.children("div.top").children("div.up").find("span");
            boxb = $digit.children("div.top").children("div.down").find("span");
            tmpboxa = $digit.children("div.bottom").children("div.up").find("span");
            tmpboxb = $digit.children("div.bottom").children("div.down").find("span");
            
            $digit.children("div.top").children("div.up").addClass('scale');
            $digit.delay = setTimeout(function() { $digit.children("div.top").children("div.down").addClass('scale2'); }, duration);

            if( $digit.counter  != $digit.end) {
                if ($digit.counter == 10) $digit.setTo=0;
                else $digit.setTo=$digit.counter+1;
                tmpboxa.text($digit.loopthis.charAt($digit.setTo));
            }
            boxa.text($digit.loopthis.charAt($digit.counter));
            boxb.text($digit.loopthis.charAt($digit.counter));
            if($digit.counter == tmpStart) tmpboxb.text($digit.loopthis.charAt($digit.counter));
            else setTimeout (function() {
                if ($digit.counter == $digit.end) $digit.setTo=$digit.counter;
                else $digit.setTo=$digit.counter-1;
                $digit.children("div.bottom").children("div.down").find("span").text($digit.loopthis.charAt($digit.setTo));
            }, (duration/2)); 

            $digit.counter++;
            if($digit.counter - 1 == $digit.end) { 
                boxa.parent().parent().removeClass('scale'); 
                clearInterval($digit.attr("setInterval_id"));
              //  clearTimeout($digit.delay);
                setTimeout(function() {
                    $digit.children("div.top").children("div.down").removeClass('scale2');
                }, duration); 
            }
            if($digit.counter > $digit.loopthis.length -1) $digit.counter = 0;
         }, duration));
         
         if (typeof(callback)=='function') callback;
            //box.removeClass('scale').addClass('normal'); 
    }
    
    function loopTo(b, $digit, callback) {
        /* 
            A lot of variables -- such as counters $digit.a, $digit.b and $digit.counter --
            are stashed in the jquery object $digit so that variable closure and scope do not
            confuse the variables when multiple instances of loopThrough are running simultaneously.
        */
        var a=$digit.children("div.bottom").children("div.up").find("span").text(),
            stype = letters,
            tmpStart = stype.indexOf(a),
            etype, tmpEnd;
        if (tmpStart < 0) { stype = numbers; tmpStart = numbers.indexOf(a); }
        if (tmpStart < 0) { stype = chars; tmpStart = chars.indexOf(a); }
        etype = letters;
        tmpEnd = etype.indexOf(b);
        if (tmpEnd < 0) { etype = numbers; tmpEnd = numbers.indexOf(b);}
        if (tmpEnd < 0) { etype = chars; tmpEnd = chars.indexOf(b);}
        if (stype !== etype) { $digit.loopthis = stype + etype; tmpEnd = tmpEnd + stype.length } 
            else { $digit.loopthis = stype; }
        $digit.counter= tmpStart;
        $digit.a=tmpStart;
        $digit.b=tmpEnd;
        $digit.end = tmpEnd;        

        var delay;
        $digit.attr("setInterval_id", setInterval(function() {
            box = $digit.children("div.top").find("span");
            tmpbox = $digit.children("div.bottom").find("span");
            boxa = $digit.children("div.top").children("div.up").find("span");
            boxb = $digit.children("div.top").children("div.down").find("span");
            tmpboxa = $digit.children("div.bottom").children("div.up").find("span");
            tmpboxb = $digit.children("div.bottom").children("div.down").find("span");
            
            $digit.children("div.top").children("div.up").addClass('scale');
            $digit.delay = setTimeout(function() { $digit.children("div.top").children("div.down").addClass('scale2'); }, duration);

            if( $digit.counter  != $digit.end) {
                if ($digit.counter == 10) $digit.setTo=0;
                else $digit.setTo=$digit.counter+1;
                tmpboxa.text($digit.loopthis.charAt($digit.setTo));
            }
            boxa.text($digit.loopthis.charAt($digit.counter));
            boxb.text($digit.loopthis.charAt($digit.counter));
            if($digit.counter == tmpStart) tmpboxb.text($digit.loopthis.charAt($digit.counter));
            else setTimeout (function() {
                if ($digit.counter == $digit.end) $digit.setTo=$digit.counter;
                else $digit.setTo=$digit.counter-1;
                $digit.children("div.bottom").children("div.down").find("span").text($digit.loopthis.charAt($digit.setTo));
            }, (duration/2)); 

            $digit.counter++;
            if($digit.counter - 1 == $digit.end) { 
                boxa.parent().parent().removeClass('scale'); 
                clearInterval($digit.attr("setInterval_id"));
              //  clearTimeout($digit.delay);
                setTimeout(function() {
                    $digit.children("div.top").children("div.down").removeClass('scale2');
                }, duration); 
            }
            if($digit.counter > $digit.loopthis.length -1) $digit.counter = 0;
         }, duration));
         
         if (typeof(callback)=='function') callback;
            //box.removeClass('scale').addClass('normal'); 
    }
    
    function loop3(n, $digit) {
        var initial;
        var currentvalue=$digit.children("div.bottom").children("div.up").find("span").text();
        if (currentvalue ==="") currentvalue=12;
        else currentvalue=parseFloat(currentvalue);
        initial = currentvalue;

        box = $digit.children("div.top").find("span");
        tmpbox = $digit.children("div.bottom").find("span");
        boxa = $digit.children("div.top").children("div.up").find("span");
        boxb = $digit.children("div.top").children("div.down").find("span");
        tmpboxa = $digit.children("div.bottom").children("div.up").find("span");
        tmpboxb = $digit.children("div.bottom").children("div.down").find("span");

        function flipOnce( now ) {
            if (currentvalue <= numberindex ) {
                boxa.text(numbers.charAt(currentvalue));
                boxb.text(numbers.charAt(currentvalue));
                if (currentvalue < numberindex ) setTimeout( function(){ tmpboxa.text(numbers.charAt(currentvalue-1));}, duration/2);
                if(currentvalue == initial) tmpboxb.text(numbers.charAt(initial));
                else setTimeout(function() {
                    tmpboxb.text(numbers.charAt(currentvalue-1)); 
                    }, (duration/2));
                currentvalue++;
                if (currentvalue > 10) currentvalue = 0;
                boxa.parent().parent().addClass('loop_once');
                delay = setTimeout(function() { 
                    boxb.parent().parent().addClass('loop_once2'); 
                }, duration);
                clearTimeout(delay);
                boxa.parent().parent().removeClass('loop_once'); 
                boxb.parent().parent().removeClass('loop_once2');
                requestAnimationFrame(flipOnce, $digit);
            }
        }    
    }
        
    function loopAllTo (newnumber) {        
        var numberStr = newnumber.toString(), magnitude=numberStr.length;
        for (var i=0; i<=magnitude; i++) asyncLoop(i);
            
        function asyncLoop(i) {
            setTimeout( function() {
                var dumdum=12;
                loopTo(numberStr.charAt(magnitude-i-1), eval('$' + powers[i]));                
            }, 87*i+23);
        }
    }
    
    function zenosTally() {
        var increment;
        if (currentshowing < tallytarget) {
            increment = Math.floor((tallytarget - currentshowing ) /2);
//            alert("increment is "+ increment);
            currentshowing = parseInt(currentshowing) + increment;
            loopAllTo(currentshowing);
        }
    }
    
    function pingForTally(callback) {    
        $.ajax({
                url: "gettally.php",
                dataType: 'json',
                context: document.body
            }).done(function(data) {
                if (tallytarget!=data.tally) tallytarget=data.tally;
                if (!currentshowing) {
                    currentshowing = data.previous;
                    loopAllTo(currentshowing);
                }
             //   alert("previous: "+ data.previous+ " tally: "+data.tally);
            });
    }
        

    loopAllTo(23);
    setTimeout(function() {
        loopAllTo(37);
        },6000);
    var ajaxInterval = setInterval(function() {
        pingForTally();
        }, 12000);
        
    var counterInterval = setInterval(function() {
        zenosTally();
    }, 7000);    
//    bigLoopthrough(response, loopThrough, alertfoo); 
});

    </script>
</head>

<body>
    <div id="mainpage" >
    <div id="content-wrapper" class="center">
	<div id="box-wrapper">

<?php

    foreach ($powersofmagnitude as $key => $power) { ?>
        <div id="<?php echo $power;?>" class='box'>
                <div class='spn top'>
                    <div class='dv up'><div><span></span></div></div>
                    <div class='dv down'><div><span></span></div></div>
                </div>
            <div class='spn down bottom'>
                    <div class='dv up'><div><span></span></div></div>
                    <div class='dv down'><div><span></span></div></div>
                </div>
        </div><!-- #<?php echo $power;?> -->
        
    <?php } 
?>                    
	</div> <!--#box-wrapper -->
        <div id='caption'>meals raised for those in need</div>	
    </div>  <!--#content-wrapper -->
    </div> <!-- #mainpage -->
</body>

</html>