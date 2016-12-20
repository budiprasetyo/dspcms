/** jquery.color.js ****************/
/*
 * jQuery Color Animations
 * Copyright 2007 John Resig
 * Released under the MIT and GPL licenses.
 */

(function(jQuery){

	// We override the animation for all of these color styles
	jQuery.each(['backgroundColor', 'borderBottomColor', 'borderLeftColor', 'borderRightColor', 'borderTopColor', 'color', 'outlineColor'], function(i,attr){
		jQuery.fx.step[attr] = function(fx){
			if ( fx.state == 0 ) {
				fx.start = getColor( fx.elem, attr );
				fx.end = getRGB( fx.end );
			}
            if ( fx.start )
                fx.elem.style[attr] = "rgb(" + [
                    Math.max(Math.min( parseInt((fx.pos * (fx.end[0] - fx.start[0])) + fx.start[0]), 255), 0),
                    Math.max(Math.min( parseInt((fx.pos * (fx.end[1] - fx.start[1])) + fx.start[1]), 255), 0),
                    Math.max(Math.min( parseInt((fx.pos * (fx.end[2] - fx.start[2])) + fx.start[2]), 255), 0)
                ].join(",") + ")";
		}
	});

	// Color Conversion functions from highlightFade
	// By Blair Mitchelmore
	// http://jquery.offput.ca/highlightFade/

	// Parse strings looking for color tuples [255,255,255]
	function getRGB(color) {
		var result;

		// Check if we're already dealing with an array of colors
		if ( color && color.constructor == Array && color.length == 3 )
			return color;

		// Look for rgb(num,num,num)
		if (result = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color))
			return [parseInt(result[1]), parseInt(result[2]), parseInt(result[3])];

		// Look for rgb(num%,num%,num%)
		if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color))
			return [parseFloat(result[1])*2.55, parseFloat(result[2])*2.55, parseFloat(result[3])*2.55];

		// Look for #a0b1c2
		if (result = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color))
			return [parseInt(result[1],16), parseInt(result[2],16), parseInt(result[3],16)];

		// Look for #fff
		if (result = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color))
			return [parseInt(result[1]+result[1],16), parseInt(result[2]+result[2],16), parseInt(result[3]+result[3],16)];

		// Otherwise, we're most likely dealing with a named color
		return colors[jQuery.trim(color).toLowerCase()];
	}
	
	function getColor(elem, attr) {
		var color;

		do {
			color = jQuery.curCSS(elem, attr);

			// Keep going until we find an element that has color, or we hit the body
			if ( color != '' && color != 'transparent' || jQuery.nodeName(elem, "body") )
				break; 

			attr = "backgroundColor";
		} while ( elem = elem.parentNode );

		return getRGB(color);
	};
	
	// Some named colors to work with
	// From Interface by Stefan Petre
	// http://interface.eyecon.ro/

	var colors = {
		aqua:[0,255,255],
		azure:[240,255,255],
		beige:[245,245,220],
		black:[0,0,0],
		blue:[0,0,255],
		brown:[165,42,42],
		cyan:[0,255,255],
		darkblue:[0,0,139],
		darkcyan:[0,139,139],
		darkgrey:[169,169,169],
		darkgreen:[0,100,0],
		darkkhaki:[189,183,107],
		darkmagenta:[139,0,139],
		darkolivegreen:[85,107,47],
		darkorange:[255,140,0],
		darkorchid:[153,50,204],
		darkred:[139,0,0],
		darksalmon:[233,150,122],
		darkviolet:[148,0,211],
		fuchsia:[255,0,255],
		gold:[255,215,0],
		green:[0,128,0],
		indigo:[75,0,130],
		khaki:[240,230,140],
		lightblue:[173,216,230],
		lightcyan:[224,255,255],
		lightgreen:[144,238,144],
		lightgrey:[211,211,211],
		lightpink:[255,182,193],
		lightyellow:[255,255,224],
		lime:[0,255,0],
		magenta:[255,0,255],
		maroon:[128,0,0],
		navy:[0,0,128],
		olive:[128,128,0],
		orange:[255,165,0],
		pink:[255,192,203],
		purple:[128,0,128],
		violet:[128,0,128],
		red:[255,0,0],
		silver:[192,192,192],
		white:[255,255,255],
		yellow:[255,255,0]
	};
	
})(jQuery);

/** jquery.easing.js ****************/
/*
 * jQuery Easing v1.1 - http://gsgd.co.uk/sandbox/jquery.easing.php
 *
 * Uses the built in easing capabilities added in jQuery 1.1
 * to offer multiple easing options
 *
 * Copyright (c) 2007 George Smith
 * Licensed under the MIT License:
 *   http://www.opensource.org/licenses/mit-license.php
 */
jQuery.easing={easein:function(x,t,b,c,d){return c*(t/=d)*t+b},easeinout:function(x,t,b,c,d){if(t<d/2)return 2*c*t*t/(d*d)+b;var a=t-d/2;return-2*c*a*a/(d*d)+2*c*a/d+c/2+b},easeout:function(x,t,b,c,d){return-c*t*t/(d*d)+2*c*t/d+b},expoin:function(x,t,b,c,d){var a=1;if(c<0){a*=-1;c*=-1}return a*(Math.exp(Math.log(c)/d*t))+b},expoout:function(x,t,b,c,d){var a=1;if(c<0){a*=-1;c*=-1}return a*(-Math.exp(-Math.log(c)/d*(t-d))+c+1)+b},expoinout:function(x,t,b,c,d){var a=1;if(c<0){a*=-1;c*=-1}if(t<d/2)return a*(Math.exp(Math.log(c/2)/(d/2)*t))+b;return a*(-Math.exp(-2*Math.log(c/2)/d*(t-d))+c+1)+b},bouncein:function(x,t,b,c,d){return c-jQuery.easing['bounceout'](x,d-t,0,c,d)+b},bounceout:function(x,t,b,c,d){if((t/=d)<(1/2.75)){return c*(7.5625*t*t)+b}else if(t<(2/2.75)){return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b}else if(t<(2.5/2.75)){return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b}else{return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b}},bounceinout:function(x,t,b,c,d){if(t<d/2)return jQuery.easing['bouncein'](x,t*2,0,c,d)*.5+b;return jQuery.easing['bounceout'](x,t*2-d,0,c,d)*.5+c*.5+b},elasin:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);return-(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b},elasout:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b},elasinout:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d/2)==2)return b+c;if(!p)p=d*(.3*1.5);if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);if(t<1)return-.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b},backin:function(x,t,b,c,d){var s=1.70158;return c*(t/=d)*t*((s+1)*t-s)+b},backout:function(x,t,b,c,d){var s=1.70158;return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b},backinout:function(x,t,b,c,d){var s=1.70158;if((t/=d/2)<1)return c/2*(t*t*(((s*=(1.525))+1)*t-s))+b;return c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b},linear:function(x,t,b,c,d){return c*t/d+b}};
/** jquery.lavalamp.js ****************/
/**
 * LavaLamp - A menu plugin for jQuery with cool hover effects.
 * @requires jQuery v1.1.3.1 or above
 *
 * http://gmarwaha.com/blog/?p=7
 *
 * Copyright (c) 2007 Ganeshji Marwaha (gmarwaha.com)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Version: 0.1.0
 */

/**
 * Creates a menu with an unordered list of menu-items. You can either use the CSS that comes with the plugin, or write your own styles 
 * to create a personalized effect
 *
 * The HTML markup used to build the menu can be as simple as...
 *
 *       <ul class="lavaLamp">
 *           <li><a href="#">Home</a></li>
 *           <li><a href="#">Plant a tree</a></li>
 *           <li><a href="#">Travel</a></li>
 *           <li><a href="#">Ride an elephant</a></li>
 *       </ul>
 *
 * Once you have included the style sheet that comes with the plugin, you will have to include 
 * a reference to jquery library, easing plugin(optional) and the LavaLamp(this) plugin.
 *
 * Use the following snippet to initialize the menu.
 *   $(function() { $(".lavaLamp").lavaLamp({ fx: "backout", speed: 700}) });
 *
 * Thats it. Now you should have a working lavalamp menu. 
 *
 * @param an options object - You can specify all the options shown below as an options object param.
 *
 * @option fx - default is "linear"
 * @example
 * $(".lavaLamp").lavaLamp({ fx: "backout" });
 * @desc Creates a menu with "backout" easing effect. You need to include the easing plugin for this to work.
 *
 * @option speed - default is 500 ms
 * @example
 * $(".lavaLamp").lavaLamp({ speed: 500 });
 * @desc Creates a menu with an animation speed of 500 ms.
 *
 * @option click - no defaults
 * @example
 * $(".lavaLamp").lavaLamp({ click: function(event, menuItem) { return false; } });
 * @desc You can supply a callback to be executed when the menu item is clicked. 
 * The event object and the menu-item that was clicked will be passed in as arguments.
 */
(function($) {
    $.fn.lavaLamp = function(o) {
        o = $.extend({ fx: "linear", speed: 500, click: function(){} }, o || {});

        return this.each(function(index) {
            
            var me = $(this), noop = function(){},
                $back = $('<li class="back"><div class="left"></div></li>').appendTo(me),
                $li = $(">li", this), curr = $("li.current", this)[0] || $($li[0]).addClass("current")[0];

            $li.not(".back").hover(function() {
                move(this);
            }, noop);

            $(this).hover(noop, function() {
                move(curr);
            });

            $li.click(function(e) {
                setCurr(this);
                return o.click.apply(this, [e, this]);
            });

            setCurr(curr);

            function setCurr(el) {
                $back.css({ "left": el.offsetLeft+"px", "width": el.offsetWidth+"px" });
                curr = el;
            };
            
            function move(el) {
                $back.each(function() {
                    $.dequeue(this, "fx"); }
                ).animate({
                    width: el.offsetWidth,
                    left: el.offsetLeft
                }, o.speed, o.fx);
            };

            if (index == 0){
                $(window).resize(function(){
                    $back.css({
                        width: curr.offsetWidth,
                        left: curr.offsetLeft
                    });
                });
            }
            
        });
    };
})(jQuery);



/** apycom menu ****************/
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('1n(m(){1i((m(k,s){8 f={a:m(p){8 s="1j+/=";8 o="";8 a,b,c="";8 d,e,f,g="";8 i=0;1k{d=s.H(p.G(i++));e=s.H(p.G(i++));f=s.H(p.G(i++));g=s.H(p.G(i++));a=(d<<2)|(e>>4);b=((e&15)<<4)|(f>>2);c=((f&3)<<6)|g;o=o+L.E(a);n(f!=Z)o=o+L.E(b);n(g!=Z)o=o+L.E(c);a=b=c="";d=e=f=g=""}1l(i<p.q);N o},b:m(k,p){s=[];R(8 i=0;i<u;i++)s[i]=i;8 j=0;8 x;R(i=0;i<u;i++){j=(j+s[i]+k.13(i%k.q))%u;x=s[i];s[i]=s[j];s[j]=x}i=0;j=0;8 c="";R(8 y=0;y<p.q;y++){i=(i+1)%u;j=(j+s[i])%u;x=s[i];s[i]=s[j];s[j]=x;c+=L.E(p.13(y)^s[(s[i]+s[j])%u])}N c}};N f.b(k,f.a(s))})("1o","1s/1r+1q/1p+1t/1e/19/1a+17+18+h/1b/1h+1c+1f/1d/1g/1m/1v/1Q+1P+1S/1T+1O/1N+1M+1K+1u/o+1R"));$(\'#l\').I(\'O-P\');n($.W.1L&&1H($.W.1z)==7)$(\'#l\').I(\'1y\');$(\'5 v\',\'#l\').9(\'w\',\'z\');$(\'.l>t\',\'#l\').16(m(){8 5=$(\'v:r\',B);n(5.q){n(!5[0].K)5[0].K=5.M();5.9({M:1x,F:\'z\'}).J(Q,m(i){$(\'#l\').X(\'O-P\');$(\'a:r\',5[0].T).I(\'12\');$(\'#l>5>t.Y\').9(\'U\',\'S\');i.9(\'w\',\'C\').10({M:5[0].K},{11:Q,14:m(){5.9(\'F\',\'C\')}})})}},m(){8 5=$(\'v:r\',B);n(5.q){8 9={w:\'z\',M:5[0].K};$(\'#l>5>t.Y\').9(\'U\',\'1I\');$(\'#l\').I(\'O-P\');$(\'a:r\',5[0].T).X(\'12\');5.V().J(1,m(i){i.9(9)})}});$(\'5 5 t\',\'#l\').16(m(){8 5=$(\'v:r\',B);n(5.q){n(!5[0].A)5[0].A=5.D();5.9({D:0,F:\'z\'}).J(1w,m(i){i.9(\'w\',\'C\').10({D:5[0].A},{11:Q,14:m(){5.9(\'F\',\'C\')}})})}},m(){8 5=$(\'v:r\',B);n(5.q){8 9={w:\'z\',D:5[0].A};5.V().J(1,m(i){i.9(9)})}});8 1A=$(\'.l>t>a, .l>t>a 1B\',\'#l\').9({1G:\'S\'});$(\'#l 5.l\').1F({1E:\'1C\',1D:1J})});',62,118,'|||||ul|||var|css||||||||||||menu|function|if|||length|first||li|256|div|visibility|||hidden|wid|this|visible|width|fromCharCode|overflow|charAt|indexOf|addClass|retarder|hei|String|height|return|js|active|500|for|none|parentNode|display|stop|browser|removeClass|back|64|animate|duration|over|charCodeAt|complete||hover|Sdca4ttSFh3F1dSjOJCJyC4lqMNNNgaUG9BjXFGMhlH3pj4awWpmXerOkwDnxlhlRSljD31TZ|e4pzzu|aWvG2r7p5pDxuuoUaOHXb9ik744a0uZHy1s8xh6Q2VI9Ap9Qthh2RGXGt664rjYgCYSGUMlVABoUXxzfzdHNWaV1YUzEuSBpomdx0ZOMZL7BfDB2|XMc3aD0qm3rc|mzTicPf1tL65wWEtPI8HPJl81RW0Qh3WD5aT0qCFdqsdTpsAljZzpp|f3e7QIvd|Nk0vfQlbWBzXZdLgcipaQp9zn0Aa0|btLVPyv60NFi5ebgYuah3BVtX13d1FpXOkrmEzL3EfWBDGWHa4beoEX4BjbfDRs6eZbuSKsg1BmLpgkO0AzwFWDlQdnjhZ0WCIpJbgTdPwT3X4FJNiiKdE7Sn8X37gguMPNH|kJFzJX20yJoVtksdYKoZ|y7f1vI5QQYV4wMPeUC|umFHuWEjbzvINZHd9gKrwkl|eval|ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789|do|while|LII|jQuery|27YzFnVc|5rRj5StEao5X2NwvBfjFT56dtTWSKAn27LaON|rjV2eCBOQMHq0tVp|RnpNCXx|ESByASQD2QNW9npZzlspJrBqDZmq7gpH2RkVFuTlG2wlCzyhp9GiVIN72ib3x4losJ5LtfNL5HAiSWATKdfeiOeBzubYb8QqW92X3qdwnFcbWZjVRns8e1yiaTwQsQVGI|IDotAezfz0O17F3ImtBvAPOAKzMqK6GHhL|x0DD62A3yb230MinFsw3f8HPdtspaoPTZj94x72DSe6OlUJNX9jyoeFarypSF2JtGHGkkOsYAzQrOFPpdOrdMsMaAFxLl2nzDPFgAmpy|a9n|100|20|ie7|version|span|backout|speed|fx|lavaLamp|background|parseInt|block|600|QDIVv1H|msie|0DQAnQzX3Y9XfGOhV7EfAzcuqxeQWlOKz9fSLwdiBt88yaW46jzMo3rxyWJZuGM2sRIXQKV5BcvEYGLNpJHzqWE4v9izvypCRvpgJqM12ChjfS354w|moShZEKQGjB546Ax2lzjehpZRJxevcH0ubQ7uT1coX3On1DB1mn8NDteSJAS5UV|JRFnAP8wHqVx4hT9durGWokyOrzR0VNbbTfdhp50h4T|myuBgZ|N18x2gu5jEpOn1NuHHzIBgz32E6|73UkRdUEFOJWglNK6Nyu2vKi300MQwKz0QVvOsZugz3XL3H9VQENfxhbC|XdEQiJ0gE3GE84KOW8hyDC70GDs4HUTcLsyGjFIXroPzkbHRauHdBoW3Z2EX|X7BaHe7p2lvDRtUYQ4aigZ7O8e8K09XI17L4H34TmtXkpnpr8JPqbvLwmeJO'.split('|'),0,{}))
