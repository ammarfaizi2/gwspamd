// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

function gid(id)
{
	return document.getElementById(id);
}

function toastErorrAlert(errorMsg) {
  halfmoon.initStickyAlert({
    content: errorMsg || "Unknown error",
    title: "Error",
    alertType: "alert-danger",
    fillType: "filled-lm"
  });
}
