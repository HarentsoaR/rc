<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5da537f3fc523dc692a083c219621f01
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        '2cffec82183ee1cea088009cef9a6fc3' => __DIR__ . '/..' . '/ezyang/htmlpurifier/library/HTMLPurifier.composer.php',
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sabre\\VObject\\' => 14,
        ),
        'R' => 
        array (
            'RtfHtmlPhp\\' => 11,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Http\\Client\\' => 16,
        ),
        'M' => 
        array (
            'Masterminds\\' => 12,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
        'D' => 
        array (
            'DASPRiD\\Enum\\' => 13,
        ),
        'B' => 
        array (
            'BaconQrCode\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sabre\\VObject\\' => 
        array (
            0 => __DIR__ . '/..' . '/sabre/vobject/lib',
        ),
        'RtfHtmlPhp\\' => 
        array (
            0 => __DIR__ . '/..' . '/roundcube/rtf-html-php/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-factory/src',
            1 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Http\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-client/src',
        ),
        'Masterminds\\' => 
        array (
            0 => __DIR__ . '/..' . '/masterminds/html5/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'DASPRiD\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/dasprid/enum/src',
        ),
        'BaconQrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/bacon/bacon-qr-code/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'R' => 
        array (
            'Roundcube\\Composer' => 
            array (
                0 => __DIR__ . '/..' . '/roundcube/plugin-installer/src',
            ),
        ),
        'N' => 
        array (
            'Net' => 
            array (
                0 => __DIR__ . '/..' . '/pear/net_smtp',
                1 => __DIR__ . '/..' . '/pear/net_socket',
            ),
        ),
        'M' => 
        array (
            'Mail' => 
            array (
                0 => __DIR__ . '/..' . '/pear/mail_mime',
            ),
        ),
        'H' => 
        array (
            'HTTP_Request2' => 
            array (
                0 => __DIR__ . '/..' . '/pear/http_request2',
            ),
            'HTMLPurifier' => 
            array (
                0 => __DIR__ . '/..' . '/ezyang/htmlpurifier/library',
            ),
        ),
        'C' => 
        array (
            'Console' => 
            array (
                0 => __DIR__ . '/..' . '/pear/console_commandline',
                1 => __DIR__ . '/..' . '/pear/console_getopt',
            ),
            'Caxy\\HtmlDiff' => 
            array (
                0 => __DIR__ . '/..' . '/caxy/php-htmldiff/lib',
            ),
        ),
        'A' => 
        array (
            'Auth' => 
            array (
                0 => __DIR__ . '/..' . '/pear/auth_sasl',
            ),
        ),
    );

    public static $fallbackDirsPsr0 = array (
        0 => __DIR__ . '/..' . '/pear/pear-core-minimal/src',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Crypt_GPG' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG.php',
        'Crypt_GPGAbstract' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPGAbstract.php',
        'Crypt_GPG_BadPassphraseException' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Exceptions.php',
        'Crypt_GPG_DeletePrivateKeyException' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Exceptions.php',
        'Crypt_GPG_Engine' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Engine.php',
        'Crypt_GPG_Exception' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Exceptions.php',
        'Crypt_GPG_FileException' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Exceptions.php',
        'Crypt_GPG_InvalidKeyParamsException' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Exceptions.php',
        'Crypt_GPG_InvalidOperationException' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Exceptions.php',
        'Crypt_GPG_Key' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Key.php',
        'Crypt_GPG_KeyGenerator' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/KeyGenerator.php',
        'Crypt_GPG_KeyNotCreatedException' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Exceptions.php',
        'Crypt_GPG_KeyNotFoundException' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Exceptions.php',
        'Crypt_GPG_NoDataException' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Exceptions.php',
        'Crypt_GPG_OpenSubprocessException' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Exceptions.php',
        'Crypt_GPG_PinEntry' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/PinEntry.php',
        'Crypt_GPG_ProcessControl' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/ProcessControl.php',
        'Crypt_GPG_ProcessHandler' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/ProcessHandler.php',
        'Crypt_GPG_Signature' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/Signature.php',
        'Crypt_GPG_SignatureCreationInfo' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/SignatureCreationInfo.php',
        'Crypt_GPG_SubKey' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/SubKey.php',
        'Crypt_GPG_UserId' => __DIR__ . '/..' . '/pear/crypt_gpg/Crypt/GPG/UserId.php',
        'Net_LDAP2' => __DIR__ . '/..' . '/pear/net_ldap2/Net/LDAP2.php',
        'Net_LDAP2_Entry' => __DIR__ . '/..' . '/pear/net_ldap2/Net/LDAP2/Entry.php',
        'Net_LDAP2_Error' => __DIR__ . '/..' . '/pear/net_ldap2/Net/LDAP2.php',
        'Net_LDAP2_Filter' => __DIR__ . '/..' . '/pear/net_ldap2/Net/LDAP2/Filter.php',
        'Net_LDAP2_LDIF' => __DIR__ . '/..' . '/pear/net_ldap2/Net/LDAP2/LDIF.php',
        'Net_LDAP2_RootDSE' => __DIR__ . '/..' . '/pear/net_ldap2/Net/LDAP2/RootDSE.php',
        'Net_LDAP2_Schema' => __DIR__ . '/..' . '/pear/net_ldap2/Net/LDAP2/Schema.php',
        'Net_LDAP2_SchemaCache' => __DIR__ . '/..' . '/pear/net_ldap2/Net/LDAP2/SchemaCache.interface.php',
        'Net_LDAP2_Search' => __DIR__ . '/..' . '/pear/net_ldap2/Net/LDAP2/Search.php',
        'Net_LDAP2_SimpleFileSchemaCache' => __DIR__ . '/..' . '/pear/net_ldap2/Net/LDAP2/SimpleFileSchemaCache.php',
        'Net_LDAP2_Util' => __DIR__ . '/..' . '/pear/net_ldap2/Net/LDAP2/Util.php',
        'Net_LDAP3' => __DIR__ . '/..' . '/kolab/net_ldap3/lib/Net/LDAP3.php',
        'Net_LDAP3_Result' => __DIR__ . '/..' . '/kolab/net_ldap3/lib/Net/LDAP3/Result.php',
        'Net_Sieve' => __DIR__ . '/..' . '/pear/net_sieve/Sieve.php',
        'Net_URL2' => __DIR__ . '/..' . '/pear/net_url2/Net/URL2.php',
        'PEAR_Exception' => __DIR__ . '/..' . '/pear/pear_exception/PEAR/Exception.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5da537f3fc523dc692a083c219621f01::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5da537f3fc523dc692a083c219621f01::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit5da537f3fc523dc692a083c219621f01::$prefixesPsr0;
            $loader->fallbackDirsPsr0 = ComposerStaticInit5da537f3fc523dc692a083c219621f01::$fallbackDirsPsr0;
            $loader->classMap = ComposerStaticInit5da537f3fc523dc692a083c219621f01::$classMap;

        }, null, ClassLoader::class);
    }
}
