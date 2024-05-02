#!/bin/bash
echo "bran setup wizard"
read -p "Enter the install path (default: /var/www): " install_path
# sets default to /var/www
install_path=${install_path:-/var/www}
read -p "Enter branch: 1=production, 2=develop (default: production): " branch
branch=${branch:-production}
if [[ $branch == 2 ]]; then
    branch="develop"
fi
read -p "Create systemd services? (y/n): " systemd_create
if [[ $systemd_create == "y" ]]; then
    systemd_create=true
else
    systemd_create=false
fi
clear
echo "beginning installation process"
sleep 1
# check for LAMP stack
echo "checking for a LAMP stack..."
sleep 1
if ! command -v apache2 >/dev/null 2>&1 || ! command -v mysql >/dev/null 2>&1 || ! command -v php >/dev/null 2>&1; then
    sleep 1
    echo "LAMP stack is not installed. Installing..."
    sudo apt update
    sudo apt install apache2 mysql-server php -y
else
    echo "LAMP stack is already installed."
    sleep 1
fi
clear
# check for npm
echo "checking for npm..."
sleep 1
if ! command -v npm >/dev/null 2>&1; then
    echo "npm is not installed. Installing..."
    sudo apt install npm -y
else
    echo "npm is already installed."
    sleep 1
fi
sleep 1
clear
echo "installing bran to $install_path from the $branch branch. please wait..."
sleep 1

cd $install_path
git clone https://github.com/tysonlmao/bran.git || { echo "Failed to switch to clone repository. Is bran already installed?"; exit 1; }
git switch $branch
clear
echo "bran cloned successfully"
sleep 2
clear

echo "installing dependancies and configuring..."
cd bran
touch bran-config.php
chown www-data:www-data bran-config.php
chmod 600 bran-config.php
sleep 1
cd api
npm install
echo "npm packages installed"
cd ..
sleep 2

clear
if [[ $systemd_create == true ]]; then
    echo "creating systemd services..."
    sudo tee /etc/systemd/system/bran-api.service > /dev/null <<EOF
[Unit]
Description=Bran API

[Service]
ExecStart=/usr/bin/node $install_path/bran/api/server.js
WorkingDirectory=$install_path/bran/api
Restart=always
User=www-data
Group=www-data
Environment=NODE_ENV=production

[Install]
WantedBy=multi-user.target
EOF
clear
sudo systemctl enable bran-api
sudo systemctl start bran-api
fi

chown -R www-data:www-data $install_path/bran
echo "installation complete"
