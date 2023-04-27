<?php
$opt["title"] = "GWSpamD";
load_api("audit_log");

if (isset($_GET["page"])) {
    $page = (int)$_GET["page"];
} else {
    $page = 1;
}

if ($page <= 0)
    $page = 1;

$limit = 5;
$offset = ($page - 1) * $limit;

$st = get_audit_log_st($u["id"], $limit, $offset);
$nr_pages = get_audit_log_page_num($u["id"], $limit);

ob_start();
?>

<div class="container-fluid">
    <div class="content">
        <h1 class="content-title font-size-22">
            Welcome <?= e($u["first_name"]); ?>
        </h1>
        <div class="fake-content"></div>
        <div class="fake-content"></div>
    </div>
    <div class="row card bg-light-lm bg-dark-light-dm row-eq-spacing">
        <div class="col-6 col-xl-3">
            <div class="card">
                <h2 class="card-title">
                    Orders
                </h2>
                <div class="fake-content"></div>
                <div class="fake-content w-50 mw-full bg-primary"></div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card">
                <h2 class="card-title">
                    Sales
                </h2>
                <div class="fake-content"></div>
                <div class="fake-content w-50 mw-full bg-primary"></div>
            </div>
        </div>
        <div class="v-spacer d-xl-none"></div>
        <div class="col-6 col-xl-3">
            <div class="card">
                <h2 class="card-title">
                    Costs
                </h2>
                <div class="fake-content"></div>
                <div class="fake-content w-50 mw-full bg-primary"></div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card">
                <h2 class="card-title">
                    Profits
                </h2>
                <div class="fake-content"></div>
                <div class="fake-content w-50 mw-full bg-primary"></div>
            </div>
        </div>
    </div>
    <div class="row row-eq-spacing-lg">
        <div class="col-lg-8">
            <div class="card h-lg-250 overflow-y-lg-auto">
                <h2 class="card-title">
                    Customers
                </h2>
                <div class="fake-content mb-20"></div>
                <div class="fake-content mb-20"></div>
                <div class="fake-content bg-primary mb-20"></div>
                <div class="fake-content mb-20"></div>
                <div class="fake-content mb-20"></div>
                <div class="fake-content mb-20"></div>
                <div class="fake-content mb-10"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-lg-250 overflow-y-lg-auto">
                <h2 class="card-title">
                    Breakdown
                </h2>
                <div class="fake-content w-50 mw-full bg-primary d-inline-block"></div>
                <div class="fake-content w-50 mw-full bg-danger d-inline-block"></div>
                <div class="fake-content h-150 w-150 h-lg-100 w-lg-100 m-auto rounded-circle mt-10"></div>
                <br class="hidden-lg-and-up">
            </div>
        </div>
    </div>
    <div class="row row-eq-spacing-lg">
        <div class="col-lg-8">
            <div class="content">
                <h2 class="content-title">
                    Customer stories
                    <a href="#">#</a>
                </h2>
                <div class="fake-content"></div>
                <div class="fake-content"></div>
                <div class="fake-content w-100"></div>
            </div>
            <div class="card">
                <h2 class="card-title">
                    Transactions
                </h2>
                <div class="fake-content"></div>
                <div class="fake-content"></div>
                <div class="fake-content"></div>
                <div class="fake-content"></div>
                <div class="fake-content w-50 mw-full bg-primary mb-10"></div>
            </div>
            <div class="content">
                <div class="fake-content"></div>
                <div class="fake-content w-150"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="content">
                <h2 class="content-title">
                    Activity log
                    <a href="#">#</a>
                </h2>
                <table class="table">
                    <?php foreach ($st->fetchAll() as $row) : ?>
                        <tr>
                            <td><a href="audit_log.php#log-<?= e($row["id"]); ?>">#<?= e($row["id"]); ?></a></td>
                            <td><?= e($row["action"]); ?></td>
                            <td><?= e($row["created_at"]); ?></td>
                        </tr>
                    <?php endforeach; ?>

                </table>
                <a href="audit_log.php" class="btn btn-action btn-primary">More</a>
            </div>
        </div>
    </div>
</div>
