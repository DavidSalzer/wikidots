$(function () {
    $(".hand").click(function () {
        //$(".main-data").css("visibility","visible");
        //      $(".main-data").css("opacity","1");
        $(".main-data").fadeIn();
    });
    $(".x-button").click(function () {
        //$(".main-data").css("visibility","hidden");
        //       $(".main-data").css("opacity","0");
        $(".main-data").fadeOut();
    });

    $selectedHighlights = null;
    $(".highlights-item .high-img").click(function () {
        if ($selectedHighlights != null && $selectedHighlights[0] == $(this).parent(".highlights-item")[0]) {
            $(".highlights-item").removeClass("selected");
            $selectedHighlights = null;
            $(".main-data").removeClass("point-selected");
        }
        else {
            $selectedHighlights = $(this).parent(".highlights-item");
            $(".main-data").addClass("point-selected");
			$(".highlights-item").removeClass("selected");
            $selectedHighlights.addClass("selected");
            $(".main-data.point-selected .synopsis .highlights-text").html($selectedHighlights.attr("data-description"));
            $(".main-data.point-selected .learn-more").attr("href", "?id=" + $selectedHighlights.attr("data-id"));
        }
    })
	
	$( ".search" ).autocomplete({
		source: valuesName,
		close: searchChange
	});
	
	$(".search-form").submit(searchChange);
	
	function searchChange(){
		var valueName=$( ".search" ).val();
		var valueID=null;
		values.forEach(function(element){
			if (valueName==element.valueName)
				valueID=element.valueID;
		});
		window.location = "/?id="+valueID;
		
		return false;
	}



})

function hideSidebar(){
    $("#sidebar").css("visibility","hidden");
    $("#sidebar").css("opacity","0");
}

function showSidebar(){
    $("#sidebar").css("visibility","visible");
    $("#sidebar").css("opacity","1");
}
