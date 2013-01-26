# BaseCMS

This is a PHP content management system and lightweight framework. The main goal is to try to build something that works with, not agains, the native features of PHP as much as possible (and where it makes sense to do so), while adding functionality for more slightly more sophisticated templating features and request handling. 

BaseCMS is also meant to allow you to serve multiple sites from a common code base, where it is not necessary or desirable to have each site as a standalone app with their own versions of the boilerplate code. After the initial installation, setting up new sites should be trivial.

# Requirements

This project makes use of some of the newer features of PHP, and was written using **PHP 5.3**. Earlier versions will probably not work.

<!-- describe module requirements -->

## Things other than PHP

While the PHP code itself has been written in a manner that should allow it to work on any platform, there are some additional extras that may not work without some modification. (Pull requests for cross-platform fixes, particularly Windows, would be heartily welcomed.)

Specifically, the default post-processor function that takes a final formatting pass at generated HTML is a Bash script that relies on **[http://www.python.org/](Python)** and **[http://www.crummy.com/software/BeautifulSoup/](BeautifulSoup 4)**. This feature can be turned off, or the function itself can be overridden if you would like it to behave differently.

In addition, the default setup assumes MySQL, but it uses PHP's own PDO module, so [https://petronius.github.com/basecms/database/](adapting it for use) with another database should be trivial.

In addition to the post-processing script, there are several small utility scripts written in Bash that rely on POSIX standards like sed. Broadly speaking, this should work as is on any sane, up-to-date version of Linux (although stable Debian releases may require you to upgrade from the versions available in the default repos).

# Documentation

See [https://petronius.github.com/basecms/] for more information about installing and using BaseCMS. Note that installation instructions will focus on Linux, with Lighttpd as the webserver, because that is my setup. Contributions for alternate platforms and webservers will be accepted gladly.
