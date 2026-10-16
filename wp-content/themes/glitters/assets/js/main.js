(function () {
	var header = document.querySelector(".site-header");
	var toggle = document.querySelector(".nav-toggle");
	var nav = document.querySelector(".site-nav");
	var themeBtn = document.querySelector(".theme-toggle");
	var themeKey = "glitters-theme";

	function themeIsDark() {
		return document.documentElement.getAttribute("data-theme") === "dark";
	}

	function paintTheme(dark) {
		document.documentElement.setAttribute("data-theme", dark ? "dark" : "light");
		document.querySelectorAll('meta[name="theme-color"]').forEach(function (meta) {
			meta.setAttribute("content", dark ? "#141210" : "#F6F3EE");
		});
		if (!themeBtn) return;
		themeBtn.setAttribute("aria-pressed", dark ? "true" : "false");
		themeBtn.setAttribute("aria-label", dark ? "Включить дневной режим" : "Включить ночной режим");
	}

	paintTheme(themeIsDark());
	if (themeBtn) {
		themeBtn.addEventListener("click", function () {
			var next = !themeIsDark();
			try { localStorage.setItem(themeKey, next ? "dark" : "light"); } catch (e) {}
			paintTheme(next);
		});
	}
	var scheme = window.matchMedia("(prefers-color-scheme: dark)");
	if (scheme.addEventListener) {
		scheme.addEventListener("change", function () {
			var saved = null;
			try { saved = localStorage.getItem(themeKey); } catch (e) {}
			if (saved === "dark" || saved === "light") return;
			paintTheme(scheme.matches);
		});
	}

	function onScroll() {
		if (!header) return;
		header.classList.toggle("is-scrolled", window.scrollY > 12);
	}
	onScroll();
	window.addEventListener("scroll", onScroll, { passive: true });

	function closeNav() {
		document.body.classList.remove("nav-open");
		if (header) header.classList.remove("is-open");
		if (toggle) {
			toggle.setAttribute("aria-expanded", "false");
			toggle.setAttribute("aria-label", toggle.getAttribute("data-open") || "Открыть меню");
		}
	}

	if (toggle && nav) {
		toggle.addEventListener("click", function () {
			var open = document.body.classList.toggle("nav-open");
			if (header) header.classList.toggle("is-open", open);
			toggle.setAttribute("aria-expanded", open ? "true" : "false");
			toggle.setAttribute("aria-label", open ? (toggle.getAttribute("data-close") || "Закрыть меню") : (toggle.getAttribute("data-open") || "Открыть меню"));
		});
		nav.querySelectorAll("a").forEach(function (link) {
			link.addEventListener("click", closeNav);
		});
		document.addEventListener("keydown", function (event) {
			if (event.key === "Escape") closeNav();
		});
	}

	var reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
	var wide = window.matchMedia("(min-width: 900px)");
	var nodes = document.querySelectorAll("[data-parallax]");
	if (!reduce && nodes.length && wide.matches) {
		var ticking = false;
		var update = function () {
			nodes.forEach(function (el) {
				var rect = el.getBoundingClientRect();
				var shift = (rect.top - window.innerHeight * 0.5) * -0.05;
				var limited = Math.max(-24, Math.min(24, shift));
				el.style.transform = "translate3d(0," + limited.toFixed(1) + "px,0)";
			});
			ticking = false;
		};
		window.addEventListener("scroll", function () {
			if (!ticking) {
				window.requestAnimationFrame(update);
				ticking = true;
			}
		}, { passive: true });
		update();
	}

	document.querySelectorAll(".salon-film").forEach(function (video) {
		var button = video.parentElement.querySelector(".film-toggle");
		var pauseLabel = button ? (button.getAttribute("data-pause") || "Пауза") : "Пауза";
		var playLabel = button ? (button.getAttribute("data-play") || "Смотреть") : "Смотреть";
		if (reduce) {
			video.removeAttribute("autoplay");
			video.pause();
			if (button) {
				button.textContent = playLabel;
				button.setAttribute("aria-pressed", "false");
			}
		} else {
			var play = video.play();
			if (play && play.catch) {
				play.catch(function () {
					if (button) {
						button.textContent = playLabel;
						button.setAttribute("aria-pressed", "false");
					}
				});
			}
		}
		if (!button) return;
		button.addEventListener("click", function () {
			if (video.paused) {
				video.play();
				button.textContent = pauseLabel;
				button.setAttribute("aria-pressed", "true");
			} else {
				video.pause();
				button.textContent = playLabel;
				button.setAttribute("aria-pressed", "false");
			}
		});
	});

	var track = document.querySelector(".reviews-track");
	var prev = document.querySelector(".reviews-prev");
	var next = document.querySelector(".reviews-next");
	if (track && prev && next) {
		var step = function () {
			var card = track.querySelector(".review");
			return card ? card.getBoundingClientRect().width + 18 : 320;
		};
		prev.addEventListener("click", function () {
			track.scrollBy({ left: -step(), behavior: reduce ? "auto" : "smooth" });
		});
		next.addEventListener("click", function () {
			track.scrollBy({ left: step(), behavior: reduce ? "auto" : "smooth" });
		});
	}

	var form = document.querySelector(".contact-form");
	if (form) {
		form.addEventListener("submit", function (event) {
			var errors = [];
			var name = form.querySelector("[name='guest_name']");
			var phone = form.querySelector("[name='guest_phone']");
			var consent = form.querySelector("[name='consent']");
			if (!name.value.trim() || name.value.trim().length < 2) errors.push("Укажите имя.");
			if (phone.value.replace(/\D/g, "").length < 10) errors.push("Укажите телефон.");
			if (consent && !consent.checked) errors.push("Нужно согласие на обработку персональных данных.");
			var box = form.querySelector(".form-errors");
			if (!errors.length) {
				if (box) box.remove();
				return;
			}
			event.preventDefault();
			if (!box) {
				box = document.createElement("div");
				box.className = "form-errors";
				box.setAttribute("role", "alert");
				form.prepend(box);
			}
			box.innerHTML = errors.map(function (item) { return "<p>" + item + "</p>"; }).join("");
		});
	}
})();
