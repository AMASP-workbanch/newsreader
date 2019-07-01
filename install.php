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
 * @lastmodified    Jul 2019 
 *
 */


if(defined('WB_URL'))
{
    require_once __DIR__."/classes/system/preload.php";
    newsreader\system\preload::initialize();

    newsreader\system\queries::create(
        TABLE_PREFIX."mod_newsreader",
        "(
            `section_id`    int(11) NOT NULL DEFAULT '0',
            `page_id`       int(11) NOT NULL DEFAULT '0',
            `uri`           varchar(255) NOT NULL DEFAULT '',
            `show_image`    int(1) NOT NULL DEFAULT '1',
            `show_desc`     int(1) NOT NULL DEFAULT '1',
            `show_limit`    int(2) NOT NULL DEFAULT '15',
            `cycle`         int(5) NOT NULL DEFAULT '0',
            `last_update`   int(14) NOT NULL DEFAULT '0',
            `content`       text NOT NULL,
            `ch_title`      varchar(255) NOT NULL DEFAULT '',
            `ch_link`       varchar(255) NOT NULL DEFAULT '',
            `ch_desc`       varchar(255) NOT NULL DEFAULT '',
            `img_title`     varchar(255) NOT NULL DEFAULT '',
            `img_uri`       varchar(255)  NOT NULL DEFAULT '',
            `img_link`      varchar(255) NOT NULL DEFAULT '',
            `coding_from`   varchar(100) NOT NULL DEFAULT '',
            `coding_to`     varchar(100) NOT NULL DEFAULT '',
            `use_utf8_encode`   int(11) NOT NULL DEFAULT '0',
            `own_dateformat`    varchar(100) NOT NULL DEFAULT '',
            PRIMARY KEY ( `section_id` )
        )",
        false,
        true
    );
    
    // Insert info into the search table
    // Module query info
    $field_info = [
        'page_id'   => 'page_id',
        'title'     => 'page_title',
        'link'      => 'link',
        'description'   => 'description',
        'modified_when' => 'modified_when',
        'modified_by'   => 'modified_by'
    ];
    
    $field_info = serialize($field_info);

    newsreader\system\queries::insert(
        TABLE_PREFIX."search",
        [   "name"  => "module",
            "value" => "newsreader",
            "extra" => $field_info
        ]
    );
    
    // Query start
    newsreader\system\queries::insert(
        TABLE_PREFIX."search",
        [   "name"  => "query_start",
            "value" => "SELECT [TP]pages.page_id, [TP]pages.page_title, [TP]pages.link, [TP]pages.description, [TP]pages.modified_when, [TP]pages.modified_by FROM [TP]mod_newsreader, [TP]pages WHERE ",
            "extra" => "newsreader"
        ]
    );
   
    // Query body
    newsreader\system\queries::insert(
        TABLE_PREFIX."search",
        [   "name"  => "query_body",
            "value" => " [TP]pages.page_id = [TP]mod_newsreader.page_id AND [TP]mod_newsreader.content [O] \'[W][STRING][W]\' AND [TP]pages.searching = \'1\'",
            "extra" => "newsreader"
        ]
    );

    // Query end
    newsreader\system\queries::insert(
        TABLE_PREFIX."search",
        [   "name"  => "query_end",
            "value" => "",
            "extra" => "newsreader"
        ]
    );
}

?>