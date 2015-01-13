<?php
    
    $dbname = "wikidots";
    $host = "82.80.210.144";  
    $user = "wikidots";
    $pass = "wagoiplrkyjdnvtxemcq"; 
    $db = new PDO('mysql:dbname='.$dbname.';host='.$host, $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    
	$statement = $db->prepare("SELECT `value`.* FROM `front` join `value` on `value`.`valueID`= `front`.`valueID` ORDER BY `order` limit 8");
    $statement->execute();
    $homeValue = $statement->fetchAll(PDO::FETCH_ASSOC);
	
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Wikidots</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
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
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
        <link href="StyleSheet.css" rel="stylesheet" type="text/css" />

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
            
                       // var pageTracker = _gat._getTracker('UA-57534000-1');
            //pageTracker._trackPageview();
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
    <body class="home-page">

        <div style="position: absolute; color: #fff; font-size: 15px;">
        </div>

        <div class="popup popup-oops">
            <div>
                <div class="x-popup"></div>
            </div>
        </div>
        <div class="main-background" style="background-image: url('images/main-background.jpg')"></div>
        <div id="mainMask"></div>
        <div class="main-wrapper">
            <header>
                <div class="logo"><a href="#" class="logo-ref"></a></div>
                <div class="menu" style="display: none;" onclick="showSidebar()"></div>
                <form class="search-form">
                    <input class="search" type="text" />
                    <div class="magnifying-glass"></div>

                </form>
                <div class="txt"></div>
                 <div class="share-wrapper">
                
                     <div class="fb-like" data-href="https://www.facebook.com/wikidots" data-layout="standard" data-action="like" data-show-faces="false" data-share="false"></div>
            </div>
            </header>
            <div class="main-data-wrapper">
                <div style=" width: 100%;height: 100%;">
                    <div class="main-data">
                        <a href="mailto:contact@wikidots.com?Subject=my feedback"><div class="help"></div></a>
                                                    <!--<img class="homepage_headline_text" src="images/homepage_headline_text_19.png" />
                                                    <img class="homepage_laptop" src="images/laptop-18.png" />
                                                    <div class="highlights-wrapper">
                                                        <img class="give_dots" src="images/give dots.png" />
                                                        <div class="highlights-item" data-id="The_Beatles">
                                                            <div class="high-img" style="background-image: url('http://upload.wikimedia.org/wikipedia/commons/d/df/The_Fabs.JPG')"></div>
                                                            <div class="high-title">The Beatles</div>
                                                        </div>
                                                        <div class="highlights-item" data-id="Interstellar_(film)">
                                                            <div class="high-img" style="background-image: url('http://upload.wikimedia.org/wikipedia/en/thumb/b/bc/Interstellar_film_poster.jpg/220px-Interstellar_film_poster.jpg')"></div>
                                                            <div class="high-title">Interstellar (film)</div>
                                                        </div>
                                                        <div class="highlights-item" data-id="Stephen_Hawking">
                                                            <div class="high-img" style="background-image: url('http://upload.wikimedia.org/wikipedia/commons/e/eb/Stephen_Hawking.StarChild.jpg')"></div>
                                                            <div class="high-title">Stephen Hawking</div>
                                                        </div>
                            
                                                    </div>-->
                    </div>
                </div>
                <div class="touch-wrapper">
                    <div class="hand"></div>
                    <div class="hand-line"></div>
                </div>
                <div class="top-dots-wrapper">
                    <div class="top-dots-title"></div>
                    <div class="top-dots-list">
						<?php foreach ( $homeValue as  $value ): ?>
							<div class="top-dot-item">
								<div class="highlights-item" data-id="<?php echo $value["valueID"]?> ">
									<div class="high-img" style="background-image: url('<?php echo $value["imgUrl"]?>')"></div>
									<div class="high-title"><?php echo $value["valueName"]?></div>
								</div>
							</div>
						<?php endforeach ?>
                    </div>
                </div>

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

    </body>
</html>
