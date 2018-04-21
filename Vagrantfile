# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box = "SharkLinux/Bionic"
  config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"
  config.vm.network "public_network"
  config.vm.synced_folder "./", "/vagrant", type: "virtualbox", id: "vagrant-root", owner: "vagrant", group: "www-data", mount_options: ["dmode=775,fmode=775"]

  config.vm.provider "virtualbox" do |vb|
     vb.memory = "1024"
  end

  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    sudo apt install php7.2 php7.2-cli php7.2-pgsql php7.2-json php7.2-intl php7.2-xml php7.2-zip php-xdebug
    sudo apt install git composer
  SHELL
end
