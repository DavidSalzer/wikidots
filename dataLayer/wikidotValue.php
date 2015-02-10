<?php 
include_once("krumo/class.krumo.php");
include_once('simple_html_dom/simple_html_dom.php');

class WikidotValue{

	private $db;
	
	function __construct() {
		$dbname = "wikidots";
		$host = "82.80.210.144";  
		$user = "wikidots";
		$pass = "wagoiplrkyjdnvtxemcq"; 
		$this->db = new PDO('mysql:dbname='.$dbname.';host='.$host, $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}
	
	function getValue($value_id){
		$statement = $this->db->prepare("SELECT * FROM `values` where id=:id");
		$statement->execute(array(':id' => $value_id));
		$value = $statement->fetch(PDO::FETCH_ASSOC);
		if ($value==null){
			$value=$this->importValue($value_id);
			if (isset($value->error))
				return null;
			else{
				$this->saveData($value);
				return $this->getValue($value_id);
			}
		}
		$statement = $this->db->prepare("SELECT * FROM `event` where vid=:id");
		$statement->execute(array(':id' => $value_id));
		$value["event"] = $statement->fetchAll(PDO::FETCH_ASSOC);
		$statement = $this->db->prepare("SELECT `highlights`.*, `values`.`img_url` FROM `highlights` join `values` on `values`.`id`=`highlights`.`to_vid` where `highlights`.`vid`=:id");
		$statement->execute(array(':id' => $value_id));
		$value["highlights"] = $statement->fetchAll(PDO::FETCH_ASSOC);
		return (object)$value;
	}
	
	function saveData($obj){
		$statement = $this->db->prepare("INSERT INTO `values` (`id`, `title`,`description`, `synopsis`, `img_url`) VALUES (:id, :title, :description, :synopsis, :img_url)");
		$statement->execute(array('id' => $obj->id, 'title' => $obj->title, 'description' => $obj->description, 'synopsis' => $obj->synopsis, 'img_url' => $obj->img_url ));
		foreach($obj->events as $event){
			$statement = $this->db->prepare("INSERT INTO `event` (`vid`, `year`, `text`) VALUES (:vid, :year, :text)");
			$statement->execute(array('vid' => $obj->id, 'year' => $event->year, 'text' => $event->text));
		}
		foreach($obj->highlights as $highlight){
			$statement = $this->db->prepare("INSERT INTO `highlights` (`vid`, `to_vid`, `name`, `description`) VALUES (:vid, :to_vid,:name,:description)");
			$statement->execute(array('vid' => $obj->id, 'to_vid' => $highlight->value, 'name' => $highlight->name, 'description' => $highlight->description));
		}
	}
	
	function is_value_exsist($value_id){
		return (getValue($value_id)!=null);
	}
	
	function get_front_highlights(){
		$statement = $this->db->prepare("SELECT `values`.* FROM `front` join `values` on `values`.`id`= `front`.`valueID` ORDER BY `order` limit 8");
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function get_value_list(){
		$statement = $this->db->prepare("select `title`,`id` from `values`");
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	function importValue($value_id){
		set_time_limit ( 200);
		$res=new stdClass();
		$json = file_get_contents('http://en.wikipedia.org/w/api.php?action=parse&page='.$value_id.'&format=json');
		$wikipediaData = json_decode($json);
		
		if (isset($wikipediaData->error)){
			$res->error=$wikipediaData->error;
			return $res;
		}
		$doc = str_get_html($wikipediaData->parse->text->{'*'});
		//Krumo($wikipediaData);
		
		$res->id=$value_id;
		$res->title=$wikipediaData->parse->title;
		//Description
		$pattern = "/<p>(.*?)<\/p>/";
		preg_match($pattern, $wikipediaData->parse->text->{'*'}, $matches);
		$pattern = "/^[^.]+/";
		$firstParagraph=strip_tags($matches[1]);
		//echo $doc->find('div p:first',0);
		preg_match($pattern, $matches[1], $matches);
		$firstSentence=strip_tags($matches[0]);
		//echo($firstSentence);
		$conjunctions=array("is a ","is an ","is the ","are a ","are an ","are the ","was a ","was an ","was the ","were a ","were an ","were the ","refers to a ","refers to an ","is one of the ","are one of the ","as a ","as an ");
		foreach($conjunctions as $conjunction){
			$pos = strpos($firstSentence, $conjunction);
			if ($pos !== false) {
				$tmp=substr($firstSentence,$pos+strlen($conjunction));
				$commaPos=strpos($tmp, ',');
				if ($commaPos !== FALSE)
					$res->description=substr($tmp,0,$commaPos);
				else{
					$arr = explode(' ',trim($tmp));
					$res->description=$arr[0]." ".$arr[1];
					if($arr[1]=="of")
						$res->description.=" ".$arr[2];
				}
				continue;
			}
		}
		//Synopsis
		$pos = -1;
		for($i=0;$i<3;$i++){
			$pos = strpos($firstParagraph, '.', $pos+1);
			if ($pos === FALSE){
				$pos=-1;
				continue;
			}
		}
		if ($pos!=-1)
			$res->synopsis=substr($firstParagraph,0,$pos+1);
		else
			$res->synopsis=$firstParagraph;
		//img
		//echo $doc->find('a[@class="image"]',0)->attr["href"];
		$tmp= $doc->find('a[@class="image"]',0);
		$pattern = "/src=\"(.*?)\"/";
		preg_match($pattern, $tmp, $matches);
		$res->img_url=$matches[1];
		//events
		$sentences = explode('.',strip_tags($wikipediaData->parse->text->{'*'}));
		$years=array();
		foreach ($sentences as $sentence){
			//echo $sentence."<hr>";
			if (preg_match('~[0-9]~', $sentence)){
				if (preg_match('~\d\d\d\d~', $sentence)){
					preg_match_all('/\d\d\d\d/', $sentence, $matches);
					foreach($matches[0] as $matche){
						$year=intval($matche);
						if ($year<2015){
							if (!isset($years[$year]))
								$years[$year]=array();
							$years[$year][]=$sentence;
						}
					}
				}
				//else if	
							//year d
							//d BC
							//d AC
			}
		}
		ksort($years);
		//Krumo($years);
		$res->events=array();
		$i=0;
		foreach($years as $key=>$val){
			if ($i<5 || $i+1==count($years)){
				$event=new stdClass();
				$event->year=$key;
				$event->text=$val[0];
				$res->events[]=$event;
			}
			$i++;
		}
		//highlights
		//echo $wikipediaData->parse->text->{'*'};
		$highlights=array();
		foreach($doc->find('p a') as $element){
			if (strpos($element->href, '/wiki/') === 0) {
				$value_id=substr($element->href,6);
				$highlights[$value_id]=$element->text();
			}
		}
		//krumo($highlights);
		$res->highlights=array();
		foreach($highlights as $key => $value){
			foreach($sentences as $sentence){
				if (!empty($value) && strpos($sentence, $value ) !== false){
					$highlight=new stdClass();
					$highlight->value=$key;
					$highlight->name=$value;
					$highlight->description=$sentence;
					$res->highlights[]=$highlight;
					break;
				}
			}
		}
		

		return $res;
	}

}