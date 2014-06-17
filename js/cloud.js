( function () {
    var l = 0;
    
    setInterval( function () {
        l += 0.2;
        if ( l > $( document.body ).width() ) {
            l = -$( '#cloud' ).width();
        }
        $( '#cloud' ).css( { left: l + 'px' } );
    }, 20 );
} )()