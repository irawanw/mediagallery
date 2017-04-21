<? 
include("../../../header.php"); 

global $db;

$sql 		= "SELECT * FROM customers";
$customers 	= $db->rawQuery($sql);

$i = 1;
foreach($customers as $row){
	//echo "<br>".$row['id']."<br>";
	$name 		= $row['firstname'].' '.$row['lastname'];
	$thumbpath	= 'files/'.$row['id'].'/thumbnail/';
	$playpath	= 'files/'.$row['id'].'/playback/';
	
	$video 		= 'files/'.$row['id'].'/'.$name.'.mp4';
	$thumbnail 	= 'files/'.$row['id'].'/thumbnail/'.$name.'.jpg';
	$video_play = 'files/'.$row['id'].'/playback/'.$name.'.mp4';
	
	echo "<br>".$video_play;
	
	if(!file_exists($video_play)){				
		if(!file_exists($thumbpath))
			mkdir($thumbpath, 0777, true);
		
		if(!file_exists($playpath))
			mkdir($playpath, 0777, true);
		
		echo exec("ffmpeg -i '$video' -vf scale=640:-1 -y '$video_play' 2>&1");		
		echo exec("ffmpeg -i '$video' -deinterlace -an -ss 20 -r 1 -y -vf scale=\"320:-1\" -vcodec mjpeg -f mjpeg '$thumbnail' 2>&1");		
	}	
		
	$i++;
}
?>