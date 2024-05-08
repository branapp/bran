const express = require('express');
const bran = express();

// Require cron jobs
require('./cron');
const knex = require('./actions/creds');

// ping endpoint
bran.get('/', (req, res) => {
    const timestamp = new Date().toLocaleString('en-US');
    res.status(200).send({
        status: res.statusCode,
        message: 'pong',
        timestamp: timestamp,
    });
});

// user data endpoint
bran.get('/user/:username', async (req, res) => {
    try {
        const { username } = req.params;
        if (!username) {
            return res.status(400).send({ "message": "Missing username parameter" });
        }
        // Join users table with user_data table
        const user = await knex('users')
            .join('user_data', 'users.id', '=', 'user_data.user_id') // Assuming the related column is id in users table
            .where('users.username', username)
            .select('users.username', 'users.user_join', 'users.role', 'user_data.bran_total', 'user_data.bran_daily')
            .first();

        if (!user) {
            return res.status(404).send({
                "status": 404, "message": "User not found"
            });
        }
        res.status(200).send({ "response": user });
    } catch (error) {
        console.error(error);
        res.status(500).send();
    }
});

bran.get('/bran', async (req, res) => {
    try {
        const leaderboard = await knex('users')
            .join('user_data', 'users.id', '=', 'user_data.user_id')
            .orderBy('user_data.bran_total', 'desc')
            .select('users.username', 'user_data.bran_total');
        res.status(200).send({ "message": "bran leaderboard endpoint", "response": leaderboard });
    } catch (error) {
        console.error(error);
        res.status(500).send();
    }
});


let port = 3337;
bran.listen(port, () => {
    console.log('bran is listening on port ' + port);
});
