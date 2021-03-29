$(".video-player").hover(
    function(e){
      $('.watermark').css('display', 'block');
     }, 
    function(e){
      setTimeout(function () {
        if ($('.video-player:hover').length == 0) {
          $('.watermark').css('display', 'none');
        }
      }, 1000);
     } 
);

$(function () {
  $.fn.scrollTo = function (speed) {
      if (typeof(speed) === 'undefined')
          speed = 500;

      $('html, body').animate({
          scrollTop: ($(this).offset().top - 100)
      }, speed);
      
      return $(this);
  };


  
  $('[data-toggle="tooltip"]').tooltip(); 

  $('.player-video').hover(function() { 
      $('.icons').removeClass('hidden'); 
  });
  $('.player-video').mouseleave(function() {                  
     $('.icons').addClass('hidden'); 
  });

  $
  var hash = $('.main_session').val();
  $.ajaxSetup({ 
    data: {
        hash: hash
    },
    cache: false 
  });
  if ($(window).width() < 720) {
    $('ul li').click(function(e) {
       e.stopPropagation(); 
    }); 
    $('.video-info-element').removeClass('pull-right');
  } else {
    if (!$('.video-info-element').hasClass('pull-right')) {
      $('.video-info-element').addClass('pull-right');
    }
  }
});
 
 if ($(window).width() < 720) {
    $('ul li').click(function(e) {
     e.stopPropagation(); 
   }); 

 }

function scrollToTop() {
	  verticalOffset = typeof (verticalOffset) != 'undefined' ? verticalOffset : 0;
	  element = $('html');
	  offset = element.offset();
	  offsetTop = offset.top;
	  $('html, body').animate({
	    scrollTop: offsetTop
	  }, 300, 'linear');
}
function readURL(input,div_class = '') {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          if (div_class != '') {
            $(div_class).html('<img src="'+e.target.result+'">');
          }
          else{

            $('.thumbnail-preview img').attr('src', e.target.result);
          }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).attr("link")).select();
  document.execCommand("copy");
  $temp.remove();
}
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function Wo_LikeSystem(id, type, this_, is_ajax, repeat) {
   if (!id || !type) {
      return false;
   }
   if (!$('#main-container').attr('data-logged') && $('#main-url').val()) {
   	  window.location.href = PT_Ajax_Requests_File() + 'login?to=' + $('#main-url').val();
        return false;
   }
   var result = 0;
   
   if (type == 'like') {
      var likes = $(this_).attr('data-likes');
      if ($(this_).attr('liked')) {
         result = Number(likes) - 1;
         $(this_).removeAttr('liked');
         $(this_).removeClass('active');
      } else {
         result = Number(likes) + 1;
         $(this_).attr('liked', true);
         $(this_).addClass('active');
      }
      $('#likes').text(numberWithCommas(result));
      $(this_).attr('data-likes', result);
      if ($('#dislikes-bar').attr('data-likes') > 0) {
         if ($('#dislikes-bar').hasClass('active')) {
             $('#dislikes-bar').removeAttr('disliked');
             $('#dislikes-bar').removeClass('active');
             result = Number($('#dislikes-bar').attr('data-likes')) - 1;
             $('#dislikes').text(numberWithCommas(result));
             $('#dislikes-bar').attr('data-likes', result);
         }
      }
   } else if (type == 'dislike') {
      var dislikes = $(this_).attr('data-likes');
      if ($(this_).attr('disliked')) {
         result = Number(dislikes) - 1;
         $(this_).removeAttr('disliked');
         $(this_).removeClass('active');
      } else {
         result = Number(dislikes) + 1;
         $(this_).attr('disliked', true);
         $(this_).addClass('active');
      }
      $(this_).attr('data-likes', result);
      $('#dislikes').text(numberWithCommas(result));
      if ($('#likes-bar').attr('data-likes') > 0) {
         if ($('#likes-bar').hasClass('active')) {
             $('#likes-bar').removeAttr('liked');
             $('#likes-bar').removeClass('active');
             result = Number($('#likes-bar').attr('data-likes')) - 1;
             $('#likes').text(numberWithCommas(result));
             $('#likes-bar').attr('data-likes', result);
         }
      }
   }
   if (is_ajax == 'is_ajax') {
      $.post(PT_Ajax_Requests_File() + 'aj/like-system/' + type, {id: id, type:type});
   }
}

function PT_AddLike(id, this_, type , is_ajax) {
   if (!id || !type) { return false; }

   if (!$('#main-container').attr('data-logged') && $('#main-url').val()) {
        window.location.href = PT_Ajax_Requests_File() + 'login?to=' + $('#main-url').val();
        return false;
   }
    var result = 0;
    var main_comment = $('#comment-' + id);
   if (type == 'like') {
      var likes = $(this_).attr('data-likes');
      if ($(this_).attr('liked')) {
         result = Number(likes) - 1;
         $(this_).removeAttr('liked');
         $(this_).removeClass('active');
      } else {
         result = Number(likes) + 1;
         $(this_).attr('liked', true);
         $(this_).addClass('active');
      }
      main_comment.find('#comment-likes').text(numberWithCommas(result));
      $(this_).attr('data-likes', result);
   }
   if (type == 'dislike') {
      var likes = $(this_).attr('data-likes');
      if ($(this_).attr('liked')) {
         result = Number(likes) - 1;
         $(this_).removeAttr('liked');
         $(this_).removeClass('active');
      } 

      else {
         result = Number(likes) + 1;
         $(this_).attr('liked', true);
         $(this_).addClass('active');
      }
      main_comment.find('#comment-likes').text(numberWithCommas(result));
      $(this_).attr('data-likes', result);
   } 
   if (is_ajax == 'is_ajax') {
      $.post(PT_Ajax_Requests_File() + 'aj/comment-like-system/' + type, {id: id, type:type});
   }
}

var PT_Delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

function PT_progressIconLoader(container_elem) {
  container_elem.each(function() {
    progress_icon_elem = $(this).find('i.progress-icon');
    default_icon = progress_icon_elem.attr('data-icon');
    hide_back = false;
    if (progress_icon_elem.hasClass('hidde') == true) {
      hide_back = true;
    }
    if ($(this).find('i.fa-spinner').length == 1) {
      progress_icon_elem.removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-' + default_icon);
      if (hide_back == true) {
        progress_icon_elem.hide();
      }
    } else {
      progress_icon_elem.removeClass('fa-' + default_icon).addClass('fa-spinner fa-spin').show();
    }
    return true;
  });
}

function PT_HasExtension(id, exts) {
    var fileName = $(id).val();
    return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
}




function pt_elexists(el){
  return ($(el).length > 0);
}


function nl2br (str, is_xhtml) {   
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function makeid() {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 10; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}

function escapeHTML(string) {
    var pre = document.createElement('pre');
    var text = document.createTextNode( string );
    pre.appendChild(text);
    return pre.innerHTML;
}

var lastScrollTop = 0;
$('.user-messages').scroll(function(event){
   var st = $(this).scrollTop();
   if (st > lastScrollTop){
       $('#load-more-messages').css('display', 'none');
   } else {
       $('#load-more-messages').css('display', 'block');
   }
   lastScrollTop = st;
});

Object.defineProperty(HTMLMediaElement.prototype, 'playing', {
    get: function(){
        return !!(this.currentTime > 0 && !this.paused && !this.ended && this.readyState > 2);
    }
})




/*!
 * Snackbar v0.1.8
 * http://polonel.com/Snackbar
 *
 * Copyright 2017 Chris Brame and other contributors
 * Released under the MIT license
 * https://github.com/polonel/Snackbar/blob/master/LICENSE
 */
!function(a,b){"use strict";"function"==typeof define&&define.amd?define([],function(){return a.Snackbar=b()}):"object"==typeof module&&module.exports?module.exports=a.Snackbar=b():a.Snackbar=b()}(this,function(){var a={};a.current=null;var b={text:"Default Text",textColor:"#FFFFFF",width:"auto",showAction:!0,actionText:"X",actionTextColor:"#4CAF50",showSecondButton:!1,secondButtonText:"",secondButtonTextColor:"#4CAF50",backgroundColor:"#323232",pos:"bottom-left",duration:5e3,customClass:"",onActionClick:function(a){a.style.opacity=0},onSecondButtonClick:function(a){}};a.show=function(d){var e=c(!0,b,d);a.current&&(a.current.style.opacity=0,setTimeout(function(){var a=this.parentElement;a&&
a.removeChild(this)}.bind(a.current),500)),a.snackbar=document.createElement("div"),a.snackbar.className="snackbar-container "+e.customClass,a.snackbar.style.width=e.width;var f=document.createElement("p");if(f.style.margin=0,f.style.padding=0,f.style.color=e.textColor,f.style.fontSize="14px",f.style.fontWeight=300,f.style.lineHeight="1em",f.innerHTML=e.text,a.snackbar.appendChild(f),a.snackbar.style.background=e.backgroundColor,e.showSecondButton){var g=document.createElement("button");g.className="action",g.innerHTML=e.secondButtonText,g.style.color=e.secondButtonTextColor,g.addEventListener("click",function(){e.onSecondButtonClick(a.snackbar)}),a.snackbar.appendChild(g)}if(e.showAction){var h=document.createElement("button");h.className="action",h.innerHTML=e.actionText,h.style.color=e.actionTextColor,h.addEventListener("click",function(){e.onActionClick(a.snackbar)}),a.snackbar.appendChild(h)}e.duration&&setTimeout(function(){a.current===this&&(a.current.style.opacity=0)}.bind(a.snackbar),e.duration),a.snackbar.addEventListener("transitionend",function(b,c){"opacity"===b.propertyName&&"0"===this.style.opacity&&(this.parentElement.removeChild(this),a.current===this&&(a.current=null))}.bind(a.snackbar)),a.current=a.snackbar,"top-left"!==e.pos&&"top-center"!==e.pos&&"top"!==e.pos&&"top-right"!==e.pos||(a.snackbar.style.top="-100px"),document.body.appendChild(a.snackbar);getComputedStyle(a.snackbar).bottom,getComputedStyle(a.snackbar).top;a.snackbar.style.opacity=1,a.snackbar.className="snackbar-container "+e.customClass+" snackbar-pos "+e.pos,"top-left"===e.pos||"top-right"===e.pos?a.snackbar.style.top=0:"top-center"===e.pos||"top"===e.pos?a.snackbar.style.top="25px":"bottom-center"!==e.pos&&"bottom"!==e.pos||(a.snackbar.style.bottom="-25px")},a.close=function(){a.current&&(a.current.style.opacity=0)};
var c=function(){var a={},b=!1,c=0,d=arguments.length;"[object Boolean]"===Object.prototype.toString.call(arguments[0])&&(b=arguments[0],c++);for(var e=function(c){for(var d in c)Object.prototype.hasOwnProperty.call(c,d)&&(b&&"[object Object]"===Object.prototype.toString.call(c[d])?a[d]=extend(!0,a[d],c[d]):a[d]=c[d])};c<d;c++){var f=arguments[c];e(f)}return a};return a});
//# sourceMappingURL=snackbar.min.js.map