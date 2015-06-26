$(function () {
    function formatCurrency(currency) {
        return currency.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(".remove-from-cart").on("click", function () {
        var productId = $(this).parents('tr').attr('id');
        productId = productId.replace(/^\D+/g, '');
        function callback(response) {
            if (response.status !== 'error') {
                if (response.status == 'success') {
                    var itemCartQuantity = $('tr#item-' + productId).find('td.miniCartQuantity a');
                    var factureItemCount = itemCartQuantity.text();
                    var itemCount = factureItemCount.replace(/^\D+/g, '');
                    itemCount = parseInt(itemCount);
                    if (--itemCount == 0) {
                        $('tr#item-' + productId).remove();
                    } else {
                        itemCartQuantity.text(factureItemCount.replace(/\d+/g, itemCount));
                    }
                    var spanSubTotal = $('span.cart-subTotal');
                    var spanTotalPrice = $('span.cart-total-price');
                    var spanItemTotalPrice = $('span.item-total-price-' + productId);

                    var subTotal = spanSubTotal.text();
                    subTotal = subTotal.replace(/,/g, '');
                    subTotal = parseInt(subTotal);
                    subTotal = subTotal - response.product.price;
                    if (subTotal < 0)subTotal = 0;
                    spanSubTotal.text(formatCurrency(subTotal));
                    spanTotalPrice.text(formatCurrency(subTotal));
                    spanItemTotalPrice.text(formatCurrency(response.product.itemTotalPrice));
                }
            }
        }

        productRemoveFromCart(productId, true, false, callback);
    });
});