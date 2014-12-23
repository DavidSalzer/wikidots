$(function () {
    $("body.value-page .hand").click(function () {

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
	
	$("body.home-page .hand").click(function () {
		showSidebar();
	})
	
	
    $(".x-button").click(function () {
        $(".main-data").fadeOut();
        $(".hand-line").fadeOut();
    });

    $(".play").click(function () {
        $(".youtube-iframe").fadeIn();
        var url = $(".play").attr("vidio-url");
        var v = url.split('v=')[1];
        $("#youtubeIframe").attr("src", "//www.youtube.com/embed/" + v);
        //www.youtube.com/embed/PBN0nqQX5xo
    });


    $selectedHighlights = null;
    $("body.value-page .highlights-item .high-img").click(function () {
        if ($selectedHighlights != null && $selectedHighlights[0] == $(this).parent(".highlights-item")[0]) {
            $(".highlights-item").removeClass("selected");
            $(".synopsis").removeClass("selectedsyn");
            $selectedHighlights = null;
            $(".main-data").removeClass("point-selected");
            $(".back-button").hide();
        }
        else {
            $selectedHighlights = $(this).parent(".highlights-item");
            $(".main-data").addClass("point-selected");
            $(".synopsis").addClass("selectedsyn");
            $(".back-button").show();
            $(".highlights-item").removeClass("selected");
            $selectedHighlights.addClass("selected");
            $(".main-data.point-selected .synopsis .highlights-text").html($selectedHighlights.attr("data-description"));
            if ($selectedHighlights.attr("data-id") != "")
                $(".main-data.point-selected .learn-more").attr("href", "?id=" + $selectedHighlights.attr("data-id"));
            else
                $(".main-data.point-selected .learn-more").attr("href", 'javascript:$(".popup-oops").fadeIn();');
        }
    })

    $("body.home-page .highlights-item .high-img").click(function () {
        $selectedHighlights = $(this).parent(".highlights-item");
        window.location = "/?id=" + $selectedHighlights.attr("data-id");
    });

    $(".magnifying-glass").click(function () {
        searchChange();
    })

    $(".create-new").click(function () {
        $(".popup-oops").fadeIn();
        hideSidebar();
        $(".main-data").hide();
        $(".hand-line").hide();

    })

    $(".share-item").click(function () {
        // var v = window.location.toString(window.location.href)
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + window.location.href);
        //window.open('https://www.facebook.com/sharer/sharer.php?u=http://wikidots.com/?id=Albert_Einstein');

    })



    $(".back-button").click(function () {
        $(".synopsis").removeClass("selectedsyn");
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
            $(".popup-oops").fadeIn();
        hideSidebar();
        return false;
    }

    $(" .popup .x-popup").click(function () {
        $(".popup").hide();
    })

    setTimeout(function(){
        animate()
    },200);


})

function hideSidebar() {
    $("#sidebar").css("right", "-237px");
}

function showSidebar() {
    $(".popup").hide();
	if (!$('body').hasClass("home-page")){
		$(".main-data").hide();
		$(".hand-line").hide();
	}
    $("#sidebar").css("right", "0");
}


function showEdit(){
     $(".popup").hide()
    $(".popup-editor").fadeIn()
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

function hideVideo(){
    $(".youtube-iframe").hide(); 
    $('#youtubeIframe').attr('src','')
}

function animate(){
   
    
    
    setTimeout(function(){
         $(".main-background").fadeIn(1600);
    },100)
     setTimeout(function(){
          $(".value-name").fadeIn(1600);
    },100)
     setTimeout(function(){
         $('.desc-name').fadeIn();
    },500)
     setTimeout(function(){
         $(".timeline").fadeIn();
    },900)
     setTimeout(function(){
         $(".hand").fadeIn();
          $(".hand-line").fadeIn();
    },1200)
     setTimeout(function(){
         $(".main-data").fadeIn();
    },1200)

    setTimeout(function(){
         $(".date-point").fadeIn(500);
    },2000)
    
}
