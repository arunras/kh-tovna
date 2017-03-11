
/**
 * ProgressBar for Google Maps v3
 * @version 1.1
 *
 * by José Fernando Calcerrada.
 *
 * Licensed under the GPL licenses:
 * http://www.gnu.org/licenses/gpl.html
 *
 *
 * Chagelog
 *
 * v1.1
 * - IE fixed
 *
 */

progressBar = function(opts) {

  var options = progressBar.combineOptions(opts, {
    height:       '1.3em',
    width:        '150px',
    top:          '30px',
    right:        '5px',
    colorBar:     '#68C',
    background:   '#FFF',
    fontFamily:   'Arial, sans-serif',
    fontSize:     '12px',
    text :		  'Loading...',
    loadingImg:   '../images/loading_marker.gif',
    border:		  '1px solid #CCC'
  });

  var current = 0;
  var total = 0;

  var shadow = '0px 0px 0px #888';


  var div = document.createElement('div');
  div.id  = 'pg_div';
  var dstyle = div.style;
  div.style.cssText = 'box-shadow: ' + shadow + '; '
                    + '-webkit-box-shadow: ' + shadow + '; '
                    + '-moz-box-shadow: ' + shadow + '; ';
  dstyle.display     = 'none';
  dstyle.width       = options.width;
  dstyle.height      = options.height;
  dstyle.marginRight = '6px';
  dstyle.border      = options.border;
  dstyle.background  = options.background;
  dstyle.fontSize    = options.fontSize;
  dstyle.textAlign   = 'left';
  dstyle.color   = '#FF0000';

  var text = document.createElement('div');
  text.id  = 'pg_text';
  var tstyle = text.style;
  tstyle.position      = 'absolute';
  tstyle.width         = '100%';
  tstyle.border        = '5px';
  tstyle.textAlign     = 'center';
  tstyle.verticalAlign = 'bottom';

  var bar = document.createElement('div');
  bar.id                    = 'pg_bar';
  bar.style.height          = options.width-16;
  bar.style.height          = options.height;
  bar.style.backgroundColor = options.colorBar;
  //bar.style.marginLeft      = '16px';
  
  /*RUN*/
  var loading = document.createElement('div');
  loading.style.width			= '16px';
  loading.style.height			= options.height;
  loading.style.position		= 'absolute';
  loading.style.backgroundImage = "url('"+options.loadingImg+"')";
  loading.style.backgroundImage = "rgba(255,255,255,1)";
  loading.style.border 			= '0px #F00 solid';
  /*RUN*/
  div.appendChild(loading);
  div.appendChild(text);
  div.appendChild(bar);


  var draw = function(mapDiv) {
    div.style.cssText = control.style.cssText +
      'z-index: 20; position: absolute; '+
      'top: '+options.top+'; right: '+options.right+'; ';
      document.getElementById(mapDiv).children[0].appendChild(div);
  };

  var start = function(total_) {
    if (parseInt(total_) === total_ && total_ > 0) {
      total = total_;
      current = 0;
      bar.style.width = '0%';
      text.innerHTML = options.text;
      div.style.display = 'block';
    }

    return total;
  };

  var updateBar = function(increase) {
    if (parseInt(increase) === increase && total) {
      current += parseInt(increase);
      if (current > total) {
        current = total;
      } else if (current < 0) {
        current = 0;
      }

      bar.style.width = Math.round((current/total)*100)+'%';
      text.innerHTML = current+' / '+total;

    } else if (!total){
      return total;
    }

    return current;
  }

  var hide = function() {
    div.style.display = 'none';
  }

  var getDiv = function() {
    return div;
  }

  var getTotal = function() {
    return total;
  }

  var setTotal = function(total_) {
    total = total_;
  }

  var getCurrent = function() {
    return current;
  }

  var setCurrent = function(current_) {
    return updateBar(current_-current);
  }

  return {
    draw:         draw,
    start:        start,
    updateBar:    updateBar,
    hide:         hide,
    getDiv:       getDiv,
    getTotal:     getTotal,
    setTotal:     setTotal,
    getCurrent:   getCurrent,
    setCurrent:   setCurrent
  }

}

progressBar.combineOptions = function (overrides, defaults) {
  var result = {};
  if (!!overrides) {
    for (var prop in overrides) {
      if (overrides.hasOwnProperty(prop)) {
        result[prop] = overrides[prop];
      }
    }
  }
  if (!!defaults) {
    for (prop in defaults) {
      if (defaults.hasOwnProperty(prop) && (result[prop] === undefined)) {
        result[prop] = defaults[prop];
      }
    }
  }
  return result;
}