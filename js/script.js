"use strict";
console.log('Dzialam!');

(function (arg1, arg2) {

    let time = Date.now();
    let frequency = 1000; //ms

    let host_url = 'analytics';

    let user_id = new String(time).slice(-6) + Math.floor(Math.random() * 100);

    function postAjax(data, success) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', `${host_url}/${user_id}`);
        xhr.onreadystatechange = function() {
            if (xhr.readyState>3 && xhr.status==200) { success(xhr.responseText); }
        };
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify(data));
        return xhr;
    }

    let body = document.getElementsByTagName('body')[0];
    body.addEventListener('mousemove', handleMouseMove);

    function handleMouseMove(event) {
        let currentTime = Date.now();
        let data;

        if(currentTime - (time || 0) < frequency) {
            return;
        }

        data = {
            'mouse_move': [event.pageX, event.pageY],
            'data_sent_time': currentTime
        };

        postAjax(data, function(response_text){
            console.log('Analytics Sent!', response_text);
        });

        time = currentTime;
    }

})();

