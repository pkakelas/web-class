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

function Tween( start, end, h ) {
    return start + Math.floor( ( end - start ) * h );
}

var waveStart = [ 0, 0, 80 ];
var waveEnd = [ 0, 102, 255 ];

function getColor( h ) {
    var color = 'rgb('
            + Tween( waveStart[ 0 ], waveEnd[ 0 ], h ) + ','
            + Tween( waveStart[ 1 ], waveEnd[ 1 ], h ) + ','
            + Tween( waveStart[ 2 ], waveEnd[ 2 ], h )
            + ')';
    if ( h == 1 ) {
        return 'rgb(28, 28, 45)';
    }
    return color;
}

function tanh( x ) {
    return ( Math.exp( x ) - Math.exp( -x ) ) / ( Math.exp( x ) + Math.exp( -x ) );
}

var t = 0;

function Render() {
    var WIDTH = document.body.offsetWidth;
    var HEIGHT = 200;
    var NUMWAVES = 8;
    var X_RESOLUTION = 4;
    var TIME_RESOLUTION = 1;
    
    t += TIME_RESOLUTION;
    
    if ( typeof window.nativeCanvas !== 'undefined' && window.nativeCanvas == false ) {
        // no native canvas support; we gotta make less waves
        NUMWAVES = 3;
        X_RESOLUTION = 20;
        TIME_RESOLUTION = 2;
    }
    var WAVEWIDTH = HEIGHT / NUMWAVES + 1;

    var canvas = document.getElementsByTagName( "canvas" )[ 0 ];
    canvas.width = WIDTH;
    if ( typeof canvas.getContext == 'undefined' ) {
        // no canvas support
        return;
    }
    
    var surface = canvas.getContext( "2d" );
    var y = 0, prevy = 0;

    for ( var wave = 0; wave < NUMWAVES; ++wave ) {
        surface.fillStyle = getColor( wave / ( NUMWAVES - 1 ) );
        surface.beginPath();
        surface.moveTo( 0, HEIGHT );
        for ( var x = -WAVEWIDTH; x < WIDTH + WAVEWIDTH; x += X_RESOLUTION ) {
            y = f( x, t, wave );
            surface.lineTo( x, y );
        }
        surface.lineTo( WIDTH, HEIGHT );
        surface.fill();
    }

    function f( x, t, h ) {
        var velocity = ( h / 2 + 1 ) * Math.pow( -1, h ) * 0.05;
        var OMEGA = 0.025 * Math.sin( ( h + 2 ) * t / 1000 );
        var AMPLITUDE = 10; // 10 * Math.sin( 1 + Math.sin( ( h + 1 ) / 10 ) * t / 1000 );
        var OFFSET = AMPLITUDE + 10 + ( 1 + h ) * ( WAVEWIDTH / 2 );
        var xprime = ( velocity / OMEGA ) * t + x;

        return AMPLITUDE * Math.sin( xprime * OMEGA ) + OFFSET;
    }
    setTimeout( Render, TIME_RESOLUTION * 20 );
}
setTimeout( Render, 20 );
