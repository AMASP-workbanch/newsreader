<?php

/**
 *
 * @category        page
 * @package         newsreader
 * @author          Robert Hase, Matthias Gallas, Dietrich Roland Pehlke (last)
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.12.x
 * @requirements    PHP 7.1 and higher
 * @version         0.4.0
 * @lastmodified    Jun 2019 
 *
 */

namespace newsreader\languages;

class EN 
{
    //  ---- Part 1
    const RSS_URI           = "RSS-URI";
    const CYCLE             = "Update-Cycle";
    const LAST_UPDATED      = "last updated";
    const SHOW_IMAGE        = "show Logo";
    const SHOW_DESCRIPTION    = "show Description";
    const MAX_ITEMS         = "max. Items";
    const CODING            = "Coding";
    const USE_UTF8_ENCODING = "Use UTF-8 encoding";
    const Configuration     = "Configuration";
    const MOD_Request       = "Request";
    const MOD_Resource      = "Resource";
    const MOD_Value         = "Value";
    const MOD_Description   = "Description";
    const Image_URI         = "Image-URI";
    const Image_Title       = "Image-Title";
    const Image_Link        = "Image-Link";
    const Channel_Title     = "Channel-Title";
    const Channel_Desc      = "Channel-Description";
    const Channel_Link      = "Channel-Link";
    const PREVIEW           = "Preview";
    const OWN_DATEFORMAT    = "Own Dateformat";
    const RECORDS_UNTOUCHED = "RSS specific records untouched!";

    //  ---- Part 2
    const MSG_RSS_URI           = "Weblink to the Newsfeed. Example given: https://www.heise.de/newsticker/heise.rdf";
    const MSG_CYCLE             = "Actualization interval in seconds. Should not be smaller than 14400 Sec. (4 hours).";
    const MSG_LAST_UPDATED      = "Last actualization time of the Newsfeed.";
    const MSG_SHOW_IMAGE        = "If enabled, the Newsfeed logo will be displayed (if defined in the newsfeed).";
    const MSG_SHOW_DESCRIPTION  = "If enabled, the description of each news-item will be displayed (if included in the newsfeed)";
    const MSG_MAX_ITEMS         = "maximum numbers of news items to display. Normaly, newsfeeds have no more than 15 items.";
    const MSG_CODING            = "Coding of a Newsfeed. Sample: If the Newsfeed is UTF-8 coded and your Website is running with ISO-8859-1, please choose 'from' utf-8 and 'to' iso-8859-1.";
    const MSG_USE_UTF8_ENCODING = "Optional use of utf-8 encoding - if the feed gives an error like 'missformed'.";
    const MSG_OWN_DATEFORMAT    = "Optonal use of own format for the date-time string. E.g. %A - %e. %B %Y - %H:%M <br />Details: <a href='http://php.net/manual/en/function.strftime.php' target='_new'>http://php.net/manual/en/function.strftime.php</a>.";

    //  ---- Part 3
    const CONFIG_DISPL      = "Output of the <u>current</u> Configuration.";
    
    //  ---- Part 4
    const DESC_Image_URI        = "URI to the newsfeed image/logo";
    const DESC_Image_Title      = "Title of the newsfeed image/logo";
    const DESC_Image_Link       = "Link of the newsfeed image/logo. Mostly the URL of the newsfeed website";
    const DESC_Channel_Title    = "Title of the newsfeed";
    const DESC_Channel_Desc     = "Description of the newsfeed";
    const DESC_Channel_Link     = "Link of the newsfeed title. Mostly the URL of the newsfeed website";

}
