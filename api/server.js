const express = require('express');
const bran = express();

// Require cron jobs
require('./cron');
const knex = require('./actions/creds');

bran.get('/', (req, res) => {
    res.status(418).send({
        message: 'not broken',
    });
});

// ping endpoint
bran.get('/ping', (req, res) => {
    const timestamp = new Date().toLocaleString('en-US');
    res.status(200).send({
        status: res.statusCode,
        message: 'pong',
        timestamp: timestamp,
    });
});

let port = 3337;
bran.listen(port, () => {
    console.log('bran is listening on port ' + port);
});
