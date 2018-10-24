(function () {

    var list = [];

    var observer = new window.MutationObserver(function (mutations) {

        mutations.forEach(function (mutation) {

            for (var i = 0; i < mutation.addedNodes.length; i++) {
                var node = mutation.addedNodes[i];
                if (node.hasAttribute && node.hasAttribute('autofocus')) {
                    node.removeAttribute('autofocus');
                    list.push(node);
                }
            }

        });

    });

    observer.observe(document.documentElement, {childList: true, subtree: true});

    window.addEventListener('DOMContentLoaded', function () {

        list.forEach(function (node) {
            node.setAttribute('autofocus', '');
        });

        observer.disconnect();

    });

})();
