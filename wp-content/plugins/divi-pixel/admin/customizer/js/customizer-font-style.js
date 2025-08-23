/**
 * Script run inside a Customizer control sidebar
 */

(function($) {
    wp.customize.bind('ready', function() {
        $('.dipi_customizer_control_font_style').each(function(){
            setup($(this));
        });
    });

    var setup = function($this){
        let $input = $this.find('input.dipi_font_style');
        let inputVal = $input.val();
        let vals = inputVal.split("|");
        if(typeof vals === 'undefined' || vals === null || vals.length < 5) {
            vals = [];
        }

        //italic
        if(vals[0] === 'on') {
            $this.find('.button_italic').addClass("active");
        }
        if(vals[1] === 'on') {
            $this.find('.button_uppercase').addClass("active");
        }
        if(vals[2] === 'on') {
            $this.find('.button_small_caps').addClass("active");
        }
        if(vals[3] === 'on') {
            $this.find('.button_underline').addClass("active");
        }
        if(vals[4] === 'on') {
            $this.find('.button_strike_through').addClass("active");
        }

        $this.find('.button').on('click', buttonClicked);

        function buttonClicked(){

            let $this = $(this);
            if($this.hasClass("button_uppercase") && !$this.hasClass("active")) {
                $this.siblings(".button_small_caps").removeClass("active");
            }

            if($this.hasClass("button_small_caps") && !$this.hasClass("active")) {
                $this.siblings(".button_uppercase").removeClass("active");
            }
    
            if($this.hasClass("button_underline") && !$this.hasClass("active")) {
                $this.siblings(".button_strike_through").removeClass("active");
            }
    
            if($this.hasClass("button_strike_through") && !$this.hasClass("active")) {
                $this.siblings(".button_underline").removeClass("active");
            }
    
            $(this).toggleClass("active");
    
            setInputVal();
        }
    
        function setInputVal(){
            let vals = [];
            vals.push(buttonOn('.button_italic'));
            vals.push(buttonOn('.button_uppercase'));
            vals.push(buttonOn('.button_small_caps'));
            vals.push(buttonOn('.button_underline'));
            vals.push(buttonOn('.button_strike_through'));
            $input.val(vals.join("|"));
            $input.change();
        }

        function buttonOn(button){
            return $this.find(button).hasClass("active") ? 'on' : '';
        }

    }

})(jQuery);
