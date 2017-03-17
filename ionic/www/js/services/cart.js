angular.module('starter.services')
    .service('$cart', ['$localStorage', function($localStorage) {
        var key = 'cart',
            cartAux = $localStorage.getObject(key);
        if (!cartAux) {
            initCart();
        }

        this.clear = function() {
            initCart();
        };

        this.get = function() {
            return $localStorage.getObject(key);
        };

        this.getItem = function(i) {
            return this.get().items[i];
        };

        this.additem = function(item) {
            var cart = this.get(),
                itemAux, exists = false;
            for (var index in cart.items) {
                itemAux = cart.items[index];
                if (itemAux.id == item.id) {
                    itemAux.qtd = item.qtd + itemAux.qtd;
                    itemAux.subTotal = calculateSubTotal(itemAux);
                    exists = true;
                    break;
                }
            }
            if (!exists) {
                item.subTotal = calculateSubTotal(item);
                cart.items.push(item);
            }
            cart.total = getTotal(cart.items);

            $localStorage.setObject(key, cart);
        };

        this.removeItem = function(i) {
            var cart = this.get();
            cart.items.splice(i, 1);
            cart.total = getTotal(cart.items);

            $localStorage.setObject(key, cart);
        };

        this.updateQtd = function(i, qtd) {
            var cart = this.get(),
                itemAux = cart.items[i];
            itemAux.qtd = qtd;

            itemAux.subTotal = calculateSubTotal(itemAux);
            cart.total = getTotal(cart.items);
            $localStorage.setObject(key, cart);
        };

        this.setCupom = function(code, value) {
            var cart = this.get();
            cart.cupom = {
                code: code,
                value: value
            };

            $localStorage.setObject(key, cart);
        };

        this.removeCupom = function() {
            var cart = this.get();
            cart.cupom = {
                code: null,
                value: null
            };

            $localStorage.setObject(key, cart);
        };

        this.getTotalFinal = function() {
            var cart = this.get();
            return cart.total - (cart.cupom.value || 0);
        }

        function calculateSubTotal(item) {
            return item.price * item.qtd;
        };

        function getTotal(items) {
            var sum = 0;
            angular.forEach(items, function(item) {
                sum += item.subTotal;
            });

            return sum;
        };

        function initCart() {
            $localStorage.setObject(key, {
                items: [],
                total: 0,
                cupom: {
                    code: null,
                    value: null,
                },
            });
        };

    }]);