// Theme JavaScript
(function (UIkit, util) {

    var $ = util.$,
        attr = util.attr,
        css = util.css,
        addClass = util.addClass;

    var selector = '.tm-header ~ [class*="uk-section"], .tm-header ~ * > [class*="uk-section"]';

    UIkit.component('header', {

        update: [

            {

                read: function (data) {

                    var section = $(selector);
                    var modifier = attr(section, 'tm-header-transparent');

                    if (!modifier || !section) {
                        return false;
                    }

                    data.prevHeight = this.height;
                    data.height = this.$el.offsetHeight;

                    var sticky = UIkit.getComponent($('[uk-sticky]', this.$el), 'sticky');
                    if (sticky) {

                        var dat = sticky.$options.data;
                        if (dat.animation !== 'uk-animation-slide-top') {
                            util.each({
                                animation: 'uk-animation-slide-top',
                                top: selector,
                                clsInactive: 'uk-navbar-transparent uk-' + modifier
                            }, function (value, key) {
                                dat[key] = sticky[key] = sticky.$props[key] = value;
                            });
                        }

                        sticky.$props.top = section.offsetHeight <= window.innerHeight
                            ? selector
                            : util.offset(section).top + 300;
                    }

                },

                write: function (data) {

                    if (!this.placeholder) {

                        var section = $(selector);
                        var modifier = attr(section, 'tm-header-transparent');

                        addClass(this.$el, 'tm-header-transparent');
                        addClass($('.tm-headerbar-top, .tm-headerbar-bottom'), 'uk-' + modifier);

                        this.placeholder = util.hasAttr(section, 'tm-header-transparent-placeholder')
                            && util.before($('[uk-grid]', section), '<div class="tm-header-placeholder uk-margin-remove-adjacent"></div>');

                        var navbar = $('[uk-navbar]', this.$el);
                        if (attr(navbar, 'dropbar-mode') === 'push') {
                            attr(navbar, 'dropbar-mode', 'slide');
                        }

                        if (!$('[uk-sticky]', this.$el)) {
                            addClass($('.uk-navbar-container', this.$el), 'uk-navbar-transparent uk-' + modifier);
                        }

                    }

                    if (this.placeholder && data.prevHeight !== data.height) {
                        css(this.placeholder, {height: data.height});
                    }
                },

                events: ['load', 'resize']

            }

        ]

    });

    if (util.isRtl) {

        var mixin = {

            init: function () {
                this.$props.pos = util.swap(this.$props.pos, 'left', 'right');
            }

        };

        UIkit.mixin(mixin, 'drop');
        UIkit.mixin(mixin, 'tooltip');

    }

})(UIkit, UIkit.util);
