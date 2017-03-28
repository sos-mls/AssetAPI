#!/bin/bash
# Installation process for Jenkins
# @link https://www.digitalocean.com/community/tutorials/how-to-install-and-use-jenkins-on-ubuntu-12-04
sudo su
# First Download Jenkins
wget -q -O - http://pkg.jenkins-ci.org/debian/jenkins-ci.org.key | apt-key add -

# Create a sources list
echo deb http://pkg.jenkins-ci.org/debian binary/ > /etc/apt/sources.list.d/jenkins.list

# Install Jenkins through apt-get
apt-get  -y --force-yes update
apt-get  -y --force-yes install jenkins

# Disable Security
sed -i 's/<useSecurity>true<\/useSecurity>/<useSecurity>false<\/useSecurity>/g' /var/lib/jenkins/config.xml
sed -i 's/<disableRememberMe>false<\/disableRememberMe>/<disableRememberMe>true<\/disableRememberMe>/g' /var/lib/jenkins/config.xml
sed -i '/<authorizationStrategy/,/<\/authorizationStrategy>/d' /var/lib/jenkins/config.xml
sed -i '/<securityRealm/,/<\/securityRealm>/d' /var/lib/jenkins/config.xml
service jenkins stop
nohup java -Djenkins.install.runSetupWizard=false -jar /usr/share/jenkins/jenkins.war &

# Install Plugins
# mkdir /var/lib/jenkins/plugins
cd /var/lib/jenkins/plugins

curl -O http://updates.jenkins-ci.org/download/plugins/ant/1.4/ant.hpi
curl -i -F file=ant.hpi http://jenkinshost/jenkins/pluginManager/uploadPlugin 
curl -O http://updates.jenkins-ci.org/download/plugins/checkstyle/3.47/checkstyle.hpi
curl -O http://updates.jenkins-ci.org/download/plugins/cloverphp/0.5/cloverphp.hpi
curl -O http://updates.jenkins-ci.org/download/plugins/config-file-provider/2.15.6/config-file-provider.hpi
curl -O http://updates.jenkins-ci.org/download/plugins/crap4j/0.9/crap4j.hpi
curl -O http://updates.jenkins-ci.org/download/plugins/dry-run/0.9/dry-run.hpi
curl -O http://updates.jenkins-ci.org/download/plugins/external-monitor-job/1.7/external-monitor-job.hpi
curl -O http://updates.jenkins-ci.org/download/plugins/git-client/2.2.1/git-client.hpi
curl -O http://updates.jenkins-ci.org/download/plugins/htmlpublisher/1.12/htmlpublisher.hpi
curl -O http://updates.jenkins-ci.org/download/plugins/jdepend/1.2.4/jdepend.hpi
curl -O http://updates.jenkins-ci.org/download/plugins/plot/1.9/plot.hpi
curl -O http://updates.jenkins-ci.org/download/plugins/sidebar-link/1.7/sidebar-link.hpi
curl -O http://updates.jenkins-ci.org/download/plugins/xunit/1.102/xunit.hpi

# chown -R jenkins:jenkins /var/lib/jenkins/plugins
# restart jenkins
curl -X POST http://127.0.0.1:8080/reload

curl -X POST -d '<jenkins><install plugin="http://updates.jenkins-ci.org/download/plugins/ant/1.4/ant.hpi" /></jenkins>' --header 'Content-Type: text/xml' http://localhost:8080/pluginManager/installNecessaryPlugins