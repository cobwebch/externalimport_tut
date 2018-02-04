.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _employees-import-teams:

The teams
^^^^^^^^^

The last data to be imported is the teams. This is mostly like
departments, except that teams have a many-to-many relationship to
employees. Indeed a team will be comprised of several employees and
any employee may be part of several teams.

When such data comes along, the external\_import extension expects it
to be denormalised. This means that if team A contains 3 employees,
there will be 3 entries for team A, each with a relationship to a
different employee. Let's look at the example data:

.. figure:: ../../Images/TeamsFileContent.png
	:alt: The teams file

	CSV data in the temas.txt file

We clearly see that the "Planet Destroyers" team appears
three times, because it is comprised of employees 256, 421 and 784.
External import takes this into account by making sure that it keeps a
single copy of each team, based on the external primary key (the
"code" field in this case).

.. note::

   Since "external_import" version 2.3.0, it is also possible
   to create MM-relationships with data represented as a
   comma-separated list of keys, commonly used in TYPO3.

In the example data above, you can see that there's a "rank" field.
This will be used to set the "sorting" column in the MM-relations
table.

The SQL for the teams table is not repeated here as it is quite
standard. The MM-relations table is also an absolutely standard TYPO3
table for MM-relations:

.. code-block:: sql

	CREATE TABLE tx_externalimporttut_teams (
		uid int(11) NOT NULL auto_increment,
		pid int(11) DEFAULT '0' NOT NULL,
		tstamp int(11) DEFAULT '0' NOT NULL,
		crdate int(11) DEFAULT '0' NOT NULL,
		cruser_id int(11) DEFAULT '0' NOT NULL,
		deleted tinyint(4) DEFAULT '0' NOT NULL,
		hidden tinyint(4) DEFAULT '0' NOT NULL,
		code varchar(5) DEFAULT '' NOT NULL,
		name varchar(255) DEFAULT '' NOT NULL,
		members text,

		PRIMARY KEY (uid),
		KEY parent (pid)
	);

The "external" definition of the team's table "ctrl" section is also
not repeated here as it does not contain anything not already covered
in this tutorial. The really interesting part is the "external"
information for creating the relationship between teams and fe\_users.
The definition is to be found in the "members" column of the teams
table:

.. code-block:: php
   :emphasize-lines: 19-25

	$GLOBALS['TCA']['tx_externalimporttut_teams'] = [
           ...
           'columns' => [
                   ...
                   'members' => [
                           'exclude' => 0,
                           'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams.members',
                           'config' => [
                                   'type' => 'group',
                                   'size' => 5,
                                   'internal_type' => 'db',
                                   'allowed' => 'fe_users',
                                   'MM' => 'tx_externalimporttut_teams_feusers_mm',
                                   'maxitems' => 100
                           ],
                           'external' => [
                                   0 => [
                                           'field' => 'employee',
                                           'MM' => [
                                                   'mapping' => [
                                                           'table' => 'fe_users',
                                                           'referenceField' => 'tx_externalimporttut_code',
                                                   ],
                                                   'sorting' => 'rank'
                                           ]
                                   ]
                           ]
                   ],
           ],
           ...
	];

Looking at the TCA for this column, you can see that it contains the
traditional information for a MM column. The external part describes
the column as pointing to the "employee" field, which contains the
employee number as we saw above. It then contains a "MM" section which
describes how the relationships can be created on the TYPO3 side. The
main part is the "mapping" information which is similar in syntax to
what we saw for simply mapped fields (a.k.a one-to-many
relationships). It references a table and the column in that table
which contains the external primary key.

Additionally it is possible to choose a field from the external data
that will be used to define the sorting of the relationships. In this
case it is the "rank" field. If this is not defined, the sorting will
be simply based on the first in, first out basis (i.e. the first
record will have a sorting of 1, the second a sorting of 2, etc.).

Note that it is currently not possible to define a sorting field for
the "sorting\_foreign" column, should you have such a configuration.
Sorting is always relative to the "uid\_local" column.

After running the teams import, you should get something like this:

.. figure:: ../../Images/TeamsImportWithMembers.png
	:alt: The teams imported into the database

	The team data imported into the database with relations to FE users (members)

We can see that the teams were properly related to the
fe\_users. The sorting has also been kept correctly although with a
renumbering (done automatically by DataHandler).

