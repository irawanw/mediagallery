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
				url: "../ajax/get-customer.php",
			},
			 "columnDefs": [
				{ "orderable": false, "targets": 4 },
				{ "orderable": false, "targets": 5 },
				{ "orderable": false, "targets": 6 },
			],
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
						url:  'customer-del.php',
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
	
	function sendmail(id){
		$.post('customer-uploaded.php?id='+id);
	}	
	</script>
	
	<div class="container">

	<? include("navigation.php"); ?>

		<div class="jumbotron">
			<h1>Customer List</h1>
			<table class="data-table" width="100%">
				<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email Address</th>
					<th>Date</th>
					<th>Upload</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				</thead>
			</table>
		</div>

	</div>

<? include("../footer.php"); ?>    