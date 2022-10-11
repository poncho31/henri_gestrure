import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */


import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

let MIX_APP_DEBUG = process.env.MIX_APP_DEBUG;
let MIX_APP_PORT = process.env.MIX_APP_PORT
let MIX_APP_HOST = MIX_APP_DEBUG === 'true' ? process.env.MIX_LARAVEL_WEBSOCKETS_HOST_DEV : process.env.MIX_LARAVEL_WEBSOCKETS_HOST_PROD;
let MIX_PUSHER_APP_KEY = process.env.MIX_PUSHER_APP_KEY;
let MIX_BROADCAST_DRIVER = process.env.MIX_BROADCAST_DRIVER;
let MIX_LARAVEL_WEBSOCKETS_PORT_DEV = process.env.MIX_LARAVEL_WEBSOCKETS_PORT_DEV;
let MIX_LARAVEL_WEBSOCKETS_PORT_PROD = process.env.MIX_LARAVEL_WEBSOCKETS_PORT_PROD;

let options_echo = {
    // BROADCAST DRIVER
    broadcaster: MIX_BROADCAST_DRIVER,
    key: MIX_PUSHER_APP_KEY,

    // APP HTTP HOST / PORT
    httpHost: MIX_APP_HOST,
    httpPort: MIX_APP_PORT,

    // APP STAT HOST / PORT
    stats_host: MIX_APP_HOST,
    stats_port: MIX_APP_PORT,

    // WBESOCKET HOST / PORT
    wsHost: MIX_APP_HOST,
    wsPort: MIX_APP_DEBUG === 'true'? MIX_LARAVEL_WEBSOCKETS_PORT_DEV:MIX_LARAVEL_WEBSOCKETS_PORT_PROD,

    // OTHER OPTIONS
    forceTLS: false,
    disableStats: false,
    enableStats: true,
    encrypted: true,
    transports: ['websocket', 'polling', 'flashsocket'],
    logToConsole: MIX_APP_DEBUG === 'true',
}
console.log('OPTIONS SET',options_echo)

Pusher.logToConsole = true;
window.Echo = new Echo(options_echo)
console.log('LARAVEL ECHO',window.Echo);
