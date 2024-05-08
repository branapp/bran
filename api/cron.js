const cron = require('node-cron');

const { updateBranDaily } = require('./actions/recurring/daily');

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

module.exports = cron;