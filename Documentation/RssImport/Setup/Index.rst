.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _rss-import-setup:

The external import setup
^^^^^^^^^^^^^^^^^^^^^^^^^

First of all, please note that a new column was added to the
tx\_news\_domain\_model\_news table. It will be used to store the
external id found in the RSS feed.

Now here's the setup for the "ctrl" section:

.. code-block:: php

	$GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['external'] = array(
		0 => array(
			'connector' => 'feed',
			'parameters' => array(
				'uri' => 'http://typo3.org/xml-feeds/rss.xml'
			),
			'data' => 'xml',
			'nodetype' => 'item',
			'reference_uid' => 'tx_externalimporttut_externalid',
			'enforcePid' => TRUE,
			'disabledOperations' => 'delete',
			'description' => 'Import of typo3.org news'
		),
	);

Note that we don't use the same connector service as before. Indeed,
we now need the "feed" sub-type, which is provided by extension
"svconnector\_feed". This connector is specialized in getting XML data
from some source (remote or local), which is defined with the
:code:`uri` property inside the :code:`parameters` array.

Next, we declare that the data will be provided in XML format and that
the reference node type in "item". With this instruction, External
Import will take all nodes of type "item" and import each of them. The
:code:`enforcePid` property is set to :code:`TRUE` so that the import
takes place only in the predefined page and that existing news items
entered somewhere else are not deleted. This is a useful precaution to
take.

Also note that the delete operation is deleted. This makes sense in
this case, as an RSS feed normally contains only the latest news
items. Thus if you don't want each import to delete the data from the
previous import, the delete operation should be disabled.

Let's now look at the setup for the columns:

.. code-block:: php

	$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['title']['external'] = array(
		0 => array(
			'field' => 'title'
		)
	);
	$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['tx_externalimporttut_externalid']['external'] = array(
		0 => array(
			'field' => 'link'
		)
	);
	$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['datetime']['external'] = array(
		0 => array(
			'field' => 'pubDate',
			'userFunc' => array(
				'class' => 'EXT:external_import/samples/class.tx_externalimport_transformations.php:tx_externalimport_transformations',
				'method' => 'parseDate'
			)
		)
	);
	$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['teaser']['external'] = array(
		0 => array(
			'field' => 'description',
			'trim' => TRUE
		)
	);
	$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['bodytext']['external'] = array(
		0 => array(
			'field' => 'encoded',
			'rteEnabled' => TRUE
		)
	);
	$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['ext_url']['external'] = array(
		0 => array(
			'field' => 'link',
		)
	);
	$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['type']['external'] = array(
		0 => array(
			'value' => 0
		)
	);
	$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['hidden']['external'] = array(
		0 => array(
			'value' => 0
		)
	);

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

After running the import, check out the page/folder where the imported
news items are stored. It should look something like this:

.. figure:: ../../Images/ListViewOfNews.png
	:alt: The list view of imported news records

	Viewing the imported news records in the BE

