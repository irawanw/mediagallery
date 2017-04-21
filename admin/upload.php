<? 
	include("../header.php"); 
	include("session.php");
	
	$customer 	= new Customer;
	$data		= $customer->getbyid(intval($_GET['id']));
?>	
	<script src="../js/jquery.ui.widget.js"></script>
	<!-- The Templates plugin is included to render the upload/download listings -->
	<script src="../js/tmpl.min.js"></script>
	<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
	<script src="../js/load-image.all.min.js"></script>
	<!-- The Canvas to Blob plugin is included for image resizing functionality -->
	<script src="../js/canvas-to-blob.min.js"></script>
	<!-- blueimp Gallery script -->
	<script src="../js/jquery.blueimp-gallery.min.js"></script>
	<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
	<script src="../js/jquery.iframe-transport.js"></script>
	<!-- The basic File Upload plugin -->
	<script src="../js/jquery.fileupload.js"></script>
	<!-- The File Upload processing plugin -->
	<script src="../js/jquery.fileupload-process.js"></script>
	<!-- The File Upload image preview & resize plugin -->
	<script src="../js/jquery.fileupload-image.js"></script>
	<!-- The File Upload audio preview plugin -->
	<script src="../js/jquery.fileupload-audio.js"></script>
	<!-- The File Upload video preview plugin -->
	<script src="../js/jquery.fileupload-video.js"></script>
	<!-- The File Upload validation plugin -->
	<script src="../js/jquery.fileupload-validate.js"></script>
	<!-- The File Upload user interface plugin -->
	<script src="../js/jquery.fileupload-ui.js"></script>
	<!-- The main application script -->
	<script src="../js/main.js"></script>
	
	<link rel="stylesheet" href="../css/blueimp-gallery.min.css">
	<link rel="stylesheet" href="../css/jquery.fileupload.css">
	<link rel="stylesheet" href="../css/jquery.fileupload-ui.css">
	<noscript><link rel="stylesheet" href="../css/jquery.fileupload-noscript.css"></noscript>
	<noscript><link rel="stylesheet" href="../css/jquery.fileupload-ui-noscript.css"></noscript>
	
	<div class="container">

	<? include("navigation.php"); ?>
	
		<div class="jumbotron">
			<h1>Upload Video</h1>			
			
			<p>Select images or video to upload <strong><?=$data['firstname'].' '.$data['lastname'];?></strong></p>
			
		    <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
				<!-- Redirect browsers with JavaScript disabled to the origin page -->
				<noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
				<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
				<div class="row fileupload-buttonbar">
					<div class="col-lg-7">
						<!-- The fileinput-button span is used to style the file input field as button -->
						<span class="btn btn-success fileinput-button">
							<i class="glyphicon glyphicon-plus"></i>
							<span>Add files...</span>
							<input type="file" name="files[]" multiple>
						</span>
						<button type="submit" class="btn btn-primary start">
							<i class="glyphicon glyphicon-upload"></i>
							<span>Start upload</span>
						</button>
						<button type="reset" class="btn btn-warning cancel">
							<i class="glyphicon glyphicon-ban-circle"></i>
							<span>Cancel upload</span>
						</button>
						<button type="button" class="btn btn-danger delete">
							<i class="glyphicon glyphicon-trash"></i>
							<span>Delete</span>
						</button>
						<input type="checkbox" class="toggle">
						<!-- The global file processing state -->
						<span class="fileupload-process"></span>
					</div>
					<!-- The global progress state -->
					<div class="col-lg-5 fileupload-progress fade">
						<!-- The global progress bar -->
						<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<div class="progress-bar progress-bar-success" style="width:0%;"></div>
						</div>
						<!-- The extended global progress state -->
						<div class="progress-extended">&nbsp;</div>
					</div>
				</div>
				<!-- The table listing the files available for upload/download -->
				<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
			</form>
		</div>		
	</div>
	
	<!-- The blueimp Gallery widget -->
	<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
		<div class="slides"></div>
		<h3 class="title"></h3>
		<a class="prev">‹</a>
		<a class="next">›</a>
		<a class="close">×</a>
		<a class="play-pause"></a>
		<ol class="indicator"></ol>
	</div>
	
	<script>
		$(document).ready(function () {
			'use strict';


			// Initialize the jQuery File Upload widget:
			$('#fileupload').fileupload({
				// Uncomment the following to send cross-domain cookies:
				//xhrFields: {withCredentials: true},
				url: 'server/php/?id=' + <?=$_GET['id']?>
			});

			// Enable iframe cross-domain access via redirect option:
			$('#fileupload').fileupload(
				'option',
				'redirect',
				window.location.href.replace(
					/\/[^\/]*$/,
					'/cors/result.html?%s'
				)
			);

			if (window.location.hostname === 'blueimp.github.io') {
				// Demo settings:
				$('#fileupload').fileupload('option', {
					url: '//jquery-file-upload.appspot.com/',
					// Enable image resizing, except for Android and Opera,
					// which actually support image resizing, but fail to
					// send Blob objects via XHR requests:
					disableImageResize: /Android(?!.*Chrome)|Opera/
						.test(window.navigator.userAgent),
					maxFileSize: 999000,
					acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
				});
				// Upload server status check for browsers with CORS support:
				if ($.support.cors) {
					$.ajax({
						url: '//jquery-file-upload.appspot.com/',
						type: 'HEAD'
					}).fail(function () {
						$('<div class="alert alert-danger"/>')
							.text('Upload server currently unavailable - ' +
									new Date())
							.appendTo('#fileupload');						
					});
				}
			} else {
				// Load existing files:
				$('#fileupload').addClass('fileupload-processing');
				$.ajax({
					// Uncomment the following to send cross-domain cookies:
					//xhrFields: {withCredentials: true},
					url: $('#fileupload').fileupload('option', 'url'),
					dataType: 'json',
					context: $('#fileupload')[0]
				}).always(function () {
					$(this).removeClass('fileupload-processing');
				}).done(function (result) {					
					$(this).fileupload('option', 'done')
						.call(this, $.Event('done'), {result: result});					
				});
				
				$('#fileupload').bind('fileuploaddone', function (e, data) {
					$.post('customer-uploaded.php?id=<?=$_GET['id']?>');
				})
			}
		});		
	</script>
	<!-- The template to display files available for upload -->
	<script id="template-upload" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
		<tr class="template-upload fade">
			<td>
				<span class="preview"></span>
			</td>
			<td>
				<p class="name">{%=file.name%}</p>
				<strong class="error text-danger"></strong>
			</td>
			<td>
				<p class="size">Processing...</p>
				<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
			</td>
			<td>
				{% if (!i && !o.options.autoUpload) { %}
					<button class="btn btn-primary start" disabled>
						<i class="glyphicon glyphicon-upload"></i>
						<span>Start</span>
					</button>
				{% } %}
				{% if (!i) { %}
					<button class="btn btn-warning cancel">
						<i class="glyphicon glyphicon-ban-circle"></i>
						<span>Cancel</span>
					</button>
				{% } %}
			</td>
		</tr>
	{% } %}
	</script>
	<!-- The template to display files available for download -->
	<script id="template-download" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
		<tr class="template-download fade">
			<td>
				<span class="preview">
					{% if (file.thumbnailUrl) { %}
						<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img width="80px" src="{%=file.thumbnailUrl%}"></a>
					{% } %}
				</span>
			</td>
			<td>
				<p class="name">
					{% if (file.url) { %}
						<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
					{% } else { %}
						<span>{%=file.name%}</span>
					{% } %}
				</p>
				{% if (file.error) { %}
					<div><span class="label label-danger">Error</span> {%=file.error%}</div>
				{% } %}
			</td>
			<td>
				<span class="size">{%=o.formatFileSize(file.size)%}</span>
			</td>
			<td>
				{% if (file.deleteUrl) { %}
					<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}&id=<?=$_GET['id']?>"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
						<i class="glyphicon glyphicon-trash"></i>
						<span>Delete</span>
					</button>
					<input type="checkbox" name="delete" value="1" class="toggle">
				{% } else { %}
					<button class="btn btn-warning cancel">
						<i class="glyphicon glyphicon-ban-circle"></i>
						<span>Cancel</span>
					</button>
				{% } %}
			</td>
		</tr>
	{% } %}
	</script>
		
<? include("../footer.php"); ?>  