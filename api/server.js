const express = require('express');
const { getUserData } = require('./actions/daily.js');
const app = express();

app.get('/', () => {
    getUserData().then(() => { });
});

let port = 3000;
app.listen(port, () => {
    console.log('Server is running on port 3000');
});