<?php

const MENU_SIDEBAR = [
    "home"      => "Home",
    "audit_log" => "Audit Log",
    "settings"  => "Settings"
];

?><div class="sidebar-overlay" onclick="halfmoon.toggleSidebar()"></div>
<div class="sidebar bg-very-dark-dm">
  <div class="sidebar-menu">
    <a href="#" class="sidebar-brand">
      GWSpamD
    </a>
    <div class="sidebar-divider"></div>
    <?php foreach (MENU_SIDEBAR as $k => $m): ?>
      <a href="<?= e($k); ?>.php" class="sidebar-link<?= ($g_active == $k) ? " active" : ""; ?>"><?= e($m); ?></a>
    <?php endforeach; ?>
  </div>
</div>
