<?php
const MENU_NAVBAR = [
	"home"      => "Home",
	"profile" => "Profile",
	"settings"  => "Settings"
];

?>
<?php if (isset($_SESSION["user_id"])) : ?>
	<div class="navbar position-absolute z-10 top-0">
		<div class="navbar-content mr-5">
			<button id="toggle-sidebar-btn" class="btn btn-action" type="button" onclick="halfmoon.toggleSidebar()">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-bar-left" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M11.854 3.646a.5.5 0 0 1 0 .708L8.207 8l3.647 3.646a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708 0zM4.5 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 1 0v-13a.5.5 0 0 0-.5-.5z" />
				</svg>
			</button>
		</div>
		<form class="form-inline w-full ml-auto" action="..." method="...">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search" required="required">
				<div class="input-group-append">
					<button class="btn" type="submit">
						<i class="fa fa-search" aria-hidden="true"></i>
						<span class="sr-only">Search</span>
					</button>
				</div>
			</div>
		</form>
		<div class="navbar-content mt-5 ml-5">
			<div class="dropdown with-arrow">
				<a style="cursor:pointer;" data-toggle="dropdown" type="button" id="navbar-dropdown-toggle-btn-1">
					<img class="user-dropdown img-fluid rounded-circle" src="<?= e($u["photo_path"]); ?>" alt="<?= e($u["full_name"]); ?> Images" />
				</a>
				<div class="dropdown-menu dropdown-menu-right w-200" aria-labelledby="navbar-dropdown-toggle-btn-1">
					<?php foreach (MENU_NAVBAR as $k => $m) : ?>
						<a href="<?= e($k); ?>.php" class="dropdown-item <?= ($g_active == $k) ? " text-primary" : ""; ?>"><?= e($m); ?></a>
					<?php endforeach; ?>
					<div class="dropdown-divider"></div>
					<div class="dropdown-content">
						<button onclick="halfmoon.toggleDarkMode()" class="btn mb-5 btn-block">
							<span class="hidden-lm">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16">
									<path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
									<path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
								</svg>
							</span>
							<span class="hidden-dm">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sun-fill" viewBox="0 0 16 16">
									<path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
								</svg>
							</span>
						</button>
						<a href="logout.php" class="btn btn-danger btn-block">Logout</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
