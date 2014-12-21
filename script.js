$(function () {
    $(".hand").click(function () {

        if ($(".main-data").is(":visible")) {
            $(".main-data").fadeOut();
            $(".hand-line").fadeOut();
        }
        else {
            $(".main-data").fadeIn();
            $(".hand-line").fadeIn();
            $(".popup-oops").hide();
            hideSidebar();
        }

    });
    $(".x-button").click(function () {
        $(".main-data").fadeOut();
        $(".hand-line").fadeOut();
    });




    $selectedHighlights = null;
    $(".highlights-item .high-img").click(function () {
        if ($selectedHighlights != null && $selectedHighlights[0] == $(this).parent(".highlights-item")[0]) {
            $(".highlights-item").removeClass("selected");
            $selectedHighlights = null;
            $(".main-data").removeClass("point-selected");
            $(".back-button").hide();
        }
        else {
            $selectedHighlights = $(this).parent(".highlights-item");
            $(".main-data").addClass("point-selected");
            $(".back-button").show();
            $(".highlights-item").removeClass("selected");
            $selectedHighlights.addClass("selected");
            $(".main-data.point-selected .synopsis .highlights-text").html($selectedHighlights.attr("data-description"));
            if ($selectedHighlights.attr("data-id") != "")
                $(".main-data.point-selected .learn-more").attr("href", "?id=" + $selectedHighlights.attr("data-id"));
            else
                $(".main-data.point-selected .learn-more").attr("href", 'javascript:$(".popup-oops").show();');
        }
    })

    $(".magnifying-glass").click(function () {
        searchChange();
    })

    $(".create-new").click(function () {
        $(".popup-oops").show();
        hideSidebar();
        $(".main-data").hide();
        $(".hand-line").hide();

    })

    $(".back-button").click(function () {

        $(".highlights-item").removeClass("selected");
        $selectedHighlights = null;
        $(".main-data").removeClass("point-selected");
        $(".back-button").hide();
    })


    $(".search").autocomplete({
        source: valuesName,
        close: searchChange
    });

    $(".search-form").submit(searchChange);

    function searchChange() {
        var valueName = $(".search").val();
        var valueID = null;
        values.forEach(function (element) {
            if (valueName == element.valueName)
                valueID = element.valueID;
        });
        if (valueID != null)
            window.location = "/?id=" + valueID;
        else
            $(".popup-oops").show();
        hideSidebar();
        return false;
    }

    $(" .popup .x-popup").click(function () {
        $(".popup-oops").hide();
    })



})

function hideSidebar() {
    $("#sidebar").css("right", "-237px");
}

function showSidebar() {
    $(".popup-oops").hide();
    $(".main-data").hide();
    $(".hand-line").hide();
    $("#sidebar").css("right", "0");
}

function showDescOnDot(dot) {
    var timelineWidth = $(".timeline").width()
    timelineWidth.toString().substring(0, timelineWidth.length - 2);
    var left = $(dot).css("left")
    var dotLeft = left.toString().substring(0, left.length - 2);
    if (parseInt(dotLeft) > parseInt(timelineWidth / 2)) {
        $(dot).find('.dot_discription').css('right', '0px');
        $(dot).find('.dot_discription').css('position', 'absolute');
    }


}
