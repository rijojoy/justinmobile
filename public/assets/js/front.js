$(document).ready(function(){
    $(this).scrollTop(0);
});

$(document).ready(function() {
    // step 1, select a model
    $('.select-model').click(function (){
        if($.order) {
            reset = confirm('Are you sure? This will empty your current sale!');
            if (reset == false) {
                return false;
            } else {
                $('.option-selection').removeClass('active');
            }
        }
    
        var model_id = $(this).data('model');
        $('.model').addClass('panel-geckohno');
        $('#model-' + model_id).removeClass('panel-geckohno');
        $('.model-properties').hide();
        $('.model-properties[data-model="' + model_id + '"]').show();
        new_order(model_id);
        $('#price-value').text(parseFloat(Number($.model.baseprice).toFixed(2)));
        $('#price').show();
        
        $('html, body').animate({
            scrollTop: $("#optionstuff").offset().top
        }, 1000);
        
        return false;
    });
    
    // step 2, select options
    $('.option-selection').click(function (){
        var property_div = $(this).closest('.property');
        var property = property_div.data();
        var option = $(this).data();
        
        if (property.type === "single") {
            $(this).parent().find('.option-selection').removeClass('active');
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $.order.properties[property.id] = null;
                var action = 'remove';
            } else {
                $(this).addClass('active');
                $.order.properties[property.id] = option.id;
                var action = 'add';
            }
        } else if (property.type === "multi") {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $.order.properties[property.id].splice($.order.properties[property.id].indexOf(option.id), 1);
                var action = 'remove';
            } else {
                $(this).addClass('active');
                if (!$.order.properties[property.id]) {
                    $.order.properties[property.id] = [];
                }
                $.order.properties[property.id].push(option.id);
                var action = 'add';
            }
        }
    
        if (option.explanation == 1) {
            $('#explain-property-' + property.id).modal('show');
            property_div.find('.property-explanation-edit').show();
        } else {
            property_div.find('.property-explanation-edit').hide();
            $('#explanation-' + property.id).val('');
        }
    
        // unlock the next property if available, if not proceed to the next step
        var next_property = $(this).closest('.property').next('.property');
        if(next_property) {
            next_property.find('.option-selection').attr('disabled', false);
            next_property.find('.hidden-option').show();
        }

         var cg = $(this).attr("title");
        if(cg=='Yes' || cg == 'No') {
            $( "button[title='Local shop drop off']" ).attr('disabled', false);
            $( "button[title='Courier collection']" ).attr('disabled', false);
            $( "button[title='Own P&P (+£4)']" ).attr('disabled', false);
        }
        
        if ($(this).closest('.property').is(':last-child')) {
            $('#details-form').find('*').attr('disabled', false);
        }
    
        update_price();
        $('#price').show();
    
        return false;
    });

    // skip a property
    $('.property-skip').click(function (){
        var next_property = $(this).closest('.property').next('.property');
        if(next_property) {
            next_property.find('.option-selection').attr('disabled', false);
            next_property.find('.hidden-option').show();
        }
    
        if ($(this).closest('.property').is(':last-child')) {
            $('#details-form').find('*').attr('disabled', false);
        }
		return false;
    });

    // select payment method
    $('#payment').change(function (){
        $('.payment-method input').attr('required', false);
        $('.payment-method').hide();
        $('.payment-method input').val('');
        $('#payment-' + $(this).val()).show();
        $('#payment-' + $(this).val() + ' input').attr('required', true);
    });

    // select payment method
    $('#packaging').change(function (){
        var type = $(this).val();
        $('#packaging').parent().find('.switchable-help').hide();
        $('#packaging-' + type).show();
    });

    // PROCESS THE FORM!
    $('#details-form').submit(function (){
        // generate the order details
            // look for explanations
            $.order.explanations = {};
            $('.explanation').each(function () {
                if ($(this).val() != '') {
                    var property_id = $(this).data('property');
                    $.order.explanations[property_id] = $(this).val();
                }
            });
        // validate the details input
        $.order.person = $('#details-form').serializeObject();
        var order_data = JSON.stringify($.order);
       
        var submitbtn = $(this).find('.submitform')
        var processing = $(this).find('.processing');
        
        submitbtn.attr('disabled', true);
        submitbtn.html('Submitting...');
        processing.show();

        $.post("/", order_data, function (data){
            submitbtn.html('Submitted');
        }).done(function(data){
            if(data.result == "error") {
                submitbtn.html('Register Sale');
                submitbtn.attr('disabled', false);
                $('.details-submit-error').html(data.messages);
                $('.details-submit-error').show();
            } else if (data.result == "success") {
                $(location).attr('href', '/thankyou?order=' + data.orderid);
            }
        }).fail(function(data){
            submitbtn.html('Register Sale');
            submitbtn.attr('disabled', false);
        }).always(function(data){
            processing.hide();
        });
    
        
        
        // update the form with error or success message :-D
        console.log($.order);
        return false;
    });
    
    $('button[type=reset]').click(function() {
        if(confirm('Are you sure you want to clear all form data?')) {
            location.reload(true);
        } 
    });
});

function update_price() {
    var price = parseFloat(Number($.model.baseprice).toFixed(2));
    var minprice = parseFloat(Number($.model.minprice).toFixed(2));
    // fetch all of the selected options
    $('.option-selection.active').each(function() {
        var option = $(this).data();
        var amt = parseFloat(option.mamt);
        if (option.mtype == "add_amount") {
            price = price + amt;
        } else if (option.mtype == "add_percentage") {
            price = price + (price / 100) * amt;
        } else if (option.mtype == "deduct_amount") {
            price = price - amt;
        } else if (option.mtype == "deduct_percentage") {
            price = price - (price / 100) * amt;
        }
    });

    var roundedprice = (Math.round( price * 100 ) / 100).toFixed(0);
    if(roundedprice < minprice)
    {
        $('#price-value').text(minprice); // display
      $('#myprice').val(minprice); // internal
    }
    else
    {
      $('#price-value').text(roundedprice); // display
      $('#myprice').val(roundedprice); // internal
   }
}

// http://stackoverflow.com/a/1186309/200518
$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};