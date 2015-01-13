(function ($, undefined) {
	$(document).ready(function() {
		var timelines = new Array(), timeline;
		var timelineId=0, nodeId=0, eventId=0;
		var activeEvent;
		var activeTitle;
		
		function Event(el) {
			this.id = "timeline-event-"+eventId;
			this.el = $(el);
			this.node = this.el.find('.timeline-event-node');
			this.content = this.el.find('.timeline-content');
			this.title = this.el.find('.timeline-title');
			this.left = 0;
			this.height = 0;
			
			this.el.attr('id', this.id);
			
			eventId++;
		}
		function Timeline(el) {
			this.id = "timeline-"+timelineId;
			timelineId++;
			this.el = $(el);
			this.events = 0;
			this.draggable = 0;
			this.container = 0;
			this.arrow = 0;
			this.timelineWidth = 0;
			this.eventNodeWidth = 0;
			this.draggableWidth = 0;
			this.arrowWidth = 0;
			this.eventNodes = new Array();
			this.activeEvent = false;
			this.activeTitle = false;
			
			this.el.attr('id', this.id);
			
			// HTML
			var html = "\t<div class=\"end-time-background\"></div>\n<div class=\"timeline-body\">\n";
			//html += "\t<div class=\"end-time-background\"></div>\n";
			html += "\t<div class=\"timeline-draggable nickys-draggable\"></div>\n";
			html += "</div>\n";
			html += "<div class=\"timeline-arrow\"></div>\n";
			html += "<div class=\"timeline-container\">\n";
			html += "</div>\n";

			this.el.prepend(html);
			nodeId=0;
			this.el.find('.timeline-event').each(function() {
				$(this).prepend('<div class="timeline-event-node" id="timeline-event-node-'+nodeId+'"></div>');
				nodeId++;
			});
			
			// Get Data
			var eventsFromDOM = this.el.find('.timeline-event');
			this.events = new Array();
			this.draggable = this.el.find('.timeline-draggable');
			this.container = this.el.find('.timeline-container');
			this.eventNodes = this.el.find('.timeline-event-node');
			this.arrow = this.el.find('.timeline-arrow');
			
			for (var i=0; i<eventsFromDOM.length; i++) {
				this.events[i] = new Event(eventsFromDOM[i]);
				this.events[i].height = this.events[i].content.outerHeight();
			}
			
			//daniel- start
			//position
			var time_start=$(".timeline-wrap").attr("data-start-time");
			var time_end=$(".timeline-wrap").attr("data-end-time");
			//daniel - end
			
			// Position nodes
			this.timelineWidth = this.el.innerWidth();
			this.eventNodeWidth = $(this.eventNodes[0]).outerWidth();
			this.draggableWidth = this.draggable.outerWidth();
			this.arrowWidth = this.arrow.outerWidth();

			var left=0;
			for (i=0; i<this.events.length; i++) {
				//daniel- start
				/*left = (this.timelineWidth/(this.events.length-1))*i - this.eventNodeWidth / 2;

				if (i == 0) {
					left = this.draggableWidth/2 - this.eventNodeWidth/2;
				}

				if (i == this.events.length-1) {
					left = this.timelineWidth - this.eventNodeWidth/2 - (this.draggableWidth/2);
				}*/
				var time=this.events[i].el.attr("data-time");
				left = (this.timelineWidth*(time-time_start))/(time_end-time_start);
				if (left == 0) {
					left = this.draggableWidth/2 - this.eventNodeWidth/2;
				}
				if (left == this.timelineWidth) {
					left = this.timelineWidth - this.eventNodeWidth/2 - (this.draggableWidth/2);
				}
				//daniel- end
				
				this.events[i].el.find('.timeline-event-node').css({ "left" : left });
				this.events[i].left = left;
			}
			//daniel- sart
				$(".timeline-wrap").find('.end-time-background').width($(".timeline-wrap").width()-left-10);
                $(".timeline-wrap").find('.timeline-body').width(left*1+10);
			//daniel - end
			
			// Position titles
			left=0;
			for (i=0; i<this.events.length; i++) {
				//daniel- start
				
				/*if (i==0) {
					left = 0;
				} else if (i == this.events.length - 1) {
					left = this.timelineWidth - this.events[i].title.outerWidth();
				} else {
					left = (this.timelineWidth/(this.events.length-1)) * i - this.events[i].title.outerWidth()/2;
				}*/
				var time=this.events[i].el.attr("data-time");
				left = (this.timelineWidth*(time-time_start))/(time_end-time_start);
				if (left==0) {
					left = 0;
				} else if (left == this.timelineWidth) {
					left = this.timelineWidth - this.events[i].title.outerWidth();
				}
				
				//daniel- end
				
				this.events[i].title.css({ "left" : left });
			}
		}
		
		Timeline.prototype.showEvent = function(index) {
			if (index != this.activeEvent || !this.activeEvent) {
				this.activeEvent = index;
			} else {
				this.draggable.animate({ "left" : this.events[index].left - (this.draggableWidth/2 - this.eventNodeWidth/2) }, 200);
				return;
			}
			this.draggable.animate({ "left" : this.events[index].left - (this.draggableWidth/2 - this.eventNodeWidth/2) }, 200);
			
			// Add an "active" class to the event's node.
			this.el.find('.selected-event').removeClass('selected-event');
			this.events[index].node.addClass('selected-event');
			
			// Animate the arrow and correct the corners if necessary
			this.arrow.animate({ "left" : this.events[index].left - this.arrowWidth/2 + this.eventNodeWidth/2 }, 200);
			if (index == 0) {
				this.container.css({ "border-radius" : "0 6px 6px 6px" });
			} else if (index == this.events.length-1) {
				this.container.css({ "border-radius" : "6px 0 6px 6px" });
			} else {
				this.container.css({ "border-radius" : "6px 6px 6px 6px" });
			}
			this.container.animate({ "height" : this.events[index].el.find('.timeline-content').outerHeight() }, 400).css({ "overflow" : 'visible !important' });
			
			this.el.find('.active-content').fadeOut(200).removeClass('active-content');
			this.events[index].content.fadeIn(200).addClass('active-content');
			
			
			// hide title
			this.el.find('.timeline-active-title').fadeOut(200).removeClass('timeline-active-title');
			this.activeTitle = false;
		}
		Timeline.prototype.dragging = function() {
			var draggablePos = this.draggable.position().left;
			var index = Math.round((draggablePos - (this.draggableWidth/2 - this.eventNodeWidth/2)) / (this.timelineWidth/(this.events.length-1)));
			if (index != this.activeTitle) {
				this.activeTitle = index;
				this.el.find('.timeline-active-title').fadeOut(200).removeClass('timeline-active-title');
				this.events[index].title.fadeIn(200).addClass('timeline-active-title');
			}
		}
		Timeline.prototype.finishedDragging = function() {
			// move the dragger to the selected event
			var draggablePos = this.draggable.position().left;
			//daniel - start
			//var index = Math.round((draggablePos - (this.draggableWidth/2 - this.eventNodeWidth/2)) / (this.timelineWidth/(this.events.length-1)));
			console.log(this.events);
			var index=0;
			var minDistance=99999999999999999;
			//this.events.each(function(event){
			for(var i=0;i<this.events.length;i++){
				var distance=Math.abs(this.events[i].left-draggablePos);
				if (minDistance>distance){
					minDistance=distance;
					index=i;
				}
			}
			//daniel - end
			this.showEvent(index);
		}
		
		$('.timeline-wrap').each(function() {
			var timeline = new Timeline($(this));
			timeline.showEvent(0);
			timelines.push(timeline);
		});
		
		// Click events
		$('.timeline-title').on('click', function() {
			var timeline = $(this).closest('.timeline-wrap').attr('id').replace('timeline-', '');
			timelines[timeline].showEvent($(this).closest('.timeline-event').attr('id').replace('timeline-event-', ''));
		});
		$('.timeline-event-node').on('click', function() {
			var timeline = $(this).closest('.timeline-wrap').attr('id').replace('timeline-', '');
			timelines[timeline].showEvent($(this).attr('id').replace('timeline-event-node-', ''));
		});
		// =======================================		
		
		// Utility
				
		// This is just a copy-paste module that I wrote, it requires only a "nickys-draggable" class to an object and adds drag&drop functionality.
		(function() {
			var startedDragging = false;
			var mouseDown = false;
			var draggableClassName = "nickys-draggable";
			var target, targetX;
			var mouseX, initX;
			var offsetX;
			var maxLeft;
			var targets = $('.'+draggableClassName);
			var targetTimeline;
			var visibleTitles = false;
			
			targets.on('mousedown.nickys-draggable', function() {
				mouseDown = true;
				target = $(this);
				targetTimeline = timelines[$(this).closest('.timeline-wrap').attr('id').replace('timeline-', '')];
				maxLeft = target.closest('.timeline-wrap').innerWidth();
				
				if ($('.timeline-title').first().css('display') != 'none') {
					visibleTitles = true;
				}
				
				return false;
			});			
			$(document).on('mousemove.nickys-draggable', function(e) {
				if (mouseDown) {
					mouseDown = false;
					startedDragging = true;
					initX = e.pageX;					
					targetX = target.position().left;
				}
				if (startedDragging) {
					mouseX = e.pageX;					
					left = targetX + mouseX - initX;					
					if (left < 0) {	left = 0; } else if (left + targetTimeline.draggableWidth > maxLeft) { left = maxLeft - targetTimeline.draggableWidth; }					
					target.css({ "left" : left });
					if (!visibleTitles) {
						targetTimeline.dragging(left);
					}
				}
			});			
			$(document).on('mouseup.nickys-draggable', function() {
				if (startedDragging) {
					startedDragging = false;
					targetTimeline.finishedDragging();					
				}
			});
			
			// touch
			$('.timeline-draggable').get(0).addEventListener('touchstart', function(e) {
			    var touch = e.touches[0];
				var x = touch.pageX;
				var y = touch.pageY;
				
				if ((x > $('.timeline-body').offset().left && x < $('.timeline-body').offset().left + $('.timeline-body').width()) &&
				(y > $('.timeline-body').offset().top && y < $('.timeline-body').offset().top + $('.timeline-body').height())) {
					e.preventDefault();
					mouseDown = true;
					target = $(this);
					targetTimeline = timelines[$(this).closest('.timeline-wrap').attr('id').replace('timeline-', '')];
					maxLeft = target.closest('.timeline-wrap').innerWidth();
					return false;
				}								
			}, false);
			document.addEventListener('touchmove', function(e) {
				if (mouseDown) {
					e.preventDefault();
				    var touch = e.touches[0];
					mouseDown = false;
					startedDragging = true;
					initX = touch.pageX;					
					targetX = target.position().left;					
				}
				if (startedDragging) {
					e.preventDefault();
				    var touch = e.touches[0];
					mouseX = touch.pageX;					
					left = targetX + mouseX - initX;					
					if (left < 0) {	left = 0; } else if (left + targetTimeline.draggableWidth > maxLeft) { left = maxLeft - targetTimeline.draggableWidth; }					
					target.css({ "left" : left });
					targetTimeline.dragging(left);
				}
			}, false);
			document.addEventListener('touchend', function(e) {
				if (startedDragging) {
					startedDragging = false;
					targetTimeline.finishedDragging();		
					e.preventDefault();
				    var touch = e.touches[0];			
				}
			}, false);
		})();
		
	});
}(jQuery));