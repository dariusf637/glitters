(function ($) {
	var frame;
	$(".glitters-pick-hero").on("click", function (event) {
		event.preventDefault();
		if (frame) {
			frame.open();
			return;
		}
		frame = wp.media({
			title: "Фото главного экрана",
			button: { text: "Использовать фото" },
			multiple: false,
			library: { type: "image" }
		});
		frame.on("select", function () {
			var attachment = frame.state().get("selection").first().toJSON();
			$("#glitters_hero_id").val(attachment.id);
			var url = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
			$(".glitters-hero-preview").html('<img src="' + url + '" alt="" style="max-width:320px;height:auto">');
		});
		frame.open();
	});
	$(".glitters-clear-hero").on("click", function (event) {
		event.preventDefault();
		$("#glitters_hero_id").val("0");
		$(".glitters-hero-preview").empty();
	});
})(jQuery);
