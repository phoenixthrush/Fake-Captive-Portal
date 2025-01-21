#!/usr/bin/env bash

set -x

## Enable IP forwarding (if routing to eth0 for internet)
# sudo sysctl -w net.ipv4.ip_forward=1

## Set wlan0 address
sudo ip addr add 192.168.10.1/24 dev wlan0 2> /dev/null

## Flush all rules for wlan0
sudo iptables -D INPUT -i wlan0 -j DROP 2> /dev/null
sudo iptables -D OUTPUT -o wlan0 -j DROP 2> /dev/null
sudo iptables -D FORWARD -i wlan0 -j DROP 2> /dev/null

## Block all other traffic on wlan0
sudo iptables -A INPUT -i wlan0 -j DROP
sudo iptables -A OUTPUT -o wlan0 -j DROP
sudo iptables -A FORWARD -i wlan0 -j DROP

## Allow traffic to the captive portal webserver
sudo iptables -A INPUT -i wlan0 -p tcp --dport 8080 -j ACCEPT
sudo iptables -A OUTPUT -o wlan0 -p tcp --sport 8080 -j ACCEPT

## Enable NAT if forwarding internet via eth0
# sudo iptables --t nat -A POSTROUTING -o eth0 -j MASQUERADE

## Restart hostapd and dnsmasq (assuming they are configured)
sudo systemctl restart hostapd dnsmasq

## Serve the captive portal
php -S 192.168.10.1:8080
