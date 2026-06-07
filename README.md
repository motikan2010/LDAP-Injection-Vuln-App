# LDAP-Injection-Vuln-App
### What's LDAP Injection
[LDAP injection](https://en.wikipedia.org/wiki/LDAP_injection)

### Introduction
#### Run LDAP Server
```
$ docker run -p 389:389 --name openldap-container --detach osixia/openldap:latest
```

#### Run LDAP Client
```
$ docker build -t ldap-client-container .
$ docker run -dit --link openldap-container -p 8888:80 ldap-client-container


```
