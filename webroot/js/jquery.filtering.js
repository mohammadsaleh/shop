$(function(){
    function filtering(){
        $("div.loader").show();
        var data = $('form.filtering-form').serializeArray();
        var fix_elements = ['sort', 'direction', 'minPrice', 'maxPrice'];
        $.each(data, function(key, element){
            var find_segment = false;
            var replace_segment = false;
            var is_fix_element = fix_elements.indexOf(element.name);
            if(element.value != "" && element.value != 0){
                $.each(window_href_segments, function(k, e){
                    if(e.name == element.name){
                        if(e.value == element.value){
                            find_segment = true;
                            window_href_segments[k].foundInForm = true
                        }else if(is_fix_element >= 0){
                            replace_segment = k;
                        }
                        return false;
                    }
                });
                if(replace_segment !== false){
                    window_href_segments[replace_segment].value = element.value;
                    window_href_segments[replace_segment].foundInForm = true;
                }
                else if(!find_segment){
                    var length = window_href_segments.length;
                    element.foundInForm = true;
                    window_href_segments[length] = element;
                }
            }
        });
        $.each(window_href_segments, function(k, e){
            if( (e.foundInForm == undefined) || e.foundInForm == false ){
                delete window_href_segments[k];
            }
        });
        var new_url = '';
        if(window_href_segments.length > 0){
            $.each(window_href_segments, function(key, element){
                if(element != undefined){
                    new_url += element.name + ':' + element.value + '/' ;
                }
            });
        }
        new_url = new_url.substring(0, new_url.length-1);
        if(new_url != ""){
            new_url = '/' + new_url ;
        }
        new_url = base_url + new_url;
        window.history.pushState("", "", new_url);
        $.ajax({
            type: "GET",
            url: window.location.href,
            dataType: "text",
            success: function(response){
                $('div.category-products-container').html(response);
                $('strong.pagination-counter').text(pageCounter);
                setTimeout( "$('div.loader').hide();", 400 );
            },
            error: function(){}
        });
    }
    $('body').on('click', 'span.icr', function(e){
        e.preventDefault();
        filtering();
    });
    $(document).on('blur', 'input#minPrice, input#maxPrice', function(e){
        filtering();
    });
    $(document).on('change','#change-order, #change-direction',function(e){
        filtering();
    });
});