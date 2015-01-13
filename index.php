<?php
       $valueID = isset($_GET['id'])?$_GET['id']:"";
    
       $dbname = "wikidots";
       $host = "82.80.210.144";  
       $user = "wikidots";
       $pass = "wagoiplrkyjdnvtxemcq"; 
       $db = new PDO('mysql:dbname='.$dbname.';host='.$host, $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
       $statement = $db->prepare("select * from value where valueID = :valueID");
       $statement->execute(array(':valueID' => $valueID));
       $row = $statement->fetch(PDO::FETCH_ASSOC); // Use fetchAll() if you want all results, or just iterate over the statement, since it implements Iterator
       if ($row==null){
     header("Location: homepage.php");
     die();
    }
    
       //print_r($row);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta property="og:title" content="<?php echo $row["valueName"]; ?>" />
        <meta property="og:site_name" content="wikidocs" />
        <meta property="og:description" content="<?php echo $row["synopsis"]; ?> /">
        <meta property="og:image" content="<?php echo $row["imgUrl"]; ?>" />
        <meta property="og:locale" content="en_US" />
        <title>Wikidots</title>
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
        <link href="StyleSheet.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="touch.timeline/touch.timeline.light.css" type="text/css" />
		
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<!--<script src="touch.timeline/touch.timeline.js"></script>-->
        <script>
            <?php
                $statement = $db->prepare("select `valueName`,`valueID` from value");
                $statement->execute();
                $table = $statement->fetchAll(PDO::FETCH_ASSOC);
                echo "var values=".json_encode($table).";";
            ?>
            var valuesName=[];
            values.forEach(function(element){
                valuesName.push(element.valueName);
            });
        </script>

        <script src="script.js"></script>


        <!-- Google Analytics -->
        <script type="text/javascript">


            
            
               var _gaq = _gaq || [];
               _gaq.push(['_setAccount', 'UA-57534000-1']);
               _gaq.push(['_trackPageview']);
            
               (function() {
                 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
               })();
            
             //  var pageTracker = _gat._getTracker('UA-57534000-1');
            //   pageTracker._trackPageview();
        </script>

         <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/he_IL/sdk.js#xfbml=1&version=v2.0";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
    </head>
    <body class="value-page">



        <div class="popup popup-oops">
            <div>
                <div class="x-popup"></div>
                <div class="create-new-text" onclick=" showEdit()"></div>

            </div>
        </div>
        <div class="popup popup-editor">
            <div>
                <div class="x-popup"></div>

                <form id="send-email">
                    <input type="email" name="email"></textarea>
                    <input class="sendbtn" type="image" src="images/submit-button-21.png" alt="Submit Form" />
                </form>

            </div>
        </div>
        <div class="main-background" style="background-image: url('<?php echo $row["imgUrl"]; ?>')"></div>
        <div id="mainMask"></div>
        <div class="main-wrapper">
            <header>
                <div class="logo"><a href="homepage.php" class="logo-ref"></a></div>
                <!--<div class="menu" onclick="showSidebar()"></div>-->
                <div class="menu edit" onclick="showEdit()"></div>

                <div class="share-wrapper">
                    <div class="fb-share-button" data-href="http://wikidots.com?id=<?php echo $row["valueID"]; ?>" data-layout="button"></div>
                </div>
            </header>
            <div class="main-data-wrapper">
                <div style=" width: 100%;height: 100%;">
                    <div class="main-data">
                        <div class="back-button" style="display: none;"></div>
                        <!--<div class="x-button"></div>-->
                        <div class="synopsis">
                            <div class="syn-text"><?php echo $row["synopsis"]; ?></div>
                            <div class="highlights-text"></div>
                            <a class="learn-more">
								<div class="arrow"></div>
								<div class="line1">LEARN MORE ABOUT</div>
								<div class="title">ss</div>
							</a>
                        </div>
                        <div class="highlights-wrapper">
                            <?php for($i=1;$i<=7;$i++): ?>
                            <?php if ($row["p_name".$i]!=null & $row["p_name".$i]!=""): ?>
                            <div class="highlights-item" data-description="<?php echo htmlspecialchars($row["p_description".$i], ENT_QUOTES);?>" data-id="<?php echo htmlspecialchars($row["p_valueID".$i], ENT_QUOTES);?>" data-name="<?php echo htmlspecialchars($row["p_name".$i], ENT_QUOTES);?>">
                                <div class="high-img" style="background-image: url('<?php echo $row["p_image_url".$i]; ?>')"></div>
                                <div class="high-title"><?php echo $row["p_name".$i]; ?></div>
                            </div>
                            <?php endif ?>
                            <?php endfor ?>
                        </div>
                        <?php if ($row["videoUrl"] != NULL && $row["videoUrl"] != '' ): ?>
                        <div class="play" vidio-url="<?php echo $row["videoUrl"];?>"></div>
                        <?php endif?>
                    </div>
                </div>
                <div class="touch-wrapper">
                    <div class="hand"></div>
                    <div class="hand-line"></div>
                </div>


            </div>
            <div class="footer">
                <div class="main-data-footer">
                    <div class="value-name"><?php echo $row["valueName"]; ?><a href="http://en.wikipedia.org/wiki/<?php echo $row["valueID"]; ?>" class="wikipedia_button" target="_blank"><img src="images/wikipedia_button.png" /></a>
                    </div>
                    <div class="desc-name"><?php echo $row["Description"]; ?></div>
                </div>

                <div class="timeline">
                    <?php
                        $start= $row["start"]; 
                        $end= $row["end"]; 
                        $ImportantDate= $row["ImportantDate"]; 
                        $now=2015;
                        $startPrecent=0*100;
                        $endPrecent=($end-$start)/($now-$start)*100;
                        $importantDate=($ImportantDate-$start)/($now-$start)*100;
                    ?>

                    <div class="dot dot_start" onmouseover="showDescOnDot(this)" style="left:<?php echo $startPrecent; ?>%"><div class="date-point"><?php echo $start ?></div> <div class="dot_discription"><?php echo $row["start_text"]; ?></div></div>
                    <div class="dot dot_import" onmouseover="showDescOnDot(this)" style="left:<?php echo $importantDate; ?>%"><div class="date-point"><?php echo $ImportantDate ?></div> <div class="dot_discription"><?php echo $row["importantDate_taxt"]; ?></div></div>
                    <div class="dot dot_end" onmouseover="showDescOnDot(this)" style="left:<?php echo $endPrecent; ?>%"><div class="date-point"><?php echo $end ?></div><div class="dot_discription"><?php echo $row["end_text"]; ?></div></div>
                    <div style="padding-left: 20px;">
                        <div class="line" style="width: <?php echo $endPrecent; ?>%;"></div>
                        <div class="pink" style="width: <?php echo 100-$endPrecent; ?>%;"></div>
                    </div>
                </div>
				<?php
                        $start= $row["start"]; 
                        $end= $row["end"]; 
                        $importantDate= $row["ImportantDate"]; 
                        $now=2015;
                ?>
				<!--<div class="timeline-wrap" data-start-time="<?php echo  $start?>" data-end-time="<?php echo  $now?>" data-last-time="<?php echo  $end?>">
					<div class="timeline-event" data-time="<?php echo  $start?>">
						<div class="timeline-title"><?php echo  $start?></div>
						<div class="timeline-content">
							<p><?php echo $row["start_text"]; ?></p>
						</div>
					</div>
					<div class="timeline-event" data-time="<?php echo  $importantDate?>">
						<div class="timeline-title"><?php echo  $importantDate?></div>
						<div class="timeline-content">
							<p><?php echo $row["importantDate_taxt"]; ?></p>
						</div>
					</div>
					<div class="timeline-event" data-time="<?php echo  $end?>">
						<div class="timeline-title"><?php echo  $end?></div>
						<div class="timeline-content">
							<p><?php echo $row["end_text"]; ?></p>
						</div>
					</div>
				</div>-->
            </div>


            <div id="sidebar">
                <div class="x" onclick="hideSidebar()"></div>
                <form class="search-form">
                    <input class="search" type="text" />
                    <div class="magnifying-glass"></div>
                    <div class="create-new"></div>
                    <div class="share-item"></div>
                    <div class="random">
                        <a href="/?id=The_Beatles"></a>
                    </div>
                </form>
                <div class="options">
                    <div class="option-item"></div>
                </div>
            </div>
        </div>

        <div class="youtube-iframe" style="display: none;" onclick="hideVideo()">
            <iframe id="youtubeIframe" width="700" height="380" src="" frameborder="0" allowfullscreen></iframe>
        </div>


    </body>
</html>
