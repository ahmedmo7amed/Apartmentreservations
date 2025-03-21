/*================================
	Easy Pie
=================================*/
/**!
 * easy-pie-chart
 * Lightweight plugin to render simple, animated and retina optimized pie charts
 *
 * @license
 * @author Robert Fleischmann <rendro87@gmail.com> (http://robert-fleischmann.de)
 * @version 2.1.7
 **/

 !function(a,b){"function"==typeof define&&define.amd?define(["@/Components/Flats/assets/js/vendor/jquery.js"],function(a){return b(a)}):"object"==typeof exports?module.exports=b(require("@/Components/Flats/assets/js/vendor/jquery.js")):b(jQuery)}(this,function(a){var b=function(a, b){var c,d=document.createElement("canvas");a.appendChild(d),"object"==typeof G_vmlCanvasManager&&G_vmlCanvasManager.initElement(d);var e=d.getContext("2d");d.width=d.height=b.size;var f=1;window.devicePixelRatio>1&&(f=window.devicePixelRatio,d.style.width=d.style.height=[b.size,"px"].join(""),d.width=d.height=b.size*f,e.scale(f,f)),e.translate(b.size/2,b.size/2),e.rotate((-0.5+b.rotate/180)*Math.PI);var g=(b.size-b.lineWidth)/2;b.scaleColor&&b.scaleLength&&(g-=b.scaleLength+2),Date.now=Date.now||function(){return+new Date};var h=function(a, b, c){c=Math.min(Math.max(-1,c||0),1);var d=0>=c?!0:!1;e.beginPath(),e.arc(0,0,g,0,2*Math.PI*c,d),e.strokeStyle=a,e.lineWidth=b,e.stroke()},i=function(){var a,c;e.lineWidth=1,e.fillStyle=b.scaleColor,e.save();for(var d=24; d>0; --d)d%6===0?(c=b.scaleLength,a=0):(c=.6*b.scaleLength,a=b.scaleLength-c),e.fillRect(-b.size/2+a,0,c,1),e.rotate(Math.PI/12);e.restore()},j=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||function(a){window.setTimeout(a,1e3/60)}}(),k=function(){b.scaleColor&&i(),b.trackColor&&h(b.trackColor,b.trackWidth||b.lineWidth,1)};this.getCanvas=function(){return d},this.getCtx=function(){return e},this.clear=function(){e.clearRect(b.size/-2,b.size/-2,b.size,b.size)},this.draw=function(a){b.scaleColor||b.trackColor?e.getImageData&&e.putImageData?c?e.putImageData(c,0,0):(k(),c=e.getImageData(0,0,b.size*f,b.size*f)):(this.clear(),k()):this.clear(),e.lineCap=b.lineCap;var d;d="function"==typeof b.barColor?b.barColor(a):b.barColor,h(d,b.lineWidth,a/100)}.bind(this),this.animate=function(a, c){var d=Date.now();b.onStart(a,c);var e=function(){var f=Math.min(Date.now()-d,b.animate.duration),g=b.easing(this,f,a,c-a,b.animate.duration);this.draw(g),b.onStep(a,c,g),f>=b.animate.duration?b.onStop(a,c):j(e)}.bind(this);j(e)}.bind(this)},c=function(a, c){var d={barColor:"#ef1e25",trackColor:"#f9f9f9",scaleColor:"#dfe0e0",scaleLength:5,lineCap:"round",lineWidth:3,trackWidth:void 0,size:110,rotate:0,animate:{duration:1e3,enabled:!0},easing:function(a, b, c, d, e){return b/=e/2,1>b?d/2*b*b+c:-d/2*(--b*(b-2)-1)+c},onStart:function(a, b){},onStep:function(a, b, c){},onStop:function(a, b){}};if("undefined"!=typeof b)d.renderer=b;else{if("undefined"==typeof SVGRenderer)throw new Error("Please load either the SVG- or the CanvasRenderer");d.renderer=SVGRenderer}var e={},f=0,g=function(){this.el=a,this.options=e;for(var b in d)d.hasOwnProperty(b)&&(e[b]=c&&"undefined"!=typeof c[b]?c[b]:d[b],"function"==typeof e[b]&&(e[b]=e[b].bind(this)));"string"==typeof e.easing&&"undefined"!=typeof jQuery&&jQuery.isFunction(jQuery.easing[e.easing])?e.easing=jQuery.easing[e.easing]:e.easing=d.easing,"number"==typeof e.animate&&(e.animate={duration:e.animate,enabled:!0}),"boolean"!=typeof e.animate||e.animate||(e.animate={duration:1e3,enabled:e.animate}),this.renderer=new e.renderer(a,e),this.renderer.draw(f),a.dataset&&a.dataset.percent?this.update(parseFloat(a.dataset.percent)):a.getAttribute&&a.getAttribute("data-percent")&&this.update(parseFloat(a.getAttribute("data-percent")))}.bind(this);this.update=function(a){return a=parseFloat(a),e.animate.enabled?this.renderer.animate(f,a):this.renderer.draw(a),f=a,this}.bind(this),this.disableAnimation=function(){return e.animate.enabled=!1,this},this.enableAnimation=function(){return e.animate.enabled=!0,this},g()};a.fn.easyPieChart=function(b){return this.each(function(){var d;a.data(this,"easyPieChart")||(d=a.extend({},b,a(this).data()),a.data(this,"easyPieChart",new c(this,d)))})}});

/*=====================================
    EasyPieChart With Gradient
========================================*/

/**!
 *
 * Lightweight plugin to render simple, animated and retina optimized pie charts
 *
 * @license
 * @author Robert Fleischmann <rendro87@gmail.com> (http://robert-fleischmann.de)
 * @version 2.1.3
 **/




 (function(root, factory) {
    if(typeof exports === 'object') {
        module.exports = factory();
    }
    else if(typeof define === 'function' && define.amd) {
        define('EasyPieChart', [], factory);
    }
    else {
        root['EasyPieChart'] = factory();
    }
}(this, function() {
/**
 * Renderer to render the chart on a canvas object
 * @param {DOMElement} el      DOM element to host the canvas (root of the plugin)
 * @param {object}     options options object of the plugin
 */
var CanvasRenderer = function(el, options) {
    var cachedBackground;
    var canvas = document.createElement('canvas');

    el.appendChild(canvas);

    if (typeof(G_vmlCanvasManager) !== 'undefined') {
        G_vmlCanvasManager.initElement(canvas);
    }

    var ctx = canvas.getContext('2d');

    canvas.width = canvas.height = options.size;

    // canvas on retina devices
    var scaleBy = 1;
    if (window.devicePixelRatio > 1) {
        scaleBy = window.devicePixelRatio;
        canvas.style.width = canvas.style.height = [options.size, 'px'].join('');
        canvas.width = canvas.height = options.size * scaleBy;
        ctx.scale(scaleBy, scaleBy);
    }

    // move 0,0 coordinates to the center
    ctx.translate(options.size / 2, options.size / 2);

    // rotate canvas -90deg
    ctx.rotate((-1 / 2 + options.rotate / 180) * Math.PI);

    var radius = (options.size - options.lineWidth) / 2;
    if (options.scaleColor && options.scaleLength) {
        radius -= options.scaleLength + 2; // 2 is the distance between scale and bar
    }

    // IE polyfill for Date
    Date.now = Date.now || function() {
        return +(new Date());
    };

    /**
     * Draw a circle around the center of the canvas
     * @param {strong} color     Valid CSS color string
     * @param {number} lineWidth Width of the line in px
     * @param {number} percent   Percentage to draw (float between -1 and 1)
     */
    var drawCircle = function(color, lineWidth, percent) {
        percent = Math.min(Math.max(-1, percent || 0), 1);
        var isNegative = percent <= 0 ? true : false;

        ctx.beginPath();
        ctx.arc(0, 0, radius, 0, Math.PI * 2 * percent, isNegative);

        ctx.strokeStyle = color;
        ctx.lineWidth = lineWidth;

        ctx.stroke();
    };

    /**
     * Draw the scale of the chart
     */
    var drawScale = function() {
        var offset;
        var length;

        ctx.lineWidth = 1;
        ctx.fillStyle = options.scaleColor;

        ctx.save();
        for (var i = 24; i > 0; --i) {
            if (i % 6 === 0) {
                length = options.scaleLength;
                offset = 0;
            } else {
                length = options.scaleLength * 0.6;
                offset = options.scaleLength - length;
            }
            ctx.fillRect(-options.size/2 + offset, 0, length, 1);
            ctx.rotate(Math.PI / 12);
        }
        ctx.restore();
    };

    /**
     * Request animation frame wrapper with polyfill
     * @return {function} Request animation frame method or timeout fallback
     */
    var reqAnimationFrame = (function() {
        return  window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                function(callback) {
                    window.setTimeout(callback, 1000 / 60);
                };
    }());

    /**
     * Draw the background of the plugin including the scale and the track
     */
    var drawBackground = function() {
        if(options.scaleColor) drawScale();
        if(options.trackColor) drawCircle(options.trackColor, options.lineWidth, 1);
    };

    /**
    * Canvas accessor
    */
    this.canvas = function() {
    return canvas;
    };

    /**
    * Canvas 2D context 'ctx' accessor
    */
    this.ctx = function() {
    return ctx;
    };

    /**
     * Clear the complete canvas
     */
    this.clear = function() {
        ctx.clearRect(options.size / -2, options.size / -2, options.size, options.size);
    };

    /**
     * Draw the complete chart
     * @param {number} percent Percent shown by the chart between -100 and 100
     */
    this.draw = function(percent) {
        // do we need to render a background
        if (!!options.scaleColor || !!options.trackColor) {
            // getImageData and putImageData are supported
            if (ctx.getImageData && ctx.putImageData) {
                if (!cachedBackground) {
                    drawBackground();
                    cachedBackground = ctx.getImageData(0, 0, options.size * scaleBy, options.size * scaleBy);
                } else {
                    ctx.putImageData(cachedBackground, 0, 0);
                }
            } else {
                this.clear();
                drawBackground();
            }
        } else {
            this.clear();
        }

        ctx.lineCap = options.lineCap;

        // if barcolor is a function execute it and pass the percent as a value
        var color;
        if (typeof(options.barColor) === 'function') {
            color = options.barColor(percent);
        } else {
            color = options.barColor;
        }

        // draw bar
        drawCircle(color, options.lineWidth, percent / 100);
    }.bind(this);

    /**
     * Animate from some percent to some other percentage
     * @param {number} from Starting percentage
     * @param {number} to   Final percentage
     */
    this.animate = function(from, to) {
        var startTime = Date.now();
        options.onStart(from, to);
        var animation = function() {
            var process = Math.min(Date.now() - startTime, options.animate.duration);
            var currentValue = options.easing(this, process, from, to - from, options.animate.duration);
            this.draw(currentValue);
            options.onStep(from, to, currentValue);
            if (process >= options.animate.duration) {
                options.onStop(from, to);
            } else {
                reqAnimationFrame(animation);
            }
        }.bind(this);

        reqAnimationFrame(animation);
    }.bind(this);
};



var EasyPieChart = function(el, opts) {
    var defaultOptions = {
        barColor: '#ef1e25',
        trackColor: '#f9f9f9',
        scaleColor: '#dfe0e0',
        scaleLength: 5,
        lineCap: 'round',
        lineWidth: 3,
        size: 110,
        rotate: 0,
        animate: {
            duration: 1000,
            enabled: true
        },
        easing: function (x, t, b, c, d) { // more can be found here: https://gsgd.co.uk/sandbox/jquery/easing/
            t = t / (d/2);
            if (t < 1) {
                return c / 2 * t * t + b;
            }
            return -c/2 * ((--t)*(t-2) - 1) + b;
        },
        onStart: function(from, to) {
            return;
        },
        onStep: function(from, to, currentValue) {
            return;
        },
        onStop: function(from, to) {
            return;
        }
    };

    // detect present renderer
    if (typeof(CanvasRenderer) !== 'undefined') {
        defaultOptions.renderer = CanvasRenderer;
    } else if (typeof(SVGRenderer) !== 'undefined') {
        defaultOptions.renderer = SVGRenderer;
    } else {
        throw new Error('Please load either the SVG- or the CanvasRenderer');
    }

    var options = {};
    var currentValue = 0;

    /**
     * Initialize the plugin by creating the options object and initialize rendering
     */
    var init = function() {
        this.el = el;
        this.options = options;

        // merge user options into default options
        for (var i in defaultOptions) {
            if (defaultOptions.hasOwnProperty(i)) {
                options[i] = opts && typeof(opts[i]) !== 'undefined' ? opts[i] : defaultOptions[i];
                if (typeof(options[i]) === 'function') {
                    options[i] = options[i].bind(this);
                }
            }
        }

        // check for jQuery easing
        if (typeof(options.easing) === 'string' && typeof(jQuery) !== 'undefined' && jQuery.isFunction(jQuery.easing[options.easing])) {
            options.easing = jQuery.easing[options.easing];
        } else {
            options.easing = defaultOptions.easing;
        }

        // process earlier animate option to avoid bc breaks
        if (typeof(options.animate) === 'number') {
            options.animate = {
                duration: options.animate,
                enabled: true
            };
        }

        if (typeof(options.animate) === 'boolean' && !options.animate) {
            options.animate = {
                duration: 1000,
                enabled: options.animate
            };
        }

        // create renderer
        this.renderer = new options.renderer(el, options);

        // initial draw
        this.renderer.draw(currentValue);

        // initial update
        if (el.dataset && el.dataset.percent) {
            this.update(parseFloat(el.dataset.percent));
        } else if (el.getAttribute && el.getAttribute('data-percent')) {
            this.update(parseFloat(el.getAttribute('data-percent')));
        }
    }.bind(this);

    /**
     * Update the value of the chart
     * @param  {number} newValue Number between 0 and 100
     * @return {object}          Instance of the plugin for method chaining
     */
    this.update = function(newValue) {
        newValue = parseFloat(newValue);
        if (options.animate.enabled) {
            this.renderer.animate(currentValue, newValue);
        } else {
            this.renderer.draw(newValue);
        }
        currentValue = newValue;
        return this;
    }.bind(this);

    /**
     * Disable animation
     * @return {object} Instance of the plugin for method chaining
     */
    this.disableAnimation = function() {
        options.animate.enabled = false;
        return this;
    };

    /**
     * Enable animation
     * @return {object} Instance of the plugin for method chaining
     */
    this.enableAnimation = function() {
        options.animate.enabled = true;
        return this;
    };

    init();
};

    return EasyPieChart;
}));


//* DEMO HERE *//
