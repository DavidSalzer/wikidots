<?php
    
    include_once("dataLayer/wikidotValue.php");
	$wikidotValue=new WikidotValue();

    $homeValue = $wikidotValue->get_front_highlights();
	
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Wikidots</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script>
			var values=[];
            <?php 
				echo "values=".json_encode($wikidotValue->get_value_list()).";";
            ?>
			var valuesName=[];
            values.forEach(function(element){
                valuesName.push(element.title);
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
              js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
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
                      <div class="help" onclick="showFeedbackPopup()"></div>
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
								<div class="highlights-item" data-id="<?php echo $value["id"]?> ">
									<div class="high-img" style="background-image: url('<?php echo $value["img_url"]?>')"></div>
									<div class="high-title"><?php echo $value["title"]?></div>
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
         <div class="popup popup-feedback">
            <div>
                <!--<div class="x-popup"></div>-->

                <form id="send-email" data-type="feedback">
                    <input type="email" name="email"></input>
                    <textarea name="feedback" placeholder="Your feedback"></textarea>
                    <input class="sendbtn" type="image" src="images/submit-21.png" alt="Submit Form" />
                </form>

            </div>
        </div>
    </body>
</html>
