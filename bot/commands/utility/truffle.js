const { SlashCommandBuilder } = require('discord.js');

module.exports = {
	data: new SlashCommandBuilder()
		.setName('truffle')
		.setDescription('bwa'),
	async execute(interaction) {
		await interaction.reply('https://truffle.signed.host/J7tUA.jpeg');
	},
};
