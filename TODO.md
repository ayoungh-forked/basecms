
-> nestedSortable: use native collapse methods, etc. Get serialize to work??


## DB and previews:

* Move RowObject to its own class file (same with exceptions?)

## Other stuff:

* USer and page records
* blog/news/etc. records
* Add a method for registering new autoloader locations.
 
* MD templates(?)
* Image sizing on demand
* tumblr module (get on request and cache locally(?)(synch too?))
* wikipedia module?

* /examples/
* $this->title();
* $this->description();
* $this->keywords();

* image sizing on demand.
 
 
* load site settings from the relevant site dir. site's own index.php should
* define a local $SITE_SETTINGS (or include() it with a base helper?) and the base index
* detect its presence.
 
* All requests should go to the local site's index.php, not Base's.

* Change references to 'routes', 'router', and 'routing' to 'maps', 'cartographer', and 'mapping'.

* email-based password attempts resetting

* Selfupdate capabilities, with git dependency?

