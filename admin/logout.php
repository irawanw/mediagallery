<? include("../header.php"); ?>

	<div class="container">

		<? include("navigation.php"); ?>
		
		<div class="jumbotron">
			Bye! <?=$_SESSION['user']['lastname']?> see you next time
			<?			
				session_destroy();				
			?>			
			<script>
				window.setTimeout(function(){
					// Move to a new location or you can do something else
					window.location.href = "<?=WEBROOT?>/admin/";
				}, 3000);
			</script>
		</div>
		
	</div>
		
<? include("../footer.php"); ?>  