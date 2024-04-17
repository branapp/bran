const { createLogger, format, transports } = require('winston');
const path = require('path');

const logsFolder = path.join(__dirname, '..', 'logs'); // Assumes 'logs' is the folder name

const logger = createLogger({
    level: 'info',
    format: format.combine(
        format.timestamp(),
        format.printf(info => `[${info.timestamp}] [${info.level.toUpperCase()}]: ${info.message}`)
    ),
    transports: [
        new transports.Console(),
        new transports.File({ filename: path.join(logsFolder, 'error.log'), level: 'error' }),
        new transports.File({ filename: path.join(logsFolder, 'combined.log') }),
    ],
});

function logError(message, error) {
    if (error && error.stack) {
        logger.error(`${message}: ${error.stack}`);
    } else if (error && error.message) {
        logger.error(`${message}: ${error.message}`);
    } else {
        logger.error(message);
    }
}

module.exports = { logger, logError };
