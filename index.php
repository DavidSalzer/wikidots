<?php
    $valueID = isset($_GET['id'])?$_GET['id']:"urassic_World";
    
    $dbname = "wikidots";
    $host = "82.80.210.144";  
    $user = "wikidots";
    $pass = "wagoiplrkyjdnvtxemcq"; 
    $db = new PDO('mysql:dbname='.$dbname.';host='.$host, $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    
    $statement = $db->prepare("select * from value where valueID = :valueID");
    $statement->execute(array(':valueID' => $valueID));
    $row = $statement->fetch(PDO::FETCH_ASSOC); // Use fetchAll() if you want all results, or just iterate over the statement, since it implements Iterator
    if ($row==null)
        die("404");
    //print_r($row);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Wikidots</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="script.js"></script>
        <link href="StyleSheet.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="main-background" style="background-image: url('<?php echo $row["imgUrl"]; ?>')" ;></div>
        <div class="main-wrapper">
            <header>
                <div class="logo"></div>
                <div class="menu"></div>
            </header>
            <div class="main-data-wrapper">
                <div class="main-data">
                    <div class="x-button"></div>
                    <div class="synopsis">
                        <div class="syn-text"><?php echo $row["synopsis"]; ?></div>
						<div class="highlights-text"></div>
                        <a class="learn-more">LEARN MORE</a>
                    </div>
                    <div class="highlights-wrapper">
						<?php for($i=1;$i<=7;$i++): ?>
							<?php if ($row["p_name".$i]!=null & $row["p_name".$i]!=""): ?>
								<div class="highlights-item" 
										data-description="<?php echo htmlspecialchars($row["p_description".$i], ENT_QUOTES);?>"
										data-id="<?php echo htmlspecialchars($row["p_valueID".$i], ENT_QUOTES);?>"
								>
									<div class="high-img" style="background-image: url('<?php echo $row["p_image_url".$i]; ?>')"></div>
									<div class="high-title"><?php echo $row["p_name".$i]; ?></div>
								</div>
							<?php endif ?>
						<?php endfor ?>
                    </div>
                </div>

                <div class="footer">
                    <div class="main-data-footer">
                        <div class="value-name"><?php echo $row["valueName"]; ?><a href="http://en.wikipedia.org/wiki/<?php echo $row["valueID"]; ?>" class="wikipedia_button" target="_blank"><img src="images/wikipedia_button.png" /></a>
						</div>
                        <div class="desc-name"><?php echo $row["Description"]; ?></div>
                    </div>
                    <div class="hand"></div>
                    <div class="timeline">
                        <div class="dot"></div>
                        <div style="padding-left: 20px;">
                            <div class="line"></div>
                            <div class="pink"></div>
                        </div>
                    </div>
                </div>


            </div>

            <div id="sidebar">
                <div class="x" onclick="hideSidebar()"></div>
                <input class="search" type="text" />
                <div class="options">
                    <div class="option-item"></div>
                </div>
            </div>
        </div>

    </body>
</html>
