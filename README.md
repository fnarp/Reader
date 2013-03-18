A PHP web-based feed reader implemented as a reaction to the closure of
Google Reader. This is not a clone, but let's say it's "heavily inspired
by" the Google Reader interface.

As of 2013-03-18 this isn't exactly production ready, but I'm releasing
it here so you can play with it.

![The reader interface follows some of the same conventions of Google Reader](/usercontent/screenshot.png)

Features
========
Features include:

* AJAX interface (utilising progressive enhancement).
* OPML Import.
* Favicon & touch icon support for a splash of colour.
* Multi-user interface (this may be flaky yet).

Features that I am not interested in, but you can have a crack at if you
want:
* Google Reader API compatibility. (I don't use this myself, and it looks like a fair bit of work.)

Technology
==========
This project uses:

* [CodeIgniter](http://ellislab.com/codeigniter/)
* [SimplePie](http://simplepie.org) for reed parsing and related goodies. 
* [Bootstrap](http://twitter.github.com/bootstrap/) For style and scaffolding.
* [simple_html_dom](http://simplehtmldom.sourceforge.net/) For HTML parsing & manipulation.
* [ag_auth](https://github.com/adamgriffiths/ag-auth) For authentication.

Setup
=====
To set up this app you will need to:

1. Prepare a database and create an application/config/database.php file. See application/config/database.sample.php
2. Make the usercontent/*icons folders writeable.
3. Visit example.org/register and create an account for yourself.
4. Create your first folder with the "create a folder" button. (This is important, because presently you can't add feeds at the root level.)
5. That's it. Probably, I think.

Feedback
========
Please feel free to add feedback on existing functionality via Github
Issues. Simplarly, pull requests are especially welcome.
