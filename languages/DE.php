<?php

/**
 *
 * @category        page
 * @package         newsreader
 * @author          Robert Hase, Matthias Gallas, Dietrich Roland Pehlke (last)
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.12.x
 * @requirements    PHP 7.1 and higher
 * @version         0.3.10
 * @lastmodified    Jun 2019 
 *
 */

$MOD_NEWSREADER_TEXT = array(
	'RSS_URI' => 'RSS-URI',
	'CYCLE'	=> 'Update-Turnus',
	'LAST_UPDATED'	=> 'letzte Aktualisierung',
	'SHOW_IMAGE'	=> 'Logo anzeigen',
	'SHOW_DESCRIPTION'	=> 'Beschreibung anzeigen',
	'MAX_ITEMS'	=> 'max. Anzahl',
	'CODING'	=> 'Kodierung',
	'USE_UTF8_ENCODING'	=> "UTF-8 encoding benutzen",
	'Configuration'	=> 'Konfiguration',
	'Request'	=> 'Anforderung',
	'Resource'	=> 'Ressource',
	'Value'	=> 'Wert',
	'Description'	=> 'Beschreibung',
	'Image-URI'	=> 'Bild-URI',
	'Image-Title'	=> 'Bild-Title',
	'Image-Link'	=> 'Bild-Link',
	'Channel-Title'	=> 'Kanal-Title',
	'Channel-Desc'	=> 'Kanal-Description',
	'Channel-Link'	=> 'Kanal-Link',
	'PREVIEW'	=> 'Vorschau',
	'OWN_DATEFORMAT'	=> 'Eigenes Datumsformat',
	'RECORDS UNTOUCHED' => 'RSS spezifische Datens&auml;tze unber&uuml;hrt!'
);

$MOD_NEWSREADER_MSG = array(
	'RSS_URI'	=> 'Tragen Sie hier den Weblink zum Newsfeed ein. Bsp.: https://www.heise.de/newsticker/heise.rdf',
	'CYCLE'	=> 'Zeitraum in Sekunden, wann das Newsfeed aktualisiert werden soll. Sollte nicht weniger als 14400 Sek. (4 Std.) sein.',
	'LAST_UPDATED'	=> 'Zu diesem Zeitpunkt wurde das Newsfeed zuletzt aktualisiert.',
	'SHOW_IMAGE'	=> 'Wenn aktiviert, wird bei der News-Ausgabe das Logo angezeigt, das der Feed-Hersteller (evtl.) im Newsfeed angegeben hat.',
	'SHOW_DESCRIPTION'	=> 'Wenn aktiviert, werden bei den News-Eintr&auml;gen die Beschreibungen angezeigt (sofern vorhanden)',
	'MAX_ITEMS'	=> 'maximale Anzahl der angezeigten News-Eintr&auml;ge. In aller Regel enthalten Newsfeeds maximal 15 Eintr&auml;ge.',
	'CODING'	=> 'Kodierung eines Newsfeeds. Ist z.Bsp. das Newsfeed in UTF-8 kodiert und Ihre Website auf ISO-8859-1 eingestellt, w&auml;hlen Sie bitte bei "von" utf-8 und bei "zu" iso-8859-1 aus.',
	'USE_UTF8_ENCODING'	=> 'Optional utf-8 encoding benutzen - falls der Feed einen Parsing-Fehler produziert (z.B. <i>"An XML error occurred on line 22: not well-formed (invalid token)"</i>.',
	'OWN_DATEFORMAT'	=> 'Optonal eigenes Datumsformat f&uuml;r die Ausgabe. Beispiel: "%A - %e. %B %Y - %H:%M" <br />Details bei <a href="http://php.net/manual/de/function.strftime.php" target="_new">http://php.net/manual/de/function.strftime.php</a>.'
);

$MOD_NEWSREADER_HEAD = array(
	'CONFIG_DISPL'	=> 'Ausgabe der <u>gespeicherten</u> Konfiguration'
); 

$MOD_NEWSREADER_DESC = array(
	'Image-URI'	=> 'URI zum Newsfeed Bild/Logo',
	'Image-Title'	=> 'Titel des Newsfeed Bild/Logos',
	'Image-Link'	=> 'Link vom Newsfeed Bild/Logo. Meistens die URL der Newsfeed Website',
	'Channel-Title'	=> 'Titel des Newsfeeds',
	'Channel-Desc'	=> 'Beschreibung des Newsfeeds',
	'Channel-Link'	=> 'Link vom Newsfeed Titel. Meistens die URL der Newsfeed Website'
);
?>