## NewsReader
Pagemodule to handel XML and RDF/RSS (0.9x, 1.0, 2.0) newsfeeds for WBCE/WebsiteBaker.

### Preface
Just an old module, started by Robert Hase about 2005 for WebsiteBaker.  
_Nothing more, nothing less._

## Notice: 0.4.0.0 is still under construction!

#### Require
- PHP >= 7.2.x
- WBCE 1.3.3 (1.4.0)
- WebsiteBaker 2.12.0 (2.12.2 recommended)

#### Installation
##### WB (2.12.0 - 2.12.2)
Download the zip-archiv - extract the files and place them into the "modules" folder and use "namual install in the BE.  
_At this time there is no other way, as during the installation via zip the "info.php" is parsed by WB, not "executed|loaded"._  

#### WBCE (1.3.3 - 1.4.0)
Download the zip and install via backend, or download the zip, extract it and use "manual install" in the BE.

#### Customize
##### for frontend
place a copy of the ~view.lte inside
```code  
[frontendtemplate]/frontend/newsreader/view.lte
```
and modify as you needed.

##### for backend/theme
place a copy of the ~modify.lte inside
```code  
[backendtheme]/backend/newsreader/modify.lte
```
and make your individual changes/adjustments.

#### Tests
Tested on
- WBCE 1.3.3 (1.4.0) with PHP 7.3.1
- WB 2.12.2 with PHP 7.3.1

