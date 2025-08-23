jQuery(function($){
    $(document).ready(function(){
        $(".control-section-dipi").each(function() {
            $(".customize-control.customize-control-dipi-heading", this).addClass("dipi-control-section-start");
            $(".customize-control:visible", this).addClass("dipi-control-section-middle");
            $(".customize-control:visible:last", this).addClass("dipi-control-section-end");
            $(".customize-control.customize-control-dipi-heading", this).prev(".customize-control:visible").addClass("dipi-control-section-end");
        });
    });
});