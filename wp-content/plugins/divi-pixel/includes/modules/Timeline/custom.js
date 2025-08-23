
export default {
    init : function(){
        window.addEventListener( "load", () => {
            this.updateTimeline()
            window.onresize = this.updateTimeline
          })
    },
    updateTimeline: function() {
        let last_known_scroll_position = 0;
        let ticking = false;
        let half_scr_h = window.screen.height / 2;
        let tl_el = window.document.getElementsByClassName("dipi_timeline")
        let tl_el_len = tl_el.length
        let tl_el_objs = new Array(tl_el_len)
      
        let tl_ribbon_icons = window.document.getElementsByClassName("ribbon-icon")
        let tl_ribbon_icons_len = tl_ribbon_icons.length
        let tl_ribbon_icons_objs = new Array(tl_ribbon_icons_len)
        
        function getCoords(elem) { // crossbrowser version
          var box = elem.getBoundingClientRect();
      
          var body = window.document.body;
          var docEl = window.document.documentElement;
      
          var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
          var scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;
      
          var clientTop = docEl.clientTop || body.clientTop || 0;
          var clientLeft = docEl.clientLeft || body.clientLeft || 0;
      
          var top  = box.top +  scrollTop - clientTop;
          var left = box.left + scrollLeft - clientLeft;
      
          return { top: Math.round(top), left: Math.round(left) };
        }
        var i
        for (i = 0; i < tl_el_len; i++) {
          tl_el_objs[i] = {}
          tl_el_objs[i].line = tl_el[i].getElementsByClassName("dipi-timeline-line")
          tl_el_objs[i].actline = tl_el[i].getElementsByClassName("dipi-timeline-line__active")
          tl_el_objs[i].items = tl_el[i].getElementsByClassName("dipi-timeline-items")[0]
          tl_el_objs[i].first_item = tl_el_objs[i].items.firstChild
          tl_el_objs[i].last_item = tl_el_objs[i].items.lastChild
          tl_el_objs[i].innertop = tl_el_objs[i].first_item ? tl_el_objs[i].first_item.offsetHeight / 2 : 0
          tl_el_objs[i].innerbottom = tl_el_objs[i].first_item ?  tl_el_objs[i].last_item.offsetHeight / 2 : 0
          tl_el_objs[i].el = tl_el[i]
          tl_el_objs[i].style = getComputedStyle(tl_el[i])
          tl_el_objs[i].coords = getCoords(tl_el[i])
          tl_el_objs[i].elemRect = tl_el[i].getBoundingClientRect()
          tl_el_objs[i].height = tl_el_objs[i].elemRect.height 
          // tl_el_objs[i].top = tl_el_objs[i].el.offsetTop
          tl_el_objs[i].start = tl_el_objs[i].coords.top > half_scr_h ? tl_el_objs[i].coords.top - half_scr_h: 0
          tl_el_objs[i].end = tl_el_objs[i].coords.top + tl_el_objs[i].height - tl_el_objs[i].innerbottom > half_scr_h ? tl_el_objs[i].coords.top + tl_el_objs[i].height - half_scr_h - tl_el_objs[i].innerbottom: 0
          tl_el_objs[i].line[0].style.top = tl_el_objs[i].innertop + 'px'
          tl_el_objs[i].line[0].style.bottom = tl_el_objs[i].innerbottom + 'px'
          if (tl_el_objs[i].actline.length) {
            tl_el_objs[i].actline[0].style.top = tl_el_objs[i].innertop + 'px'
          }
         }
      
         for (i = 0; i < tl_ribbon_icons_len; i++) {
          tl_ribbon_icons_objs[i] = {}
          tl_ribbon_icons_objs[i].el = tl_ribbon_icons[i]
          tl_ribbon_icons_objs[i].coords = getCoords(tl_ribbon_icons[i])
          tl_ribbon_icons_objs[i].elemRect = tl_ribbon_icons[i].getBoundingClientRect()
          tl_ribbon_icons_objs[i].height = tl_ribbon_icons_objs[i].elemRect.height 
          // tl_el_objs[i].top = tl_el_objs[i].el.offsetTop
          tl_ribbon_icons_objs[i].start = tl_ribbon_icons_objs[i].coords.top > half_scr_h ? tl_ribbon_icons_objs[i].coords.top - half_scr_h: 0
      
         }
        
        function showAnimationLine(scroll_pos) {
          // Do something with the scroll position
          for (var i = 0; i < tl_el_len; i++) {
            if ( !tl_el_objs[i].actline.length) {
              continue;
            }
      
            if (scroll_pos < tl_el_objs[i].start) {
              tl_el_objs[i].actline[0].style.bottom = tl_el_objs[i].height
            } else if (scroll_pos >= tl_el_objs[i].end ) {
              tl_el_objs[i].actline[0].style.bottom = tl_el_objs[i].innerbottom + 'px'
            } else {
                tl_el_objs[i].actline[0].style.bottom = (tl_el_objs[i].end - scroll_pos + tl_el_objs[i].innerbottom) + 'px'
       
            }
          }
          
        }
        /* Show hover timeline circle, border, font while scrolling */
        function showActiveTimelineIcon(scroll_pos) {
          for (var i = 0; i < tl_ribbon_icons_len; i++) {
            if (scroll_pos < tl_ribbon_icons_objs[i].start) {
              tl_ribbon_icons[i].classList.remove("active")
            } else {
              tl_ribbon_icons[i].classList.add("active")
            }
          }
        }
      
        window.document.addEventListener('scroll', function(e) {
          last_known_scroll_position = window.scrollY;
          if (!ticking) {
            window.requestAnimationFrame(function() {
              showAnimationLine(last_known_scroll_position);
              showActiveTimelineIcon(last_known_scroll_position);
              ticking = false;
            });
        
            ticking = true;
          }
        });
    }
}