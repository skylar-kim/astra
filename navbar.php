
<nav class="navbar navbar-expand-lg navbar-dark">
	<a class="navbar-brand navbar-text-style" href="index.php">ASTRA</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">

			<?php if ( !isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"] ): ?>
				
				<li class="nav-item">
					<a class="nav-link navbar-text-style" href="register.php">register</a>
				</li>
				<li class="nav-item">
					<a class="nav-link navbar-text-style" href="login.php">login</a>
				</li>

			<?php else: ?>
				<li class="nav-item">
					<a class="nav-link navbar-text-style" href="account.php"><?php echo $_SESSION["username"]; ?>'s account</a>
				</li>
				<li class="nav-item">
					<a class="nav-link navbar-text-style" href="logout.php">logout</a>
				</li>
				<?php if ( isset($_SESSION["username"]) && $_SESSION["username"] == "admin" ): ?>
					<li class="nav-item">
						<a class="nav-link navbar-text-style" href="create_form.php">create apod entry</a>
					</li>
				<?php endif; ?>
			<?php endif; ?>

			


			<li class="nav-item">
				<a class="nav-link navbar-text-style" href="search.php">search</a>
			</li>
		</ul>
	</div>
</nav>