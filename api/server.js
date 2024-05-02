const express = require('express');
const app = express();

app.get('/', (req, res) => {
    res.status(418).send({
        message: 'not broken',
    });
});

app.get('/ping', (req, res) => {
    const timestamp = Date.now();
    res.status(200).send({
        message: 'pong',
        timestamp: timestamp,
    });
});

let port = 3000;
app.listen(port, () => {
    console.log('bran is listening on port ' + port);
});
