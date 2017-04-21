    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?=WEBROOT?>/admin/">Administrator</a>
        </div>
		
        <div class="navbar-collapse collapse">		
            <ul class="nav navbar-nav">			  
			  <? if(is_admin_logged()){ ?>	
				<li class="dropdown"><a href="customer-add.php">Add Customer</a></li>
				<li class="dropdown"><a href="customer-list.php">List Customers</a></li>
			  <? } ?>			  
            </ul>
			
			<ul class="nav navbar-nav navbar-right">
			<? if(is_admin_logged()){ ?>					
				<li><a href="logout.php">Logout</a></li>
			<? } else { ?>
				<li><a href="login.php">Login</a></li>
			<? } ?>
			</ul>		  
        </div><!--/.nav-collapse -->
		
      </div>
    </div>