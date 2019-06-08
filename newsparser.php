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

/********************************************************************

a little bit modified from Robert Hase, adm_prg[AT]muc-net.de, 2005
 Class: RSS_feed

 Author: Dr. Timothy Sakach (Version 2.0.0)
 
 This script will parse a RSS/XML file that comes from a URL feed.
 It will return an HTML unordered list.

**********************************************************************
Version 2.0.2
HISTORY:
	2005-05-30, RHase, adm_prg[AT]muc-net.de: output changed (HTML tags)
	2005-06-04, RHase, adm_prg[AT]muc-net.de: output splitted (channel, content)
********************************************************************** 

 Getting a feed from another web site, should be quick and simple. Any
 unneeded complications should be avoided. One feed processor from a
 large Content Management System written in PHP nearly got me kicked 
 off my server. It ran wild with overly complex coding and included 
 opening hundreds of objects in a loop and used the XML-DOM (ugh!).

 This is far simpler, faster and more reliable.

 There are several versions of RSS/RDF. However, in practical use
 most all feed implementations follow the same pattern: A publication link is
 contained within <item> tags and consists of a <title>, <link>, and
 a <description>. We tested feeds from many different sources using
 all flavors and versions and this class was able to parse all of them.

 Granted there are many options with version 1.0 (RDF). However,  
 the full RDF syntax and vocabulary are not needed in a feed. 
 All of the implementations we found that included RDF tags 
 really added very little to the feed and  were safely ignored. 

 Version 2.0 extends versions 0.9x by adding new tags. This presented
 no problems and this class can be extended to process those tags. But 
 our goal was to provide a simple solution that can easily add syndicated
 publications to any web site.

  Changes: by Dr. Timothy Sakach
  1. 8/31/03 Corrected bug because the description tag (and all other tags, for that
     matter} can occur in any sequence within the container tags. 
  2. 8/31/03 Corrected bug created by the way the XML parser returns parsed cdata.
  3. 8/31/03 Added Set_Limit property to control the number of links to show.
  4. 8/31/03 Added image control and Show_Image property.
  5. 8/31/03 Channel, Image, and Items now use arrays as buffers.

********************************************************************/

class RSS_feed {
	// The object of the parser is to determine the "State" of the RSS/XML
	// and set up the class to respond accordingly. The critical information
	// is in the _handle_character_data function as that is where the 
	// feed information can be found.

	public $flag;      // To control the state of the unordered list
	public $state;     // To determine which element tag is being worked
	public $level;     // Simple XML level control
	public $output;    // Where the results will be stored
	public $showdesc;  // A flag to indicate whether or not to show the description.
	public $showimage; // A flag to indicate whether or not to show the image.
	public $URL;       // The location of the external feed.
	public $psr;       // Our parser object.
	public $contents;  // The RSS/XML from the feed
	public $rss_version; // Stores version "number"
	public $limit;     // The maximum number of links we want
	public $channel;   // Array of channel cdata
	public $image;     // Array of image cdata
	public $item;      // Array of item cdata
	public $channelclosed; // To indicate state if channel closes before image tags.
	public $error = "";		// Public property for "last" error-messages, e.g. 'unable to connect the host at http://www.abc.xx'.
	
	//	Constructor
	public function __construct() {
		
		$this->output = "";
		$this->channel = array();
		$this->image = array();
		$this->item = array();
		$this->flag = false;
		$this->state = 0;
		$this->level = 0;
		$this->showdesc = false;
		$this->showimage = false;
		$this->channelclosed = false;
		$this->version = 9;   // set 0.9x as default;
		$this->limit = 0;   // use 0 as default == all
	}
	
	// METHODS AND PROPERTIES *****************************************

	public function Show_Description($tf) {
		// By default the description is not included in the results
		// This public function allows for the description to be
		// included, if desired.
		if (!$tf === false) {
			$this->showdesc = true;
		} else {
			$this->showdesc = false;
		}
	}

	public function Show_Image($tf) {
		// By default the image is not included in the results
		// This allows for the image to be included, if desired.
		if (!$tf === false) {
			$this->showimage = true;
		} else {
			$this->showimage = false;
		}
	}

	public function Set_URL($url) {
		// This is the URL to the feed. The class expects that RSS/XML will
		// be returned.
		$this->URL = $url;
		
		// Knowing this, we can get the feed contents now.
		// Get the RSS/XML from the feed URL
		$this->_load_file();
		
		if ($this->error != "") return false;
		
		// Check the version of the XML and set the version state
		$this->_get_rss_version();
		
		return true;
	}

	public function Set_Limit($cnt) {
		// This property sets the limit of links to return
		// if $cnt is not numeric, 0 is returned! You get the entire list!
		$i = intval($cnt);
		if ($i > 0) $this->limit = $i;
	}

	public function Get_Results( $use_utf8_encode=0 ) {
		// When the properties have been set, then this function should
		// be called. It will return the HTML unordered list.
		$c = ($use_utf8_encode == 0) ? $this->contents : utf8_encode($this->contents);
		// Create the parser and set handlers.
		$this->psr = xml_parser_create();
		xml_set_object($this->psr, $this);
		xml_parser_set_option($this->psr,XML_OPTION_CASE_FOLDING,1);
		
		// Set the parser element handlers based upon the version.
		switch ($this->version) {
			case 9:
			case 2;
			xml_set_element_handler($this->psr, '_handle_open_element', '_handle_close_element');
			break;
			case 1:
			xml_set_element_handler($this->psr, '_rdf_handle_open_element', '_handle_close_element');
			break;
		}

		// Set the handler for the cdata
		xml_set_character_data_handler($this->psr, "_handle_character_data");
		
		// Parse it.
		if (!xml_parse ($this->psr, $c)) {
			// This returns an error message if the RSS/XML cannot be parsed. 
			// Too bad.
			// This indicates a bad or malformed feed!
			$ln =  xml_get_current_line_number($this->psr);
			$msg =  xml_error_string(xml_get_error_code($this->psr));
			return "[np 12] An XML error occurred on line ".$ln.": ".$msg;
		}
		
		// Free up the parser and clear memory
		xml_parser_free($this->psr);
		$this->contents = "";
		
		// Close the list and return the results
		$this->output .= "\t</ul>\n";
		return $this->output;
	}

	//**************************************************************
	
	// HANDLER FUNCTIONS
	private function _handle_open_element (&$p, &$element, &$attributes) {
		// parser for rss version 0.9x and 2.0
		// Set the state of the class for the benefit of the cdata handler.
		$element = strtolower($element);
		switch($element) {
			case 'rss':
			// data at this level may not be needed
			$this->level = 0;
			$this->state = 0;
			break;
			
			case 'channel':
			// The channel may have a title and a link and a description
			// This data will not be part of the list, but will precede it.
			$this->flag = true;
			$this->level = 1;
			$this->state = 1;
			break;
			
			case 'item':
			// We have an item to process
			$this->level = 3;
			$this->state = 3;
			break;
			
			// some tags that will appear under 'channel'
			// for now, ignore these tags. 
			case 'pubdate':
			case 'managingeditor':
			case 'webmaster':
			case 'width':
			case 'height':
			case 'language':
			$this->state = 99;
			break;
			
			case 'image':
			// This assumes the image is a container element, as this is most common
			$this->level = 2;
			break;
			
			case 'title':
			$this->state = 4;
			break;
			
			case 'link':
			$this->state = 5;
			break;
			
			case 'description':
			$this->state = 6;
			break;
			
			case 'url':
			$this->state = 7;
			break;
			
			default:
			// ignore any undefined tags
			$this->state = 99;
			break;
		}
	}

	private function _rdf_handle_open_element(&$p, &$element, &$attributes) {
		// RDF mixes things up a bit so we need to pay attention
		// However, when you get right down to it. There may be
		// no difference in the RDF feed other than more stuff to
		// ignore.
		$element = strtolower($element);
		
		// Include Dublin Core tags and full RDF specs? 
		// Nah!
		switch($element) {
			case "rdf:rdf":
			// The parser takes care of the Namespace, so we can ignore this.
			$this->level = 0;
			$this->state = 0;
			break;
			
			case "channel":
			// Same as above.
			$this->flag = true;
			$this->level = 1;
			$this->state = 1;
			break;
			
			case "image":
			// Assumes <image> is a container element. This is most common.
			$this->level = 2;
			break;
			
			case "items":
			// channel parameters stop and items begin. We can ignore this.
			$this->state = 99;
			break;
			
			case "item":
			// We have an item to process.
			$this->level = 3;
			$this->state = 3;
			break;	
			
			case "title":
			$this->state = 4;
			break;
			
			case "link":
			$this->state = 5;
			break;
			
			case "description":
			$this->state = 6;
			break;
			
			case "url":
			$this->state = 7;
			break;
			
			// These next two are somewhat redundant, unless strict RDF format is followed.
			// Ho hum ...
			// We will ignore them.
			case "rdf:seq":
			case "rdf:li":
			default:
			// ignore tags
			$this->state = 99;
			break;
		}
	}

	private function _handle_character_data(&$p, &$cdata) {
		/* 
		This function is trivialized in many examples. However, this is
		where the real action lies. We have set the state of the class in order 
		to determine what we should do with cdata. 
		
		Changes had to be made here because the PHP parser, under special conditions
		would parse the data in the elements and return it in pieces. This showed
		up when the <title> contained &apos; or &quot; 
		
		This function only accumulates $cdata text in arrays.
		*/
		
		// Ignore $cdata filled with blanks or nothing
		$s = trim($cdata);
		if (strlen($s)) {
			// We really only need these things now: Title, Links and, if desired, Description and Image URL
			if(!isset($this->channel['title'])) $this->channel['title'] = "";
			if(!isset($this->channel['link'])) $this->channel['link'] = "";
			if(!isset($this->channel['desc'])) $this->channel['desc'] = "";
			
			if(!isset($this->image['title'])) $this->image['title'] = "";
			if(!isset($this->image['link'])) $this->image['link'] = "";
			if(!isset($this->image['url'])) $this->image['url'] = "";
			
			if(!isset($this->item['title'])) $this->item['title'] = "";
			if(!isset($this->item['link'])) $this->item['link'] = "";
			if(!isset($this->item['desc'])) $this->item['desc'] = "";
			
			switch ($this->state) {
				case 4:  // title
				switch ($this->level) {
					// This are the only levels that are important here.
					case 1:	// Channel
					$this->channel["title"] .= $cdata;
					break;
					case 2; // Image
					if($this->image["title"] == '') {
						$this->image["title"] = $cdata;
					}
					break;
					case 3:  // Item
					$this->item["title"] .= $cdata;
					break;
				}
				break;
				
				case 5:  // link
				switch ($this->level) {
					case 1: // Channel
					// Make the link for the channel and change to item level. We're done here.
					$this->channel["link"] .= $cdata;
					break;
					case 2: // Image
					$this->image["link"] = $cdata;
					break;
					case 3: // Item
					// Make the link for the item. Reset the flag and initialize the unordered list.
					// Add the link for the item
					$this->item["link"] .= $cdata;
					break;
				}
				break;
				
				case 6:  // description
				// If the description is desired, add it now.
				if ($this->showdesc) {
					switch ($this->level) {
						case 1: // Channel
						$this->channel["desc"] .= $cdata;
						break;
						case 3: // Item
						$this->item["desc"] .= $cdata;
						break;
					}
				}
				break;
				
				case 7: // Image url
				if ($this->showimage) {
					switch ($this->level) {
						case 2: // Image
						$this->image["url"] .= $cdata;
						break;
					}
				}
				break;
			}
		}
	}

	private function _handle_close_element(&$p, &$element) {
		// Closing elements for all versions.
		// Because the elements can appear in orders differing from each other
		// the output is now created at the close of each of the critical elements.
		$element = strtolower($element);
		static $cnt;
		switch ($element) {
			case 'channel':  // major elements -- define closing event
			// put channel information on the top. This should work even if the channel close element
			// occurs before the item tags
			$this->channelclosed = true;
			break;
			case 'item':
			// Each item has its own close element
			if ($this->flag) {
				// Initialize item list
				$this->output .= "\n\t<ul>\n";
				$this->flag = false;
				$cnt = 0;
			}
			if ($this->limit > $cnt || !$this->limit) {
				$this->output .= "\t\t" . '<li><a href="' . $this->item["link"] . '" title="' . $this->item["link"] . '" target="_blank">' . $this->item["title"] . '</a>';
				if ($this->showdesc) {
					$this->output .= "\n\t\t\t" .'<div class="nr_itemdesc">' . $this->item["desc"] . '</div>';
				}
				$this->output .= "</li>\n";
				if ($this->limit > 0) $cnt++;
			}
			$this->item["link"] = "";
			$this->item["title"] = "";
			$this->item["desc"] = "";
			break;
			default: // ignore all other close elements
			break;
		}
	}

	private function _load_file() {
		// Get the raw feed from the URL. Because this uses a URL as the feed source
		// it can be used to process an RSS/XML feed from any web site, including local.
		
		$ch = curl_init() or die("<b>Error:</b> Could not init cURL!");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 0);		// !
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		
		// curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // 1
		// curl_setopt($ch, CURLOPT_POSTREDIR, 3); // 2
		
		curl_setopt($ch, CURLOPT_URL, $this->URL);
		$this->contents = curl_exec($ch);
		// echo var_dump( $this->contents );
		if (false === $this->contents) {
			$this->error = "<b>Error</b>: ".curl_error($ch);
		}
		
		curl_close($ch);
	}

	private function _get_rss_version() {
		// Set the version state
		if (strpos($this->contents,'version="0.9'))  {
			$this->rss_version = 9;
		} elseif (strpos($this->contents,"rdf:")) {
			$this->rss_version = 1;
		} elseif (strpos($this->contents,'version="2.0"')) {
			$this->rss_version = 2;
		}
	}

}  // end of class

?>