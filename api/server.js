const express = require('express');
const app = express();

app.get('/', (req, res) => {
    res.send({ "message": "why are you here" });
});

let port = 3000;
app.listen(port, () => {
    console.log('Server is running on port 3000');
});
