jQuery.fn.autoGrow=function(){return this.each(function(){var e=this.cols;var t=this.rows;var n=function(){r(this)};var r=function(n){var r=0;var i=n.value.split("\n");for(var s=i.length-1;s>=0;--s){r+=Math.floor(i[s].length/e+1)}if(r>=t)n.rows=r+1;else n.rows=t};var i=function(e){var t=0;var n=0;var r=0;var i=e.cols;e.cols=1;n=e.offsetWidth;e.cols=2;r=e.offsetWidth;t=r-n;e.cols=i;return t};this.style.width="auto";this.style.height="auto";this.style.overflow="hidden";this.style.width=i(this)*this.cols+6+"px";this.onkeyup=n;this.onfocus=n;this.onblur=n;r(this)})}