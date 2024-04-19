const { SlashCommandBuilder } = require('discord.js');

module.exports = {
	data: new SlashCommandBuilder()
		.setName('tyson')
		.setDescription('php man'),
	async execute(interaction) {
		await interaction.reply('Someone who can do php, and complains when people tell him to google his problems');
	},
};
