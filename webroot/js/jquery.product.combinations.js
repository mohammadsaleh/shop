/**
 * Created by M Shafiee on 7/11/2015.
 */
function formatCurrency(currency){
    return currency.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(".selectable_on_order").on('change', function(e){
    var data = $('form#ProductAddToCardForm').serializeArray();
    var combination = [];
    var isMatchedCombination = false, matchCombination = [];
    for(var i = 0, j = 0 ; i < data.length ; i++){
        if(data[i].name == '_method' || data[i].name == 'combination_id')continue;
        var com = {};
        var pid_regex = /data\[metas\]\[([0-9]+)\]/g;
        var match = pid_regex.exec(data[i].name);
        com.property_id = match[1];
        com.property_value = data[i].value;
        combination[j++] = com;
    }
    $.each(combinations, function(index, comb){
        var matchProperty = false;
        $.each(comb.Properties, function(key, property){
            matchProperty = false;
            for(i = 0 ; i < combination.length ; i++){
                if(combination[i].property_id == property.id && combination[i].property_value == property.uniqueId){
                    matchProperty = true;
                    break;
                }
            }
            if(!matchProperty){
                return false;
            }
        });
        if(matchProperty){
            isMatchedCombination = true;
            matchCombination = comb;
            return false;
        }
    });
    if(isMatchedCombination){
        var newPrice = price + parseFloat(matchCombination.inc_price);
        var offNewPrice = ((100 - off)/100) * newPrice;
        $('span.price-standard').text(formatCurrency(newPrice));
        $('span.price-sales').text(formatCurrency(offNewPrice));
        $('input#combination_id').val(matchCombination.id);
    }else{
        $('span.price-standard').text(formatCurrency(price));
        $('span.price-sales').text(formatCurrency(((100 - off)/100) * (price)));
        $('input#combination_id').val(0);
    }
});