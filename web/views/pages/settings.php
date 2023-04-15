<?php

const SECTIONS = [
	"profile"   => "Edit profile",
	"password"  => "Change password",
];

?><?php load_view("head"); ?>
<link rel="stylesheet" href="<?= e(asset("css/settings.css")); ?>"/>
<?php load_view("component/navbar"); ?>

<div id="main-box">
	<h1>Settings</h1>
	<div id="back-to-menu-box" style="display:none;">
		<a onclick="load_section_url('default', event);" href="?">Back to settings</a>
	</div>
	<table style="display:none;" id="set-default">
	<?php foreach (SECTIONS as $sec => $title): ?>
		<tr><td><a onclick="load_section_url('<?= $sec; ?>', event);" href="?section=<?= e($sec); ?>"><?= e($title); ?></a></td></tr>
	<?php endforeach; ?>
	</table>
	<?php foreach (SECTIONS as $key => $title): ?>
		<div class="setting-box" style="display:none;" id="set-<?= e($key); ?>">
		<?php load_view("pages/settings/{$key}", compact("u")); ?>
		</div>
	<?php endforeach; ?>
</div>

<script>
	const sections = <?= json_encode(array_merge(array_keys(SECTIONS), ["default"])); ?>;
	const back = gid("back-to-menu-box");

	function hide_all_sections() {
		back.style.display = "none";
		for (let i = 0; i < sections.length; i++)
			gid("set-" + sections[i]).style.display = "none";
	}

	function load_section(section) {
		hide_all_sections();
		gid("set-" + section).style.display = "";
		back.style.display = (section === "default") ? "none" : "";
	}

	function load_section_url(section, e = null) {
		if (e !== null)
			e.preventDefault();
		load_section(section);
		history.pushState(null, null, "?section=" + section);
	}

	load_section("<?= isset(SECTIONS[$section]) ? $section : "default" ?>");
</script>

<?php load_view("foot"); ?>
