<?php

$opt["title"] = $u["full_name"];

?>
<div class="mw-full card   text-center">
	<img id="user-photo" class="img-fluid mt-5 rounded-circle" src="<?= e($u["photo_path"]); ?>" alt="<?= e($u["full_name"]); ?> Images">

	<h1 class="font-weight-bolder"><?= $u["full_name"]; ?> <a href="settings.php?section=profile">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
				<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
				<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
			</svg>
		</a>
	</h1>
</div>

<div class="row row-eq-spacing-lg">
	<div class="col-lg-4">
		<div class="card">
			<h2 class="card-title">
				Info
			</h2>
			<table class="table">
				<tbody>
					<tr>
						<th>User ID</th>
						<td><?= e($u["id"]); ?></td>
					</tr>
					<tr>
						<th>First Name</th>
						<td><?= e($u["first_name"]); ?></td>
					</tr>
					<tr>
						<th>Last Name</th>
						<td><?= e($u["last_name"]); ?></td>
					</tr>
					<tr>
						<th>User Name</th>
						<td><?= e($u["username"]); ?></td>
					</tr>
					<tr>
						<th>Email</th>
						<td><?= e($u["email"]); ?></td>
					</tr>
				</tbody>
			</table>
			<a href="settings.php?section=profile" class="btn btn-action m-5">Edit Profile</a>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="card">
			<h2 class="card-title">
				Stats
			</h2>
			<div class="content h-full">
				<canvas id="chart-demo" class="w-full h-auto"></canvas>
			</div>
			<div class="fake-content bg-primary mb-20"></div>
			<div class="fake-content mb-20"></div>
			<div class="fake-content mb-20"></div>
			<div class="fake-content mb-20"></div>
			<div class="fake-content mb-10"></div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?= e(asset("js/chart.min.js")); ?>"></script>
<script type="text/javascript">
function getChartOptions() {
    return {
        type: "line",
				data: {
					labels: ['Sun', 'Mon', 'Tue', 'Thu', 'Fri', 'Sat'],
					datasets: [{
						label: '# Not Spam',
						data: [12, 19, 3, 5, 2, 3],
						borderWidth: 2,
						borderColor: '#36A2EB',
					}, {
						label: '# Spam',
						data: [16, 10, 7, 2, 9, 4],
						borderWidth: 2,
						borderColor: '#FF6384',
					}]
				},

				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
    }
}
var rootElem = document.documentElement;
try {
    var demoChart = new Chart(
        gid("chart-demo").getContext("2d"),
        getChartOptions()
    );
}
catch(err) {}
</script>
