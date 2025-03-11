.. include:: /Includes.rst.txt


.. _rss-import-setup:

The external import setup
^^^^^^^^^^^^^^^^^^^^^^^^^

The import of a RSS feed into table :code:`tx_news_domain_model_news`
poses a particular challenge. We want to store the URI of the news
item in the related links table, which uses IRRE and a "parent" field
to relate links to news items.

We will see later what the trick is. The first important thing to
note is the order of import. Since it is links that are related to
news items, we must import news **before** links.

A second peculiarity is that both links and news items are in the
same source of data. Thus we will import the RSS feed twice.


.. _rss-import-setup-news:

Importing news items
""""""""""""""""""""

Thus we start with the news items. A new column was added to the
:code:`tx_news_domain_model_news` table. It is used to store the
external id found in the RSS feed.

Here is the setup for the general section:

.. code-block:: php

   $GLOBALS['TCA']['tx_news_domain_model_news']['external']['general'] = [
       0 => [
           'connector' => 'feed',
           'parameters' => [
               'uri' => 'https://typo3.org/?type=100'
           ],
           'data' => 'xml',
           'nodetype' => 'item',
           'referenceUid' => 'tx_externalimporttut_externalid',
           'enforcePid' => true,
           'priority' => 200,
           'group' => 'externalimport_tut',
           'disabledOperations' => 'delete',
           'description' => 'Import of typo3.org news'
       ],
   ];

Note that we don't use the same connector service as before. Indeed,
we now need the "feed" sub-type, which is provided by extension
"svconnector\_feed". This connector is specialized in getting XML data
from some source (remote or local), which is defined with the
:code:`uri` property inside the :code:`parameters` array.

Next, we declare that the data will be provided in XML format and that
the reference node type in "item". With this instruction, External
Import will take all nodes of type "item" and import each of them. The
:code:`enforcePid` property is set to :code:`true` so that the import
takes place only in the predefined page and that existing news items
entered somewhere else are not deleted. This is a useful precaution to
take.

Also note that the delete operation is disabled. This makes sense in
this case, as an RSS feed normally contains only the latest news
items. Thus if you don't want each import to delete the data from the
previous import, the delete operation should be disabled.

In the previous chapter, we said that we wanted to import only the news items
that are part of the "TYPO3 CMS" category. For this, we want to read the
:code:`<category>` tag, but not store it in the database. Thus we declare it as an
additional field:

.. code-block:: php

   $GLOBALS['TCA']['tx_news_domain_model_news']['external']['additionalFields'] = [
       0 => [
           'category' => [
               'xpath' => './category[text()=\'TYPO3 CMS\']',
               'transformations' => [
                   10 => [
                       'isEmpty' => [
                           'invalidate' => true
                       ]
                   ]
               ]
           ]
       ]
   ];

The "xpath" property makes it so that only items who have the following:

.. code-block:: xml

   <category>TYPO3 CMS</category>

will have a value in the "category" field. For all other records, it will be empty.
And thus we can filter by using the "isEmpty" transformation property. This property
tests whether a given value is empty or not. By default, it relies on the PHP
:code:`empty()` function, but it can also use the Symfony Expression Language for
more sophisticated conditions. In this case, we have declared nothing special, so
:code:`empty()` will be used. We then set the "invalidate" sub-property to :code:`true`,
meaning that records which have an empty value will be discarded from the imported
dataset. As a result, only items with the "TYPO3 CMS" category are imported.

Let's now look at the setup for the columns:

.. code-block:: php

   $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['title']['external'] = [
       0 => [
           'field' => 'title'
       ]
   ];
   $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['tx_externalimporttut_externalid']['external'] = [
       0 => [
           'field' => 'link',
           'transformations' => [
               10 => [
                   'trim' => true
               ]
           ]
       ]
   ];
   $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['datetime']['external'] = [
       0 => [
           'field' => 'pubDate',
           'transformations' => [
               10 => [
                   'userFunction' => [
                       'class' => \Cobweb\ExternalImport\Transformation\DateTimeTransformation::class,
                       'method' => 'parseDate'
                   ]
               ]
           ]
       ]
   ];
   $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['teaser']['external'] = [
       0 => [
           'field' => 'description',
           'transformations' => [
               10 => [
                   'trim' => true
               ]
           ]
       ]
   ];
   $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['bodytext']['external'] = [
       0 => [
           'field' => 'encoded',
           'transformations' => [
               10 => [
                   'userFunction' => [
                       'class' => \Cobweb\ExternalimportTut\Transformation\LinkTransformation::class,
                       'method' => 'absolutizeUrls',
                       'parameters' => [
                           'host' => 'https://typo3.org'
                       ]
                   ]
               ],
               20 => [
                   'rteEnabled' => true
               ]
           ]
       ]
   ];
   $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['type']['external'] = [
       0 => [
           'transformations' => [
               10 => [
                   'value' => 0
               ]
           ]
       ]
   ];
   $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['hidden']['external'] = [
       0 => [
           'transformations' => [
               10 => [
                   'value' => 0
               ]
           ]
       ]
   ];

For most of the fields, the setup is just as simple as if we were
importing database records, thanks to the connector services, which
have abstracted the tediousness of getting data in different formats.
However XML format allows for more complicated retrieval of data via
the use of XPath or attributes.

The only particular configuration above is for the "bodytext" field,
which uses the "rteEnabled" property to indicate that the content from
this field is rich text and RTE transformations should be applied upon
saving. This helps ensure that such content can be edited correctly in
a RTE-enabled field in the TYPO3 backend, although the varying quality
of available HTML makes it impossible to guarantee a 100% smooth
process.


.. _rss-import-setup-links:

Importing related links
"""""""""""""""""""""""

Next we want to run this import again, to store the links and make
them related to their respective news items. Here is the general
section for the :code:`tx_news_domain_model_link`:

.. code-block:: php

   $GLOBALS['TCA']['tx_news_domain_model_link']['external']['general'] = [
       0 => [
           'connector' => 'feed',
           'parameters' => [
               'uri' => 'https://typo3.org/?type=100'
           ],
           'data' => 'xml',
           'nodetype' => 'item',
           'referenceUid' => 'uri',
           'enforcePid' => true,
           'priority' => 210,
           'group' => 'externalimport_tut',
           'disabledOperations' => 'delete',
           'description' => 'Import of typo3.org news related links'
       ],
   ];

In this case we don't need to add a special field for storing
the external primary key, since we are using the URI and there
is already a field for this.

Now we face slight problem. We want to fill the "parent" column
with the primary key of the related news item, but that field has
no TCA. A field without TCA cannot be manipulated by External Import.
So we need to add a configuration for that field. As we don't need
anything special, we can just give it the
:ref:`passthrough <t3tca:columns-passthrough>` type.

Furthermore, we don't want to import all links. We want to import only those
links which are related to news that we actually imported (remember, that's
only those which are part of the "TYPO3 CMS" category). To ensure this, we
use two features:

#. In the "mapping" transformation, we use the sub-property "default" to ensure
   that the value after mapping is :code:`0` if no record was matched.

#. Then the next transformation is as above for news items, the "isEmpty"
   transformation with the "invalidate" sub-property set to :code:`true`.
   Since we ensured in the previous transformation that the value is :code:`0`
   when no parent record was matched, we can safely rely on the default use
   of the :code:`empty()` function.

So here is the complete setup, with the special bit highlighted:

.. code-block:: php
   :emphasize-lines: 17-41

   $GLOBALS['TCA']['tx_news_domain_model_link']['columns']['title']['external'] = [
       0 => [
           'field' => 'title'
       ]
   ];
   $GLOBALS['TCA']['tx_news_domain_model_link']['columns']['uri']['external'] = [
       0 => [
           'field' => 'link',
           'transformations' => [
               10 => [
                   'trim' => true
               ]
           ]
       ]
   ];
   $GLOBALS['TCA']['tx_news_domain_model_link']['columns']['parent'] = [
       'config' => [
           'type' => 'passthrough',
       ],
       'external' => [
           0 => [
               'field' => 'link',
               'transformations' => [
                   10 => [
                       'trim' => true
                   ],
                   20 => [
                       'mapping' => [
                           'table' => 'tx_news_domain_model_news',
                           'referenceField' => 'tx_externalimporttut_externalid',
                           'default' => 0
                       ]
                   ],
                   30 => [
                       'isEmpty' => [
                           'invalidate' => true
                       ]
                   ]
               ]
           ]
       ]
   ];


After running the import, check out the page/folder where the imported
news items are stored. It should look something like this:

.. figure:: ../../Images/ListViewOfNews.png
	:alt: The list view of imported news records

	Viewing the imported news records in the BE

