<? include("../header.php"); ?>

<? include("../navigation.php"); ?>
	
<?

	$customer 	= new Customer;
	$data		= $customer->getbyid(intval($_GET['id']));
	
	$i = 0;
	foreach(glob('../admin/server/php/files/'.$_GET['id'].'/*{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF,*.tif,*.TIF,*.bmp,*.BMP}', GLOB_BRACE) as $file) {
		$files[$i]['hash'] = md5(basename($file).SECRET_HASH);
		$files[$i]['file'] = basename($file);
		$ext = explode('.', basename($file));
		$files[$i]['thumbnail'] = basename($file);		
		
		if($data['paid'])
			$files[$i]['file_link']  = 'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/admin/server/php/files/'.$_GET['id'].'/'.rawurlencode(basename($file));
		else
			$files[$i]['file_link']  = 'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/watermark.php?id='.$_GET['id'].'&file='.rawurlencode(basename($file));
		
		$files[$i]['thumb_link'] = 'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/admin/server/php/files/'.$_GET['id'].'/thumbnail/'.rawurlencode($files[$i]['thumbnail']);
		$i++;
	}		
	
	foreach(glob('../admin/server/php/files/'.$_GET['id'].'/selfie/*{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF,*.tif,*.TIF,*.bmp,*.BMP}', GLOB_BRACE) as $file) {
		$selfie[$i]['hash'] = md5(basename($file).SECRET_HASH);
		$selfie[$i]['file'] = basename($file);
		$ext = explode('.', basename($file));
		$selfie[$i]['thumbnail'] = basename($file);		
		
		if($data['paid_selfie'])
			$selfie[$i]['file_link']  = 'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/admin/server/php/files/'.$_GET['id'].'/selfie/'.rawurlencode(basename($file));
		else
			$selfie[$i]['file_link']  = 'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/watermark.php?id='.$_GET['id'].'&folder=selfie&file='.rawurlencode(basename($file));
		
		$selfie[$i]['thumb_link'] = 'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/admin/server/php/files/'.$_GET['id'].'/selfie/thumbnail/'.rawurlencode($selfie[$i]['thumbnail']);
		$i++;
	}			
	
	$i = 0;
	foreach(glob('../admin/server/php/files/'.$_GET['id'].'/{*.avi,*.AVI,*.flv,*.FLV,*.mkv,*.MKV,*.mp4,*.MP4,*.mov,*.MOV,*.wmv,*.WMV}', GLOB_BRACE) as $file) {		
		$ext = explode('.', basename($file));
		$videos[$i]['hash'] = md5(basename($file).SECRET_HASH);			
		$videos[$i]['thumbnail'] = $ext[0].'.jpg';						
		$videos[$i]['file_link']  = 'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/admin/server/php/files/'.$_GET['id'].'/'.rawurlencode(basename($file));
		$videos[$i]['play_link']  = 'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/admin/server/php/files/'.$_GET['id'].'/playback/'.rawurlencode(basename($file));
		$videos[$i]['thumb_link'] = 'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/admin/server/php/files/'.$_GET['id'].'/thumbnail/'.rawurlencode($videos[$i]['thumbnail']);
		
		if(!file_exists('../admin/server/php/files/'.$_GET['id'].'/thumbnail/'.$videos[$i]['thumbnail']))
			$videos[$i]['thumb_link'] = 'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/admin/server/php/files/thumbnail/vidthumb.jpg';
		$i++;
	}	

?>
	<style>
		#header-index{
			background: none;
			padding-top: 50px;
		}
	</style>
	<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
	<link rel="stylesheet" href="/css/bootstrap-image-gallery.css">
	<div class="col-lg-12">
	
		<? if($data['firstname'] != '') { ?>
			<h2>Hello <?=$data['firstname']?>! Welcome to Your Jump Gallery</h2>		
			<?
			//if($_GET['email'] == 'irawan.wijanarko@gmail.com'){
				if(
						($data['paid'] == 1 && $data['paid_selfie'] == 0) ||
						($data['paid'] == 0 && $data['paid_selfie'] == 0)
					){
					echo '<a style="							
							border: none;
							background-image: none;
							background-color: green !important;"	
						class="btn btn-info" role="button" href="purchase.php?email='.$_GET['email'].'&id='.$_GET['id'].'">Purchase Now</a>';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}
			//}
			?>		

			<?	if($data['paid'] == 1 && $data['paid_selfie'] == 1){ ?>
			<a href="http://<?=$_SERVER['HTTP_HOST'].WEBROOT.'/admin/download-all.php?id='.$_GET['id'].'&code='.md5($_GET['id'].$_GET['email']);?>" class="btn btn-info" role="button">Download All Files</a>
			<? } ?>
			
			<div id="my-picture" style="padding-top: 15px">
				<b>Image Gallery</b><br>
				<?	foreach($files as $row){ ?>
					<div style="float: left; margin-right: 10px; ">
						<a data-gallery href="<? echo $row['file_link']; ?>">
							<img style="height: 80px" 
								src="<? echo  $row['thumb_link']; ?>"><br>								
						</a>
						<a style="font-size: 12px" href="http://<?=$_SERVER['HTTP_HOST'].WEBROOT.'/admin/download.php?id='.$_GET['id'].'&code='.$row['hash'];?>">Download</a>
					</div>
				<?	} ?>
				<div style="clear: both;"></div>
			</div>			
			
			<div id="my-picture" style="padding-top: 15px">
				<b>Selfie Gallery</b><br>
				<?	foreach($selfie as $row){ ?>
					<div style="float: left; margin-right: 10px; ">
						<a data-gallery href="<? echo $row['file_link']; ?>">
							<img style="height: 80px" 
								src="<? echo  $row['thumb_link']; ?>"><br>								
						</a>
						<a style="font-size: 12px" href="http://<?=$_SERVER['HTTP_HOST'].WEBROOT.'/admin/download.php?id='.$_GET['id'].'&folder=selfie&code='.$row['hash'];?>">Download</a>
					</div>
				<?	} ?>
				<div style="clear: both;"></div>
			</div>						
			
			<div id="my-videos" style="padding-top: 15px">
				<b>Video Gallery</b><br>
				<?	foreach($videos as $row){ ?>
					<div style="float: left; margin-right: 10px; ">
						<a
							data-gallery 
							href="<? echo $row['play_link']; ?>"
							type="video/mp4"
							data-poster="<? echo $row['thumb_link']; ?>"
							data-sources='[{"href": "<? echo $row['play_link']; ?>", "type": "video/mp4"}]'>
							<img style="height: 80px" src="<? echo $row['thumb_link']; ?>">
						</a><br>
						<a style="font-size: 12px" href="http://<?=$_SERVER['HTTP_HOST'].WEBROOT.'/admin/download.php?id='.$_GET['id'].'&code='.$row['hash'];?>">Download</a>
					</div>
				<? } ?>
			</div>
						
		<? } else { ?>
		Sorry we can't find your email address.
		<? } ?>
		
	</div>
	<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
	<script src="/js/bootstrap-image-gallery.js"></script>
	<script>
		$(document).ready(function(){
			$('#blueimp-gallery').data('useBootstrapModal', !true);
			$('#blueimp-gallery').toggleClass('blueimp-gallery-controls', true);
		})
	</script>
	<div id="blueimp-gallery" class="blueimp-gallery">
		<!-- The container for the modal slides -->
		<div class="slides"></div>
		<!-- Controls for the borderless lightbox -->
		<h3 class="title"></h3>
		<a class="prev">‹</a>
		<a class="next">›</a>
		<a class="close">×</a>
		<a class="play-pause"></a>
		<ol class="indicator"></ol>
		<!-- The modal dialog, which will be used to wrap the lightbox content -->
		<div class="modal fade">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" aria-hidden="true">&times;</button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body next"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left prev">
							<i class="glyphicon glyphicon-chevron-left"></i>
							Previous
						</button>
						<button type="button" class="btn btn-primary next">
							Next
							<i class="glyphicon glyphicon-chevron-right"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<? include("../footer.php"); ?>  		