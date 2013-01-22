
# make humans.txt standards-compliant

## Other stuff:

* Image sizing on demand

* autoload relevant page record for the current path (if it exists)
* on page save, rebuild a table of page paths for easy lookup

* image sizing on demand, suitable for CDN junk. (have a setting where copies aren't stored locally ever)

* page caching! 
 
* load site settings from the relevant site dir. site's own index.php should
* define a local $SITE_SETTINGS (or include() it with a base helper?) and the base index
* detect its presence.
 
* All requests should go to the local site's index.php, not Base's.

* email-based password attempts resetting
* password attempt lockouts

* Convert menu lists to tables for records, blog, and users.
