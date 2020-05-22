
/*
================================================================================

  "Custom Select" component

================================================================================
*/

const CustomSelect = (function() {

  const initCustomSelect = function() {
    const selectList = document.querySelectorAll('.js-custom-select');

    Array.from(selectList, function(item) {
      const placeholder = item.dataset.placeholder;

      $(item).customSelect({
        includeValue: true,
        placeholder: `<span class="custom-select__placeholder">${placeholder}</span>`
      });
    });
  };

  const init = function() {
    initCustomSelect();
  };

  return {
    init: init
  };

})();

CustomSelect.init();
