.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _rss-import-data:

The data to import
^^^^^^^^^^^^^^^^^^

Here's an excerpt of the file (of course, the exact content will vary,
since news keep being added to the feed):

.. code-block:: xml
   :emphasize-lines: 17-28

	<?xml version="1.0" encoding="utf-8"?>
	<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
		<channel>
			<title>typo3.org: Latest News</title>
			<link>http://typo3.org</link>
			<description>Latest news from typo3.org</description>
			<language>en</language>
			<image>
				<title>typo3.org: Latest News</title>
				<url>http://typo3.org/clear.gif</url>
				<link>http://typo3.org</link>
				<description>Latest news from typo3.org</description>
			</image>
			<generator>TYPO3 - get.content.right</generator>
			<docs>http://blogs.law.harvard.edu/tech/rss</docs>
			<lastBuildDate>Tue, 03 Jun 2014 13:45:00 +0200</lastBuildDate>
			<item>
				<title>Cross-Site Scripting in news</title>
				<link>http://typo3.org/news/article/cross-site-scripting-in-news/</link>
				<description>It has been discovered that the extension &quot;News system&quot; (news) is susceptible to Cross-Site Scripting</description>
				<content:encoded>
					<![CDATA[<div><strong>Release Date:</strong> June 3, 2014</div>
					...
					]]>
				</content:encoded>
				<author>security@typo3.org</author>
				<pubDate>Tue, 03 Jun 2014 13:45:00 +0200</pubDate>
			</item>
		</channel>
	</rss>

The part in which we are really interested has been highlighted: we
want to import the various entries of the RSS feed, which correspond
to the :code:`<item>` tag.

