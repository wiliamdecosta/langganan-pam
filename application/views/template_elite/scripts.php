<script src="<?php echo base_url(); ?>assets/js/jquery.blockUI.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/jqgrid/src/jquery.jqGrid.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jqgrid.function.js"></script>
<!-- begin swal -->
<script src="<?php echo base_url(); ?>assets/node_modules/sweetalert/sweetalert.min.js"></script>
<!-- end swal -->

<script src="<?php echo base_url(); ?>assets/js/jquery.simplePagination.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.number.min.js" type="text/javascript"></script>

<script>
    function PopupCenter(url, title, w, h) {
        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        // Ajax setup csrf token.
        var csfrData = {};
        csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
        $.ajaxSetup({
            data: csfrData,
            cache: false
        });
   });

    $(document).ajaxStart(function () {
        $(document).ajaxStart($.blockUI({
            message:  'Loading...',
            css: {
                border: 'none',
                padding: '5px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .6,
                color: '#fff'
            }

        })).ajaxStop($.unblockUI);
    });

    $.jgrid.defaults.responsive = true;
    $.jgrid.defaults.styleUI = 'Bootstrap';
    jQuery.fn.center = function () {

        if(this.width() > $(window).width()) {
            this.css("width", $(window).width()-40);
        }
        this.css("top",($(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
        this.css("left",( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");

        return this;
    }
</script>
