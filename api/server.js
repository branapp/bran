const express = require('express');
const bran = express();
const { exec } = require('child_process');
const { logger } = require('./logger.js');

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
    logger.info(`Ping endpoint hit at ${timestamp}`);
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
        logger.error(error);
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
        logger.error(error);
        res.status(500).send();
    }
});

bran.post('/update', (req, res) => {
    const branch = req.query.branch;

    if (!branch) {
        return res.status(400).send({ "message": "Missing branch parameter" });
    }

    const command = `git pull origin ${branch}`;

    exec(command, (error, stdout, stderr) => {
        if (error) {
            logger.error(`exec error: ${error}`);
            return res.status(500).send({ "message": "Error updating branch" });
        }

        logger.info(`stdout: ${stdout}`);
        logger.error(`stderr: ${stderr}`);

        res.status(200).send({ "message": "Branch updated" });
    });
});


let port = 1337;
bran.listen(port, () => {
    logger.info(`bran is listening on port ${port}`);
});