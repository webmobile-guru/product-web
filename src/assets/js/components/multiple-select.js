
/*
================================================================================

  "Multiple Select" component

================================================================================
*/

var MultipleSelect = (function() {
  let initMultipleSelect = function() {
    $('.js-multiple-select').multipleSelect({
      selectAll: false
    });
  };

  let init = function() {
    initMultipleSelect();
  };

  return {
    init: init
  };

})();

MultipleSelect.init()
