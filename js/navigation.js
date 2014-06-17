/*
The BSD License.

Developer: Dionysis "dionyziz" Zindros <dionyziz@kamibu.com>
           Petros Aggelatos <petros@kamibu.com>
           
Copyright (c) 2010, Dionysis Zindros and Petros Aggelatos
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
    * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the
      documentation and/or other materials provided with the distribution.
    * Neither the name of Dionysis Zindros nor Petros Aggelatos nor the
      names of its contributors may be used to endorse or promote products
      derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY DIONYSIS ZINDROS AND PETROS AGGELATOS ``AS IS'' AND ANY
EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL KAMIBU BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

function colorFade( start, end, duration, target ) {
    var h = 0;
    ( function () {
        var color, r, g, b;
        
        h += 50 / duration;
        if ( h > 1 ) {
            h = 1;
        }
        r = Tween( start[ 0 ], end[ 0 ], h );
        g = Tween( start[ 1 ], end[ 1 ], h );
        b = Tween( start[ 2 ], end[ 2 ], h );
        
        color = 'rgb(' + r + ',' + g + ',' + b + ')';
        target.css( { backgroundColor: color } );
        if ( h < 1 ) {
            setTimeout( arguments.callee, 20 );
        }
    } )();
}

$( 'a.legal' ).click( function () {
    $( '.dim, .modal' ).show();
    $( '.modal a.back' ).click( function () {
        $( '.dim, .modal' ).hide();
        return false;
    } );
    return false;
} );

var mainToBibliography = function () {
    window.location.hash = 'bibliography';
    $( '#bibliography' ).fadeIn();
    $( '#everything, #cloud' ).fadeOut();
    $( '#sea' ).animate( { bottom: '-100px' } );
    document.body.style.overflow = 'hidden';
    colorFade( [ 134, 201, 239 ], [ 0, 0, 0 ], 500, $( 'body' ) );
    return false;
};

$( 'a.bibliography' ).click( function () {
    window.location.hash = '#bibliography';
    window.onhashchange();
    return false;
} );

var bibliographyToMain = function () {
    window.location.hash = '';
    $( '#bibliography' ).fadeOut( 'fase', function () {
        this.style.display = 'none';
    } );
    $( '#everything, #cloud' ).fadeIn();
    $( '#sea' ).animate( { bottom: '0' } );
    document.body.style.overflow = 'hidden';
    colorFade( [ 0, 0, 0 ], [ 134, 201, 239 ], 500, $( 'body' ) );
    return false;
};

$( '#bibliography a.back' ).click( function () {
    window.location.hash = '#';
    window.onhashchange();
    return false;
} );

var mainToLectures = function () {
    window.location.hash = 'lectures';
    
    var SPEED = 1000;
    var h = 0;
    
    ( function () {
        var start = [ 0, 102, 255 ];
        var end = [ 28, 28, 45 ];
        var color, r, g, b;
        
        h += 50 / SPEED;
        if ( h > 1 ) {
            h = 1;
        }
        r = Tween( start[ 0 ], end[ 0 ], h );
        g = Tween( start[ 1 ], end[ 1 ], h );
        b = Tween( start[ 2 ], end[ 2 ], h );
        
        waveEnd = [ r, g, b ];
        
        color = 'rgb(' + r + ',' + g + ',' + b + ')';
        $( '#lectures' ).css( { backgroundColor: color } );
        if ( h < 1 ) {
            setTimeout( arguments.callee, 20 );
        }
    } )();
    $( '#everything, #cloud' ).animate( { 
        top: '-500px'
    }, { duration: SPEED } );
    document.body.style.overflow = 'hidden';
    $( '#sea' ).css( { height: '200px', bottom: '-100px' } ).animate( {
        bottom: $( window ).height() + 'px'
    }, { duration: SPEED, complete: function () {
        this.style.display = 'none';
        document.body.style.overflow = 'auto';
        $( 'body' ).css( { background: 'url( "images/bluebg.jpg" ) repeat fixed center center #1c1c2d' } );
    } } );
    $( '#lectures' ).show().css( {
        top: $( window ).height() + 'px'
    } ).animate( {
        top: '0px'
    }, { duration: SPEED, complete: function () {
        this.style.top = 0;
        this.style.bottom = 0;
    } } );
    return false;
};

$( 'a.lectures' ).click( function () {
    window.location.hash = '#lectures';
    window.onhashchange();
    return false;
} );

var lecturesToMain = function () {
    if ( $( '#everything' ).length === 0 ) {
        return true;
    }
    window.location.hash = '';
    
    var SPEED = 1000;
    var h = 0;
    
    ( function () {
        var start = [ 28, 28, 45 ]; // 1c1c2d
        var end = [ 0, 102, 255 ];
        var color, r, g, b;
        
        h += 50 / SPEED;
        if ( h > 1 ) {
            h = 1;
        }
        r = Tween( start[ 0 ], end[ 0 ], h );
        g = Tween( start[ 1 ], end[ 1 ], h );
        b = Tween( start[ 2 ], end[ 2 ], h );
        
        waveEnd = [ r, g, b ];
        
        color = 'rgb(' + r + ',' + g + ',' + b + ')';
        $( '#lectures' ).css( { backgroundColor: color } );
        if ( h < 1 ) {
            setTimeout( arguments.callee, 20 );
        }
    } )();
    $( '#everything' ).animate( { top: '0px' }, { duration: SPEED } );
    $( '#cloud' ).animate( {
        top: '5px'
    }, { duration: SPEED } );
    $( 'body' ).css( {
        background: 'none repeat fixed center center #86c9ef',
        overflow: 'hidden'
    } );
    $( '#sea' ).css( { display: '' } ).animate( {
        bottom: '-100px'
    }, { duration: SPEED, complete: function () {
        $( '#sea' ).css( { height: '100px', bottom: '0' } );
        document.body.style.overflow = 'auto';
    } } );
    $( '#lectures' ).show().css( {
        top: '0px'
    } ).animate( {
        top: $( window ).height() + 'px'
    }, { duration: SPEED, complete: function () {
        this.style.display = 'none';
    } } );
    return false;
};

$( $( '#lectures a.back' ) ).click( function () {
    window.location.hash = '#';
    window.onhashchange();
    return false;
} );

var navigating = false;

window.onhashchange = function () {
    setTimeout( function () {
        navigating = false;
    }, 50 );
    if ( navigating ) { return; }
    navigating = true;
    
    switch ( window.location.hash ) {
        case '#bibliography':
            mainToBibliography();
            break;
        case '#lectures':
            mainToLectures();
            break;
        case '#':
        case '':
            if ( $( '#lectures' )[ 0 ].style.display != 'none' ) {
                lecturesToMain();
            }
            else if ( $( '#bibliography' )[ 0 ].style.display != 'none' ) { 
                bibliographyToMain();
            }
    }
    // alert( window.location.hash );
};

window.onhashchange();
