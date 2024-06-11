#!/bin/sh

#On flush
iptables -F
#on bloque tout
iptables -P OUTPUT DROP
iptables -P INPUT DROP
iptables -P FORWARD DROP


#Ouverture du port SSH
iptables -A INPUT -p tcp --dport 22 -j ACCEPT

#Connexion deja etablie
iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
iptables -A OUTPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
iptables -A INPUT -m conntrack --ctstate ESTABLISHED,RELATED -j ACCEPT
iptables -A OUTPUT -m conntrack --ctstate ESTABLISHED -j ACCEPT

#Outaurisation du loopback
iptables -A INPUT -i lo -j ACCEPT
iptables -A OUTPUT -o lo -j ACCEPT

#Ouverture du port docker
iptables -A INPUT -i docker0 -j ACCEPT
iptables -I DOCKER -j ACCEPT
iptables -I DOCKER-USER -j ACCEPT


#Ouverture du port http  et HTTPS
iptables -A INPUT -p tcp --dport 80 -j ACCEPT
iptables -A INPUT -p tcp --dport 443 -j ACCEPT
iptables -A OUTPUT -p tcp --dport 80 -j ACCEPT
iptables -A OUTPUT -p tcp --dport 443 -j ACCEPT