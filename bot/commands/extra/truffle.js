const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');

module.exports = {
	data: new SlashCommandBuilder()
		.setName('truffle')
		.setDescription('bwa'),
	async execute(interaction) {
		const truffle = new EmbedBuilder()
	.setColor('#c900ff')
	.setTitle('Truffle')
	.setDescription('Bwa')
	.setImage('https://truffle.signed.host/J7tUA.jpeg')
	.setTimestamp()
		await interaction.reply({ embeds: [truffle] });
	},
};
