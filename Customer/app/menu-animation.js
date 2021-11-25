//script for animation of menu

var nav = $('nav');
var line = $('<div />').addClass('line');

line.appendTo(nav);

var active;
var pos = 0;
var wid = 0;
var id = "";

if (localStorage.getItem('pos') && localStorage.getItem('wid')) {
  //get id
  id = localStorage.getItem('id');

  //set class active
  nav.find('ul li').removeClass('active');
  $(`#${id}`).addClass('active');

  active = nav.find('.active');

  //get status menu
  pos = parseFloat(localStorage.getItem('pos'));
  wid = parseFloat(localStorage.getItem('wid'));

  //set line
  if (active.length) {
    line.css({
      left: pos,
      width: wid
    });
    localStorage.clear();
  }
} else {
  //set class active
  active = nav.find('.active');

  //set line
  if(active.length) {
    pos = active.position().left;
    wid = active.width();
    line.css({
      left: pos,
      width: wid
    });
  }
}

nav.find('ul li a').hover(function(e) {
  e.preventDefault();
  if(!$(this).parent().hasClass('active') && !nav.hasClass('animate')) {
    
    nav.addClass('animate');

    var _this = $(this);

    nav.find('ul li').removeClass('active');

    var position = _this.parent().position();
    var width = _this.parent().width();

    if(position.left >= pos) {
      line.animate({
        width: ((position.left - pos) + width)
      }, 300, function() {
        line.animate({
          width: width,
          left: position.left
        }, 150, function() {
          nav.removeClass('animate');
        });
        _this.parent().addClass('active');
      });
    } else {
      line.animate({
        left: position.left,
        width: ((pos - position.left) + wid)
      }, 300, function() {
        line.animate({
          width: width
        }, 150, function() {
          nav.removeClass('animate');
        });
        _this.parent().addClass('active');
      });
    }
    //get status and store to localstorage
    id = $(this).parent().attr('id');
    pos = position.left;
    wid = width;
  }
});

nav.find('ul li a').click(function(e) {
  localStorage.setItem('id', id);
  localStorage.setItem('pos', pos);
  localStorage.setItem('wid', wid);
});