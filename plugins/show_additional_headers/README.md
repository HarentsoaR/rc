**This plugin is not needed for versions >= 1.5 of roundcube, as the functionality was added by the developers!**

Roundcube allows to access multiple IMAP Server, but all mails have to be send over the same SMTP server.
This plugin allows to add multiple SMTP Server (one per IMAP Server) to Roundcube.

```php

// normal declaration of multiple IMAP Server
$config['default_host'] = array(
		'ssl://imap.example.de' => '.de',
		'ssl://mx.example.com' => '.com'
	);

// normal SMTP declaration
$config['smtp_server'] = 'tls://smtp.example.de' // unable to add the SMTP Server for mx.example.com

// new SMTP declaration using the plugin
$config['smtp_server'] = array(
	'imap.example.de' => 'tls://smtp.example.de',
	'mx.example.com' => 'ssl://mx.example.de'
	// IMAP Hostname => SMTP Hostname
	//	(if IMAP Hostname is not in list, we use first SMTP Server)
);

//	and activate the plugin by adding to:
$config['plugins'] = array( ....., 'multi_smtp');

```

## Install
Place the file `multi_smtp.php` in your installation at `/plugins/multi_smtp/multi_smtp.php`, edit the `config.inc.php`.