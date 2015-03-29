<?php
namespace LizardHQ\Security;

class PasswordLock
{
    /**
     * 1. Hash password using bcrypt-base64-SHA512
     * 2. Encrypt-then-MAC the hash
     *
     * @param string $password
     * @param string $aesKey - must be 16 bytes
     * @return string
     */
    public static function hashAndEncrypt($password, $aesKey)
    {
        if (self::safeStrlen($aesKey) !== 16) {
            throw new \Exception("Use a 16 byte key, numbnuts!");
        }
        return \Crypto::encrypt(
            \password_hash(
                \base64_encode(\hash('sha512', $password, true)),
                PASSWORD_DEFAULT
            ),
            $aesKey
        );
    }

    /**
     * 1. VerifyHMAC-then-Decrypt the ciphertext to get the hash
     * 2. Verify that the password matches the hash
     *
     * @param string $password
     * @param string $ciphertext
     * @param string $aesKey - must be 16 bytes
     * @return boolean
     */
    public static function decryptAndVerify($password, $ciphertext, $aesKey)
    {
        if (self::safeStrlen($aesKey) !== 16) {
            throw new \Exception("Use a 16 byte key, numbnuts!");
        }
        $hash = \Crypto::decrypt(
            $ciphertext,
            $aesKey
        );
        return \password_verify(
            \base64_encode(\hash('sha512', $password, true)),
            $hash
        );
    }

    /**
     * Momma says mbstring.func_overload is the devil
     *
     * @param string
     * @return int
     */
    private static function safeStrlen($str)
    {
        if (\function_exists('\\mb_strlen')) {
            return \mb_strlen($str, '8bit');
        }
        return \strlen($str);
    }
}
