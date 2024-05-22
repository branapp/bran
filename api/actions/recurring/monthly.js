const knex = require('../creds');

async function monthlyReset() {
    try {
        // Retrieve all user_data
        const rows = await knex('user_data').select();

        // Loop through each user
        for (const row of rows) {
            // Update bran_daily to 500
            await knex('user_data')
                .where({ user_id: row.user_id })
                .update({ bran_total: 0 });

            // Retrieve the username from the users table
            const user = await knex('users')
                .select('username')
                .where({ id: row.user_id })
                .first();

            // Print the update message with the username
            if (user && user.username) {
                console.log(`Reset bran_total for ${user.username}`);
            } else {
                console.log(`Reset bran_total for user_id ${row.user_id}`);
            }
        }
    } catch (error) {
        console.error(error);
    }
};

module.exports = { monthlyReset };
