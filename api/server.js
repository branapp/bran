const express = require('express');
const bran = express();

bran.get('/', (req, res) => {
    res.status(418).send({
        message: 'not broken',
    });
});

// ping endpoint
bran.get('/ping', (req, res) => {
    const timestamp = Date.now();
    res.status(200).send({
        status: res.statusCode,
        message: 'pong',
        timestamp: timestamp,
    });
});

let port = 4567;
bran.listen(port, () => {
    console.log('bran is listening on port ' + port);
});