Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"
  
  # Mentioning the SSH Username/Password:
  config.vm.boot_timeout = 100000000000
  config.vm.synced_folder "src/", "/var/www/skeleton", owner: "www-data", group: "www-data"
  config.vm.synced_folder "vagrant/", "/home/vagrant/install", owner: "vagrant", group: "vagrant"
  config.vm.synced_folder "sql/", "/home/vagrant/sql", owner: "vagrant", group: "vagrant"

  # Begin Configuring
  config.vm.define "skeleton" do|skeleton|
    skeleton.vm.hostname = "skeleton.net" # Setting up hostname
    skeleton.vm.network "private_network", ip: "192.168.201.70" # Setting up machine's IP Address
    skeleton.vm.provision :shell, path: "vagrant/install.sh" # Provisioning with script.sh
  end

  config.vm.provider :virtualbox do |vb|
    vb.gui = true
  end

  # End Configuring
end