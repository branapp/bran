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

(async () => {
    try {
        // get data from the user_data table from the sql database
        const rows = await knex('user_data').select();
        const dataArray = rows.map((row) => {
            console.log(row);
            return { ...row };
        });
        return dataArray;
    } catch (error) {
        console.error(error);
        return [];
    }
})();
