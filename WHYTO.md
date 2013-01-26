# Why BaseCMS?

BaseCMS is designed to allow you to deploy new sites with a working CMS very simply. There's a lot of boilerplate built in, but there is a lot of stuff that isn't included. The philosophy is somewhat 'bare necessities', where 'necessary' includes the requirement to not have to reinvent the content management system wheel for sites that just need the basics of pages, blogs, news, and all that jazz.

This isn't a Model-View-Controller framework. (There are a lot of those, and better ones, and I'm personally more of a fan of the ones in Ruby and Python anyway.) It also doesn't include a seperate templating language. PHP does that pretty well on its own, although some Mako-inspired methods have been added here to allow for easier reuse of things like keeping headers and footers in a single wrapper template. The code structure of the site is also designed to reflect the URL structure, more or less, which means that URL to template mapping, though present, isn't required.

Personally, I envision this as a basis for small to medium page-based sites that need to be managed by a first or second party: a kind of freelancer's starting point, for when Wordpress or similar is just too much.

Bug reports and interesting feature requests (even if they fall outside the scope described here) should be submitted on the github repository, at [https://github.com/petronius/basecms//].
