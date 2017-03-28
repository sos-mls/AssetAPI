Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"
  
  # Mentioning the SSH Username/Password:
  config.vm.boot_timeout = 100000000000
  config.vm.synced_folder "src/", "/var/www/assets_api", owner: "www-data", group: "www-data"
  config.vm.synced_folder "vagrant/", "/home/vagrant/install", owner: "vagrant", group: "vagrant"
  config.vm.synced_folder "sql/", "/home/vagrant/sql", owner: "vagrant", group: "vagrant"

  # Begin Configuring
  config.vm.define "assets_api" do|assets_api|
    assets_api.vm.hostname = "assetsapi.dev" # Setting up hostname
    assets_api.vm.network "private_network", ip: "192.168.201.71" # Setting up machine's IP Address
    assets_api.vm.provision :shell, path: "vagrant/install.sh" # Provisioning with script.sh
  end

  config.vm.provider :virtualbox do |vb|
    vb.gui = true
  end

  # End Configuring
end