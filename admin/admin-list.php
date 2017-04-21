<? 
	include("../header.php"); 
	include("session.php"); 
	
	$customer 	= new Customer;
	$data		= $customer->get();
?>
	
	<script>	
	$(document).ready(function() {
		$('.data-table').DataTable({   
			"processing": true,			
			"serverSide": true,			
			"ajax": {
				url: "../ajax/get-admin.php",
			},
			"autoWidth": false,
			<? if($_SESSION['search_count'] != ''){ ?>				
				"pageLength": <?=$_SESSION['search_count']?>			
			<? } else { ?>				
				"pageLength": 20
			<? } ?>	
		});		
		
		$('.data-table').on( 'draw.dt', function () {
			$('a.delete').click(function(e) {
				e.preventDefault();
				var isgood = confirm('Are you sure want to delete this record?');
				if(isgood){
					var parent = $(this).parents('tr');
					$.ajax({
						type: 'post',
						url:  'admin-del.php',
						data: 'id=' + $(this).attr('id').replace('record-',''),
						beforeSend: function() {
							parent.animate({'backgroundColor':'#fb6c6c'},300);
						},
						success: function() {
							parent.fadeOut(300,function() {
								parent.remove();
							});
						}
					})
				}
			});
		} );				
	});
	</script>
	
	<div class="container">

	<? include("navigation.php"); ?>

		<div class="jumbotron">
			<h1>Admin List</h1>
			<table class="data-table" width="100%">
				<thead>
				<tr>
					<th>Name</th>
					<th>Email Address</th>
					<th>Action</th>
				</tr>
				</thead>
			</table>
		</div>

	</div>

<? include("../footer.php"); ?>    