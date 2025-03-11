.. include:: /Includes.rst.txt


.. _rss-import-data:

The data to import
^^^^^^^^^^^^^^^^^^

Here's an excerpt of the file (of course, the exact content will vary,
since news keep being added to the feed):

.. code-block:: xml
   :emphasize-lines: 22-59

   <?xml version="1.0" encoding="utf-8"?>
   <rss version="2.0"
       xmlns:content="http://purl.org/rss/1.0/modules/content/"
       xmlns:atom="http://www.w3.org/2005/Atom"
       xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
       xmlns:n="http://typo3.org/ns/GeorgRinger/News/ViewHelpers">
      <channel>
         <title>Official typo3.org news</title>
         <link>https://www.typo3.org/</link>
         <description></description>
         <language>en-gb</language>
            <copyright>TYPO3 News</copyright>
         <pubDate>
            Fri, 19 Nov 2021 05:01:09 +0100
         </pubDate>
         <lastBuildDate>
            Fri, 19 Nov 2021 05:01:09 +0100
         </lastBuildDate>
         <atom:link href="https://typo3.org/?type=100" rel="self"
                  type="application/rss+xml"/>
         <generator>TYPO3 EXT:news</generator>
            <item>
               <guid isPermaLink="false">news-2249</guid>
               <pubDate>
                  Thu, 18 Nov 2021 18:42:37 +0100
               </pubDate>
               <title>Meet Petra Hasenau, TYPO3 Association Board Vice-President, Germany (Application Podcast S02E10)
               </title>
               <link>
                     https://typo3.org/article/meet-petra-hasenau-typo3-association-board-vice-president-germany-application-podcast-s02e10
               </link>
               <description>In this episode, I speak with Petra Hasenau, the TYPO3 Association Board Vice President and the CEO of cybercraft GmbH. Today, we cover her introduction to TYPO3 and open source, her inclusive approach to community building, and her cooking channel!</description>
               <content:encoded>
                  <![CDATA[
                     ...
                  ]]>
               </content:encoded>
               <category>Community</category>
               <category>Podcasts</category>
            </item>
            <item>
               <guid isPermaLink="false">news-2248</guid>
               <pubDate>
                  Tue, 16 Nov 2021 10:30:00 +0100
               </pubDate>
               <title>TYPO3 11.5.3 maintenance release published
               </title>
               <link>
                     https://typo3.org/article/typo3-1153-maintenance-release-published
               </link>
               <description>The version 11.5.3 of the TYPO3 Enterprise Content Management System has just been released.</description>
               <content:encoded>
                  <![CDATA[
                     ...
                  ]]>
               </content:encoded>
               <category>Development</category>
               <category>TYPO3 CMS</category>
            </item>
            ...
         </channel>
      </rss>

The part in which we are really interested has been highlighted: we
want to import the various entries of the RSS feed, which correspond
to the :code:`<item>` tag. We also want to import their related link
(the URI in the :code:`<link>` tag).

But to make things more interesting, we don't want to import all news items.
We want only those who are part of the "TYPO3 CMS" category. Let's see
how we can achieve this.
