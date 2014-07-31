#!/bin/bash

key="31d860f7-6f7f-48d3-97b3-8407d5083f34"
hostname=$(curl -s http://169.254.169.254/latest/user-data | json.sh | grep -m1 '\["hostname"\]' | awk '{print $2}' | sed 's/"//g')
pip=$(curl -s http://169.254.169.254/latest/meta-data/public-ipv4)
iid=$(curl -s http://169.254.169.254/latest/meta-data/instance-id)

postdata="hostname=${hostname}&pip=${pip}&iid=${iid}&key=${key}"
curl -u "nagios:abc123" -sk -d ${postdata} http://nagios.361way.com/nagios3/cgi-bin/updatecfg.php
