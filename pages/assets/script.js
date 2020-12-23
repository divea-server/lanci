(function ($, root, undefined) 
{
	$(function () 
    {
        window.history.pushState("", "", '/wp-admin/options-general.php?page=lanci'+window.location.hash);

        var $tabs = $( '#lanci .nav-tab-wrapper' );
        var $panes = $( '#lanci .content-column .tab-content' );

        $tabs.find( 'a' ).on('click', function ( event ) 
        {
            var toggle = $(this).data( 'toggle' );

            $(this).blur();

            show_tab( toggle );

            if ( history.pushState )
                history.pushState( null, null, '#' + toggle );
            
            return false;
        });

        var show_tab = function ( name ) {
            $tabs.find( '.nav-tab-active' ).removeClass( 'nav-tab-active' );
            $panes.find( '.tab-pane.active' ).removeClass( 'active' );

            $( '#' + name + '-tab' ).addClass( 'nav-tab-active' );
            $( '#' + name + '-pane' ).addClass( 'active' );
        };

        var show_current_tab = function () {
            var tabHash = window.location.hash.replace( '#', '' );

            if ( tabHash !== '' && $( '#' + tabHash + '-tab' ) ) {
                show_tab( tabHash );
            }
        };

        show_current_tab();
        $( window ).on( 'hashchange', show_current_tab );
    });

})(jQuery, this);