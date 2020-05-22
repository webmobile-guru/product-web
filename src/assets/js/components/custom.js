var amenities = [];
$('.ms-drop.bottom input[type="checkbox"]').click(function(event){
    let data = $(this).val();
    let newString = data.replace(/\d+/g, '').replace(':', ' ').replace(/'/g , '').trim();
    if(newString !='' && newString != undefined){
        let idx = $.inArray(newString, amenities);
        if (idx === -1) {
            amenities.push(newString);
        } else {
            amenities.splice(idx, 1);
        }
        $('input[name="hiddenAmeniti"]').val(JSON.stringify(amenities));   
    }
});

$('.btn.btn--sm.btn--primary.main-search-dropdown__submit-btn').click(function(event){
    $('button.main-search-dropdown__close-btn').trigger("click");
});