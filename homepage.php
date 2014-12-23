<?php
   
    $dbname = "wikidots";
    $host = "82.80.210.144";  
    $user = "wikidots";
    $pass = "wagoiplrkyjdnvtxemcq"; 
    $db = new PDO('mysql:dbname='.$dbname.';host='.$host, $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

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
                <div class="menu" onclick="showSidebar()"></div>
            </header>
            <div class="main-data-wrapper">
                <div style=" width: 100%;height: 100%;">
                <div class="main-data">
					<img class="homepage_headline_text" src="images/homepage_headline_text_19.png" />
					<img class="homepage_laptop" src="images/laptop-18.png" />
					<div class="highlights-wrapper">
						<img class="give_dots" src="images/give dots.png"/>
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

					</div>
                </div>
                </div>
                <div class="touch-wrapper">
                    <div class="hand"></div>
                    <div class="hand-line" ></div>
                </div>
                
               
            </div>
            <div class="footer">

            </div>
			
			<div id="sidebar">
                <div class="x" onclick="hideSidebar()"></div>
                <form class="search-form">
                    <input class="search" type="text" />
                    <div class="magnifying-glass"></div>
                    <div class="create-new"></div>
                    <div class="share-item"></div>
                    <div class="random"> <a href="/?id=The_Beatles"></a></div>
                </form>
                <div class="options">
                    <div class="option-item"></div>
                </div>
            </div>

        </div>

    </body>
</html>
