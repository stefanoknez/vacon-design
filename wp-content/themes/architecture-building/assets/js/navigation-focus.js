var architecture_building_Keyboard_loop = function (elem) {
  var architecture_building_tabbable = elem.find('select, input, textarea, button, a').filter(':visible');
  var architecture_building_firstTabbable = architecture_building_tabbable.first();
  var architecture_building_lastTabbable = architecture_building_tabbable.last();
  architecture_building_firstTabbable.focus();

  architecture_building_lastTabbable.on('keydown', function (e) {
    if ((e.which === 9 && !e.shiftKey)) {
      e.preventDefault();
      architecture_building_firstTabbable.focus();
    }
  });

  architecture_building_firstTabbable.on('keydown', function (e) {
    if ((e.which === 9 && e.shiftKey)) {
      e.preventDefault();
      architecture_building_lastTabbable.focus();
    }
  });

  elem.on('keyup', function (e) {
    if (e.keyCode === 27) {
      elem.hide();
    };
  });
};