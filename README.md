# LDAP-Injection-Vuln-App

### What's LDAP Injection
[LDAP injection](https://en.wikipedia.org/wiki/LDAP_injection)

## Using

#### 1. Run LDAP Server

```
$ docker run -p 389:389 --name openldap-container --detach osixia/openldap:latest
```

#### 2. Run LDAP Client

```
$ docker build -t ldap-client-container .
$ docker run -dit --link openldap-container -p 8888:80 ldap-client-container
```

#### 3. Add user

```sh
ldapadd -x -H ldap://localhost \
  -D "cn=admin,dc=example,dc=org" -w admin <<'EOF'
dn: cn=admin,dc=example,dc=org
objectClass: simpleSecurityObject
objectClass: organizationalRole
cn: admin
description: LDAP administrator
userPassword: {SSHA}gDcXiuBDtwlCpFymQ8Akh7ObEMHdUO7K
EOF
```
