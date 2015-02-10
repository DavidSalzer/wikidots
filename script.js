$(function () {

    //timeline close events text
     $('body').mousedown(function(a){
        cls = $(a.target).attr('class');
        if (cls == 'timeline-draggable nickys-draggable' || cls == 'timeline-event-node' || cls == 'timeline-content active-content' || cls == 'timeline-body')
        {
            return;   
        }
        $('.active-content').hide();
    });
    $('.active-content').removeClass('active-content').hide();
    

    //check if to show loader
    //if there is no localstorage data - show it
    if(localStorage.getItem('toHideLoader') == undefined || localStorage.getItem('toHideLoader') == null||localStorage.getItem('toHideLoader') == ''){
       //if true- show the loader, animate the bar, and animate the value page data
       showLoaderPage();
    }
    else{
        //if there is localstorage data -check the time
        if( Date.now() - parseInt(localStorage.getItem('toHideLoader')) > 1800000){
            showLoaderPage();
        }
        else{
             //if not - animate the value page data
         setTimeout(function(){
            animate()
        },200);
        }
       
    }
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
         var id =getParameterByName('id');
        _gaq.push(['_trackEvent', 'play click', id, ' ']);

        $(".youtube-iframe").fadeIn();
        var url = $(".play").attr("vidio-url");
        var v = url.split('v=')[1];
        $("#youtubeIframe").attr("src", "//www.youtube.com/embed/" + v);
        //www.youtube.com/embed/PBN0nqQX5xo
    });

    $('body').on('click','.learn-more-button',function(){
        var id =$(this).parent(".synopsis").attr("data-id");
   
       _gaq.push(['_trackEvent', 'learn more', id, ' ']);
    })
    $('body').on('click','.wikipedia_button',function(){
        var id =getParameterByName('id');
   
        _gaq.push(['_trackEvent', 'wikipedia button click',id, ' ']);
    })  
    $selectedHighlights = null;
    $("body.value-page .highlights-item .high-img").click(function () {
        $(".popup-learn-more").fadeIn()
        $(".main-background img").addClass('grow')

            var id =$(this).parent(".highlights-item").attr('data-id');
            _gaq.push(['_trackEvent', 'Thumbs clicks - value page', id, ' ']);
            $selectedHighlights = $(this).parent(".highlights-item");
             $(".learn-more-text").html($selectedHighlights.attr("data-description"));
            $(".learn-more-text").attr('data-id',$selectedHighlights.attr("data-id"));
			$(".learn-more-title").html($selectedHighlights.attr("data-name"));
            $(".learn-more-thumb").css("background-image","url('"+$selectedHighlights.attr("data-image")+"')")
            if ($selectedHighlights.attr("data-id") != ""){
                $(".learn-more-button").attr("href", "?id=" + $selectedHighlights.attr("data-id")); 
                 $(".learn-more-thumb a").attr("href", "?id=" + $selectedHighlights.attr("data-id")); 
            }
               
            else{
                $(".learn-more-button").attr("href", 'javascript:$(".popup-learn-more").fadeOut(); $(".popup-oops").fadeIn();');
                $(".learn-more-thumb a").attr("href", 'javascript:$(".popup-learn-more").fadeOut();$(".popup-oops").fadeIn();');
            }
                
       // }
    })

    $("body.home-page .highlights-item .high-img").click(function () {
        $selectedHighlights = $(this).parent(".highlights-item");
        var id =$selectedHighlights.attr("data-id");
        _gaq.push(['_trackEvent', 'Thumbs clicks - homepage', id, ' ']);
        window.location = "index.php?id=" + $selectedHighlights.attr("data-id");
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
         var id =getParameterByName('id');
        _gaq.push(['_trackEvent', 'share', id, ' ']);
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + window.location.href);
        //window.open('https://www.facebook.com/sharer/sharer.php?u=http://wikidots.com/?id=Albert_Einstein');

    })



    //$(".back-button").click(function () {
    //    $(".synopsis").removeClass("selectedsyn");
    //    $(".highlights-item").removeClass("selected");
    //    $selectedHighlights = null;
    //    $(".main-data").removeClass("point-selected");
    //    $(".back-button").hide();
    //})

    $(".search").autocomplete({
        source: valuesName,
        close: searchChange
    });

    $(".search-form").submit(searchChange);

    function searchChange() {
        var valueName = $(".search").val();
        var valueID = null;
        values.forEach(function (element) {
            if (valueName == element.title)
                valueID = element.id;
        });
        if (valueID != null)
            window.location = "/?id=" + valueID;
        else
            $(".popup-oops").fadeIn();
        hideSidebar();
        return false;
    }

    $(" .popup .x-popup").click(function () {
        $(".popup").fadeOut();
    })

   
	
   $(".popup-feedback").click(function(e){
       if($(e.target).hasClass('popup-feedback')){
           $(".popup-feedback").fadeOut()
       }
       
   });
   $(".popup-learn-more").click(function(e){
       if($(e.target).hasClass('popup-learn-more') || $(e.target).hasClass('learn-more-wrapper')){
          $(".main-background img").removeClass("grow");
           $(".popup-learn-more").fadeOut();
           
       }
       
   });
   $(".popup-learn-more .x-popup").click(function(e){
           $(".main-background img").removeClass("grow");
           $(".popup-learn-more").fadeOut();
   });
	$('#send-email').submit(function(){
		$.ajax({
			type: "POST",
			url: "getEmail.php",
			data: {
				type:$(this).attr("data-type"),
				email:$(this).find("input[name=email]").val(),
				feedback:$(this).find("textarea[name=feedback]").val(),	
			},
			success: function(){
				alert("message send");
			},
		});
		return false;
	})


})

 function showFeedbackPopup(e){
        $(".popup-feedback").fadeIn();
    }

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
    var id =getParameterByName('id');
    _gaq.push(['_trackEvent', 'edit', id, ' ']);
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

//get querystring params
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function showLoaderPage(){
     $('.loader-wrap').fadeIn();
      $('.loader-progressbar').css('width','100%');
      //set the localstorage data
      localStorage.setItem('toHideLoader',Date.now());
        setTimeout(function(){
           $('.loader-wrap').fadeOut();
              setTimeout(function(){
                animate()
                  },200);
        },1700);
}