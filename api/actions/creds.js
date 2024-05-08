const config = require('../config.json');

const knex = require('knex')({
    client: 'mysql',
    connection: config.database
});

module.exports = knex;

// if called directly, just checks connection
async function checkConnection() {
    try {
        await knex.raw('SELECT 1+1 AS result');
        console.log('Database connection successful');
    } catch (error) {
        console.error('Database connection failed:', error);
    }
}
checkConnection();