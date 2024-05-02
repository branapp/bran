const knex = require('knex')({

    'client': 'mysql',
    'connection': {
        // in future dont store these in plain text. nonononoon
        'host': 'localhost',
        'user': "sammy",
        'password': "sexmaster9000",
        'database': "brandb",
    }
});

async function getUserData() {
    try {
        // get data from the user_data table from the sql database
        const rows = await knex('user_data').select();
        dataArray = rows.map((row) => {
            return { ...row };
        });
        return dataArray;
    } catch (error) {
        console.error(error);
    }
}

module.exports = getUserData;
