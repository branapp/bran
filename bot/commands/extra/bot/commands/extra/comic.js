const { SlashCommandBuilder } = require('discord.js');

module.exports = {
	data: new SlashCommandBuilder()
		.setName('comic')
		.setDescription('Meow'),
	async execute(interaction) {
		await interaction.reply('im specile shork');
	},
};
