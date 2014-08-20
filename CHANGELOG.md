Changelog
=========

1.2.0-RC1
---------

* **2014-06-06**: Updated to PSR-4 autoloading

1.1.0
-----

Release 1.1.0

1.1.0-RC2
---------

* **2014-04-11**: drop Symfony 2.2 compatibility

1.1.0-RC1
---------

* **2014-03-24**: [PHPCR-ODM Documents] setParent() and getParent() are now
  deprecated. Use setParentDocument() and getParentDocument() instead.
  When using Sonata Admin, enable the ChildExtension from the CoreBundle.

1.0.1
-----

* **2013-11-26**: Improve json/xml output when params contain a single variable

1.0.0-RC3
---------

* **2013-09-02**: Removed __toString() method
* **2013-09-01**: Adopt schema.org RDFa mapping

1.0.0-RC1
---------

* **2013-07-29**: Removed dedicated entity for Multilang. Multilang is now
  supported by default. All additional features are now bundled in the
  StaticContent document, and core functionality is in StaticContentBase.
* **2013-07-28**: [DependencyInjection] moved phpcr specific configuration
  under `persistence.phpcr`.
