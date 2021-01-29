/* resource */

/*

u - user agent
h - browser
o - OS
i - IP address
c - country
t - time (epoch)
z - time since entering site
a - account

*/


function send(u,h,o,i,c,t,a)
{
    $.post("/api/v1/batchImpression",
    {"batch": {
        u: u,
        h: h,
        o: o,
        i: i,
        c: c,
        t: t,
        a: a
    }},
    function(result){
        // ok
    });
}