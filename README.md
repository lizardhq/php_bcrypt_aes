# php_bcrypt_aes

PHP implementation of bcrypt wrapped in AES released under WTFPL

## Dependencies

* `ircmaxell/password_compat` if you're trapped in PHP < 5.5.0 Hell
* `defuse/php-encryption` because, let's face it, if you tried to roll your own it would be vulnerable and make Matasano a lot of money when a company used your shitty code
* Your ex, because you'll never quite get over them.

## What does this do?

### Encryption

First, it hashes your password with SHA-512.

Second, it Base-64 encodes the SHA-512 hash of your password.

Third, is passes the Base-64 encoded value to `password_hash()`.

Fourth, it encrypts the hash with a static key, which we hope you don't leak to an attacker.

### Decryption

First, decrypts the hash with the static key you provide.

Second, it hashes the password you're attempting with SHA-512.

Third, it Base-64 encodes the SHA-512 hash.

Fourth, it attempts to verify the Base-64 encoded value with `password_verify()`.

## Is this safe?

![i dunno lol](https://recodetech.files.wordpress.com/2015/03/855.gif?w=380&h=173)

Probably. It's free of the security issues mentioned [here](http://blog.ircmaxell.com/2015/03/security-issue-combining-bcrypt-with.html).

Additionally, we're using an encryption library that gets a lot of attention (more than can be said about ext/mcrypt anyway), so it's probably the safest choice we have in PHP land.

That also doesn't say much. Use at your own peril.
