function Tween( start, end, h ) {
    return start + Math.floor( ( end - start ) * h );
}

var WIDTH = document.body.offsetWidth;
var HEIGHT = 100;

var canvas = document.getElementsByTagName( "canvas" )[ 0 ];

canvas.width = WIDTH;

if ( typeof canvas.getContext == 'undefined' ) {
    // no canvas support
    // return;
}

var surface = canvas.getContext( "2d" );
var NUM_SNOWBALLS = 50;

surface.beginPath();
surface.fillStyle = 'snow';
surface.moveTo( 0, HEIGHT );
y = HEIGHT / 2;
v = 0;
a = 0;
for ( var x = 0; x <= WIDTH + 50; x += 10 ) {
    a = 1 - Math.random() * 2;
    if ( y < HEIGHT / 4 ) {
        a = Math.abs( a );
        if ( v < -10 ) {
            v = -10;
        }
        if ( y < 0 ) {
            v = 1;
        }
    }
    else if ( y > HEIGHT * 3 / 4 ) {
        a = -Math.abs( a );
        if ( v > 10 ) {
            v = 10;
        }
        if ( y > HEIGHT ) {
            v = -1;
        }
    }
    v += a;
    y += v;
    surface.lineTo( x, y );
}
surface.lineTo( WIDTH, HEIGHT );
surface.fill();

for ( i = 0; i < NUM_SNOWBALLS; ++i ) {
    snowball = document.createElement( 'div' );
    snowball.innerHTML = '•';
    snowball.style.position = 'fixed';
    snowball.mass = Math.ceil( 10 + Math.random() * 12 );
    snowball.style.fontSize = snowball.mass + 'pt';
    snowball.posx = Math.floor( Math.random() * WIDTH );
    snowball.posy = Math.floor( Math.random() * $( window ).height() );
    snowball.style.color = 'white';
    snowball.className = 'snowball';
    
    setInterval( ( function ( which ) {
        return function () {
            which.posy += which.mass / 8;
            which.posx += 2;
            which.style.left = which.posx + 'px';
            which.style.top = which.posy + 'px';
            if ( which.posx > WIDTH || which.posy > $( window ).height() ) {
                which.posy = -50;
                which.posx = Math.floor( Math.random() * ( WIDTH + 500 ) - 500 );
            }
        };
    } )( snowball ), 30 );
    
    document.body.appendChild( snowball );
}
