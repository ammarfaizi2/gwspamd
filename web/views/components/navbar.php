<?php if (isset($_SESSION["user_id"])): ?>
<div id="navbar">
	<a href="home.php"><button>Home</button></a>
	<a href="profile.php"><button>Profile</button></a>
	<a href="settings.php"><button>Settings</button></a>
	<a href="logout.php"><button>Logout</button></a>
</div>
<?php endif; ?>
