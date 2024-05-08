const cron = require('node-cron');

const { updateBranDaily } = require('./actions/recurring/daily');

/**
 * Daily cron job to update bran_daily
 */
cron.schedule('0 0 * * *', async () => {
    console.log('Running cron job to update bran_daily');
    updateBranDaily().then(() => {
        console.log('Finished running cron job to update bran_daily');
    }).catch(error => {
        console.error('Failed to run cron job to update bran_daily', error);
    });
}, {
    scheduled: true,
});

/**
 * Monthly cron job to reset monthly values
 */
cron.schedule('0 0 1 * *', async () => {
    console.log('Running cron job to reset monthly values');
    monthlyReset().then(() => {
        console.log('Finished running cron job to reset monthly values');
    }).catch(error => {
        console.error('Failed to run cron job to reset monthly values', error);
    });
}, {
    scheduled: true,
});

module.exports = cron;