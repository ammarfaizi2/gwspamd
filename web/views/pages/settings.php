<?php

const SECTIONS = [
	"profile"   => "Edit profile",
	"password"  => "Change password",
];

if (isset(SECTIONS[$section])) {
	$opt["title"] = "Settings | " . SECTIONS[$section];
} else {
	$opt["title"] = "Settings";
}

?>


<script>
	function toggle_all_inputs(enable) {
		let inputs = document.querySelectorAll("input[type=text], input[type=email], input[type=password]");
		for (let i = 0; i < inputs.length; i++) {
			inputs[i].readOnly = !enable;
			if (!enable)
				inputs[i].classList.add("disabled");
			else
				inputs[i].classList.remove("disabled");
		}
	}
</script>
<div class="row">
<div class="col-lg-3">
	<div class="content">
		<h2 class="content-title">Settings</h2>
		<?php foreach (SECTIONS as $sec => $title) : ?>
			<a class="btn sidebar-link mt-5 setting-btn" id="btn-<?= e($sec); ?>" onclick="load_section_url('<?= $sec; ?>', event);" href="?section=<?= e($sec); ?>"><?= e($title); ?></a>
		<?php endforeach; ?>
	</div>
</div>
<div class="col-lg-9">
	<?php foreach (SECTIONS as $key => $title) : ?>
		<div class="content" style="display:none;" id="set-<?= e($key); ?>">
			<?php require __DIR__ . "/settings/{$key}.php"; ?>
		</div>
	<?php endforeach; ?>
</div>
</div>
<script>
	const sections = <?= json_encode(array_keys(SECTIONS)); ?>;

	function hide_all_sections() {
		for (let i = 0; i < sections.length; i++)
			gid("set-" + sections[i]).style.display = "none";
		let settings_btn = document.getElementsByClassName("setting-btn");
		for (let i = 0; i < sections.length; i++)
			settings_btn[i].classList.remove("btn-primary");
	}

	function load_section(section) {
		hide_all_sections();
		gid("set-" + section).style.display = "";
		gid("btn-" + section).classList.add("btn-primary");
	}

	function load_section_url(section, e = null) {
		load_section(section);
		if (e !== null) {
			e.preventDefault();
			e.target.classList.add("btn-primary");
		}
		history.pushState(null, null, "?section=" + section);
	}

	load_section("<?= isset(SECTIONS[$section]) ? $section : "profile" ?>");
</script>
