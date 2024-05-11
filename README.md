# Omni + SimpleSAMLphp

[Omni](https://www.siderolabs.com/platform/saas-for-kubernetes/) authentication is based on either integration with [Auth0](https://auth0.com/) or with a SAML identity provider. This represents a relatively high entry barrier for self-hosting/homelabs that don't want to use an external IdP (Auth0) and either don't know how or want to configure a SAML IdP.

Both [Authentik](https://goauthentik.io/) and [Keycloak](https://www.keycloak.org/) are powerful and popular IdPs with self-hosting/homelabers but require substantial time and effort to deploy and setup if you're only doing this to use Omni.

The Omni Slack channel has multiple message requesting that Omni add support for "Internal Auth" and while the wonderful folks at [Sidero Labs](https://www.siderolabs.com/) have indicated that this is on their roadmap, it is yet to be implemented.

This repo provides a [compose](https://docs.docker.com/compose/) file that bundles Omni with [SimpleSAMLphp](https://simplesamlphp.org/) a super light weight IdP and only requres you to perform a few simple steps to get Omni running. This is probably the closest thing one can get to "Internal Auth" until Omni adds support for it.

## Instructions

1. Clone this repo
2. Generate a **RSA** TLS certificate using [acme.sh](https://github.com/acmesh-official/acme.sh), [certbot](https://certbot.eff.org/), or your favorite ACME client

    a. The certificate must be an **RSA** certificate. I got errors with SimpleSAMLphp when using **ECC** certificates

    b. Save the generated certificate and key files in the [certificate](https://github.com/sherif-fanous/omni-simple-saml-php/tree/main/certificate) directory. If you save them in a different directory them make sure you change the corresponding `bind mount` values for both the `omni` and `simplesamlphp` containers in the [compose](https://github.com/sherif-fanous/omni-simple-saml-php/blob/main/docker-compose.yaml) file

    c. Make sure the key file permissions allow reading by all users `chmod 644 tls.key`. This is required because the `SimpleSAMLphp` container is running Apache server, which uses user `www-data` to read the key file.

3. Follow the instructions [here](https://omni.siderolabs.com/docs/how-to-guides/how-to-deploy-omni-on-prem/#create-etcd-encryption-key) to create the etcd key

    Save the generated `omni.asc` in this repo's root directory. If you save the generated `omni.asc` in a different directory then make sure you change the corresponding `bind mount` value for the `omni` container in the [compose](https://github.com/sherif-fanous/omni-simple-saml-php/blob/main/docker-compose.yaml) file

4. Fill the missing values in the [.env](https://github.com/sherif-fanous/omni-simple-saml-php/blob/main/.env) file
5. Start the compose file

    ```console
    docker compose up
    ```

6. Browse to Omni. This is the value of the `OMNI_FQDN` environment variable in your .env file
7. If you're not already logged in, Omni will redirect you to SimpleSAMLphp
8. Log in to SimpleSAMLphp using the values of `OMNI_USER_USERNAME` and `OMNI_USER_PASSWORD` in your .env file
9. On successful login SimpleSAMLphp will redirect you back to Omni
