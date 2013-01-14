
* Admin: wire up history.pushState correctly for admin tabs, or do away with it altogether.
* fix broken admin tabs

# make humans.txt standards-compliant

## Other stuff:

* MD templates(?)
* Image sizing on demand
* tumblr module (get on request and cache locally(?)(synch too?))
* wikipedia module?

* autoload relevant page record for the current path (if it exists)

* image sizing on demand, suitable for CDN junk. (have a setting where copies aren't stored locally ever)

* page caching! 
 
* load site settings from the relevant site dir. site's own index.php should
* define a local $SITE_SETTINGS (or include() it with a base helper?) and the base index
* detect its presence.
 
* All requests should go to the local site's index.php, not Base's.

* email-based password attempts resetting
* password attempt lockouts
