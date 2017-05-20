Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"
  
  # Mentioning the SSH Username/Password:
  config.vm.boot_timeout = 100000000000
  config.vm.synced_folder "src/", "/var/www/asset_api", owner: "www-data", group: "www-data"
  config.vm.synced_folder "vagrant/", "/home/vagrant/install", owner: "vagrant", group: "vagrant"
  config.vm.synced_folder "sql/", "/home/vagrant/sql", owner: "vagrant", group: "vagrant"

  # Begin Configuring
  config.vm.define "asset_api" do|asset_api|
    asset_api.vm.hostname = "assetapi.dev" # Setting up hostname
    asset_api.vm.network "private_network", ip: "192.168.201.71" # Setting up machine's IP Address
    asset_api.vm.provision :shell, path: "vagrant/install.sh" # Provisioning with script.sh
  end

  config.vm.provider :virtualbox do |vb|
    vb.gui = true
  end

  config.vm.post_up_message = "You can access Asset Api at http://192.168.201.71"

  # End Configuring
end