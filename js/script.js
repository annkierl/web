console.log('Dzialam!');

(function (arg1, arg2) {
    let time;
    let frequency = 1000; //ms

    let body = document.getElementsByTagName('body')[0];

    body.addEventListener('mousemove', handleMouseMove);

    function handleMouseMove(event) {
        let currentTime = Date.now();

        if(currentTime - (time || 0) < frequency) {
            return;
        }

        console.log('x:', event.pageX, 'y:', event.pageY);
        time = currentTime;
    }
})();

