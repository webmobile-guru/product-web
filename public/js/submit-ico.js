$(document).on('click', '.browse', function(){
    var file = $(this).parent().parent().parent().find('.file');
    file.trigger('click');
});
$(document).on('change', '.file', function(){
    $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});
var checkForm = 1;
$(document).ready(function(){

    $('select[name=presale]').change(function(){
        var selected = $(this).val();

        if(selected == 'yes') {
            var objControl = '<div class="form-group">' +
                '<label for="">Presale Start Date</label>' +
                '<input type="text" class="form-control datepicker" name="presale_start_date" value="">' +
                '<p class="help-block"></p>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="">Presale End Date</label>' +
                '<input type="text" class="form-control datepicker" name="presale_end_date" value="">' +
                '<p class="help-block"></p>' +
                '</div>';

            $(this).closest('div.form-group').after(objControl);

            $( ".datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd'
              });
        } else {
            $('input[name=presale_start_date], input[name=presale_end_date]').closest('div.form-group').remove();
        }
    });

    $('input[name=airdrop]').change(function () {
        var selected = $(this).val();
        if(selected == 'yes') {
            var objControl = '<div class="form-group">' +
                '<label for="">Airdrop Link</label>' +
                '<input type="url" class="form-control" name="link[airdrop]" value="">' +
                '<p class="help-block"></p>' +
                '</div>';

            $(this).closest('div.form-group').after(objControl);
        } else {
            $('input[name="link[airdrop]"]').closest('div.form-group').remove();
        }
    });

    $('fieldset[name=team] button[name=add_member]').click(function(){

        var button = $(this); var type = button.data('type');
        var count = button.data('count');

        var objTeam = '<div class="card_shadow group_'+ type +'_member" style="overflow: hidden; margin-bottom:10px;">'+
            '<div class="col-md-6">'+
            '<div class="form-group">'+
            '<label for="logo">Photo</label>'+
            '<input type="file" name="'+ type +'['+count+'][photo]" class="file" accept="image/*" onchange="validate(this)">'+
            '<div class="input-group">'+
            '<span class="input-group-addon"><i class="fa fa-image"></i></span>'+
            '<input type="text" class="form-control input-md" disabled placeholder="Upload Image">'+
            '<span class="input-group-btn">'+
            '<button class="browse btn btn-primary input-md" type="button"><i class="fa fa-search"></i> Browse</button>'+
            '</span>'+
            '</div>'+
            '<p class="help-block"></p>'+
            '</div>'+
            '</div>'+
            '<div class="col-md-6">'+
            '<div class="form-group">'+
            '<label for="">Full Name</label>'+
            '<input type="text" class="form-control core_name" name="'+ type +'['+count+'][full_name]">'+
            '<p class="help-block"></p>'+
            '</div>'+
            '</div>'+
            '<div class="col-md-6">'+
            '<div class="form-group">'+
            '<label for="" class="required">Job Title / Role <small>Example: CEO, CMO, Developer</small></label>'+
            '<input type="text" class="form-control core_title" name="'+ type +'['+count+'][job_title]">'+
            '<p class="help-block"></p>'+
            '</div>'+
            '</div>'+
            '<div class="col-md-6">'+
            '<div class="form-group">'+
            '<label for="">Link <small>Link to Linkedin, or any type of profile</small></label>'+
            '<input type="text" class="form-control core_link" name="'+ type +'['+count+'][link]">'+
            '<p class="help-block"></p>'+
            '</div>'+
            '</div>'+
            '</div>';

        button.data('count', count + 1);

        var insertAt = $('div.' + 'group_'+ type +'_member' + ":last");

        if(insertAt.length > 0) {
            insertAt.after(objTeam);
        } else {
            button.closest('div.col-md-12').before(objTeam);
        }
    });

    // validation logic

    $(document).on('submit','form[name=submit-ico]',function(e){
		
		if(checkForm==1){
			e.preventDefault();
		}else{
			return true;
		}
        

        var button = $(e.target).find('button[type=submit]');
        var form = $(this);
        var formData = new FormData(form[0]);//console.log(formData);
        
        // Display the key/value pairs
        for(var pair of formData.entries()) {// console.log(pair);
            if((typeof pair[1]) == 'object'){
                var obj = document.querySelector('input[name="'+pair[0]+'"]');
                validate(obj);
                formData.delete(pair[0]);
            }
        }

        $('input[type="file"]').each(function(e){
            var obj = document.querySelector('input[name="'+$(this).attr('name')+'"]');
            validate(obj);
            // var fileName = typeof $(this); //$(this).attr('name');
            // console.log(fileName);
        });
        
        button.html('<i class="fa fa-spinner fa-spin"></i>');

        $('.core_name').each(function() {
			var core_name_val=$(this).val();
			if(core_name_val==''){ 
				var formGroup = $(this).closest('div.form-group');
				formGroup.addClass('has-error');
				formGroup.find('p').text('This is a required field');
			}else{
                var formGroup = $(this).closest('div.form-group');
				formGroup.removeClass('has-error');
				formGroup.find('p').text('');
            }
        });

        $('.core_title').each(function() {
			var core_title_val=$(this).val();
			if(core_title_val==''){ 
				var formGroup = $(this).closest('div.form-group');
				formGroup.addClass('has-error');
				formGroup.find('p').text('This is a required field');
			}else{
                var formGroup = $(this).closest('div.form-group');
				formGroup.removeClass('has-error');
				formGroup.find('p').text('');
            }
        });

        $('.core_link').each(function() {
			var core_link_val=$(this).val();
			if(core_link_val==''){ 
				var formGroup = $(this).closest('div.form-group');
				formGroup.addClass('has-error');
				formGroup.find('p').text('This is a required field');
			}else{
                var formGroup = $(this).closest('div.form-group');
				formGroup.removeClass('has-error');
				formGroup.find('p').text('');
            }
        });

        $.ajax({
            type:'post',
            url:form.attr('action'),
            data:formData,
            contentType: false,
            processData: false,
            dataType:'json',
            success:function (result) {
                if(result.status){
					checkForm = 0;
                    form.unbind().submit();
                }
            },
            error:function (result) {
                var errors = result.responseJSON.errors;

                if('title' in errors) {
                    var formGroup = form.find('input[name=title]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.title[0]);
                } else {
                    var formGroup = form.find('input[name=title]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                
                if('soft_cap' in errors) {
                    var formGroup = form.find('input[name=soft_cap]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.soft_cap[0]);
                } else {
                    var formGroup = form.find('input[name=soft_cap]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                
                 if('hard_cap' in errors) {
                    var formGroup = form.find('input[name=hard_cap]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.hard_cap[0]);
                } else {
                    var formGroup = form.find('input[name=hard_cap]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }

                /*if('logo' in errors) {
                    var formGroup = form.find('input[name=logo]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.logo[0]);
                } else {
                    var formGroup = form.find('input[name=logo]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }*/

                if('short_description' in errors) {
                    var formGroup = form.find('textarea[name=short_description]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.short_description[0]);
                } else {
                    var formGroup = form.find('textarea[name=short_description]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }

                if('start_date' in errors) {
                    var formGroup = form.find('input[name=start_date]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.start_date[0]);
                } else {
                    var formGroup = form.find('input[name=start_date]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }

                if('end_date' in errors) {
                    var formGroup = form.find('input[name=end_date]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.end_date[0]);
                } else {
                    var formGroup = form.find('input[name=end_date]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                
                if('category' in errors) {
                    var formGroup = form.find('.category_group');                  
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.category[0]);
                } else {
                    var formGroup = form.find('.category_group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text(''); 
                }
                

                if('ad_notes' in errors) {
                    var formGroup = form.find('input[name=ad_notes]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.ad_notes[0]);
                } else {
                    var formGroup = form.find('input[name=ad_notes]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }

                if('link.website' in errors) {
                    var formGroup = form.find('input[name="link[website]"]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors['link.website'][0]);
                } else {
                    var formGroup = form.find('input[name="link[website]"]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }

                if('link.whitepaper' in errors) {
                    var formGroup = form.find('input[name="link[whitepaper]"]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors['link.whitepaper'][0]);
                } else {
                    var formGroup = form.find('input[name="link[whitepaper]"]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }

                if('link.telegram' in errors) {
                    var formGroup = form.find('input[name="link[telegram]"]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors['link.telegram'][0]);
                } else {
                    var formGroup = form.find('input[name="link[telegram]"]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }

                if('features' in errors) {
                    var formGroup = form.find('textarea[name=features]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.features[0]);
                } else {
                    var formGroup = form.find('textarea[name=features]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }

                if('presale' in errors) {
                    var formGroup = form.find('select[name=presale]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.presale[0]);
                } else {
                    var formGroup = form.find('select[name=presale]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }

                if('presale_start_date' in errors) {
                    var formGroup = form.find('input[name=presale_start_date]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.presale_start_date[0]);
                } else {
                    var messageBoard = form.find('input[name=presale_start_date]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }


                if('presale_end_date' in errors) {
                    var formGroup = form.find('select[name=presale_end_date]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.presale_end_date[0]);
                } else {
                    var messageBoard = form.find('select[name=presale_end_date]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }

                if('core' in errors) {
                    var messageBoard = form.find('fieldset[name=team]').find('p.cmessage');
                    messageBoard.text(errors.core[0]);
                } else {
                    var messageBoard = form.find('fieldset[name=team]').find('p.cmessage');
                    messageBoard.empty();
                }

                if('advisory' in errors) {
                    var messageBoard = form.find('fieldset[name=team]').find('p.amessage');
                    messageBoard.text(errors.advisory[0]);
                } else {
                    var messageBoard = form.find('fieldset[name=team]').find('p.amessage');
                    messageBoard.empty();
                }

                if('contact_person_name' in errors) {
                    var formGroup = form.find('input[name=contact_person_name]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.contact_person_name[0]);
                } else {
                    var formGroup = form.find('input[name=contact_person_name]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }

                if('contact_person_email' in errors) {
                    var formGroup = form.find('input[name=contact_person_email]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.contact_person_email[0]);
                } else {
                    var formGroup = form.find('input[name=contact_person_email]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                } 
                
             
                
                if('permission' in errors) {
                    var formGroup = form.find('input[name*=permission]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.permission[0]);
                } else {
                    var formGroup = form.find('input[name*=permission]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                
                if('involvement' in errors) {
                    var formGroup = form.find('input[name*=involvement]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.involvement[0]);
                } else {
                    var formGroup = form.find('input[name*=involvement]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                
                if('marketing' in errors) {
                    var formGroup = form.find('input[name*=marketing]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.marketing[0]);
                } else {
                    var formGroup = form.find('input[name*=marketing]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                
                if('listing_fee' in errors) {
                    var formGroup = form.find('input[name*=listing_fee]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.listing_fee[0]);
                } else {
                    var formGroup = form.find('input[name*=listing_fee]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                
                if('captcha' in errors) {
                    var formGroup = form.find('input[name*=captcha]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.captcha[0]);
                } else {
                    var formGroup = form.find('input[name*=captcha]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
            }
        }).always(function () {
            button.html('Submit');
        });
    });
});

function validate(element)
{
    var file = element.files[0]; var isLogo = element.getAttribute('name') == 'logo';
    var formGroup = $(element).closest('div.form-group');
    formGroup.removeClass('has-error');
    formGroup.find('p').text('');
    

    if(isLogo && (file == undefined)){ 
        formGroup.addClass('has-error');
        formGroup.find('p').text("This is a required field");
        return false;
    }
	
	if((file == undefined)){
        formGroup.addClass('has-error');
        formGroup.find('p').text("This is a required field");
        return false;
    }

    var t = file.type.split('/').pop().toLowerCase();
    if (t != "jpeg" && t != "jpg" && t != "png" && t != "bmp" && t != "gif") {
        formGroup.addClass('has-error');
        formGroup.find('p').text("Please select a valid image file");
        return false;
    }

    if(isLogo) {
        var reader = new FileReader();

        //Read the contents of Image File.
        reader.readAsDataURL(file);
        reader.onload = function (e) {

            //Initiate the JavaScript Image object.
            var image = new Image();

            //Set the Base64 string return from FileReader as source.
            image.src = e.target.result;

            //Validate the File Height and Width.
            image.onload = function () {
                var height = this.height;
                var width = this.width;
                if (height > 1600 || width > 1600) {
                    formGroup.addClass('has-error');
                    formGroup.find('p').text("Height and Width musn't be exceed from 1600px.");

                    return false;
                }
                if (height < 70 || width < 70) {
                    formGroup.addClass('has-error');
                    formGroup.find('p').text("Height and Width musn't be less than 150px.");

                    return false;
                }

                return true;
            };
        }
    }

    return true;
}
