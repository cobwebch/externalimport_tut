.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _employees-import-employees:

The employees (and their holidays)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The list of employees will be stored in the fe\_users table, which
must be extended to add the necessary fields:

.. code-block:: sql

	CREATE TABLE fe_users (
		tx_externalimporttut_code varchar(10) DEFAULT '' NOT NULL,
		tx_externalimporttut_department text,
		tx_externalimporttut_holidays int(11) DEFAULT '0' NOT NULL,
	);

These new columns are added to the TCA of the fe\_users table. At this
point we don't yet set the external data for these columns, as we will
do it later for all relevant columns. As this is a standard TCA
operation, it is not repeated here and can be simply looked up in the
:file:`ext_tables.php` file.

Next we add the external information to the "ctrl" section of the
fe\_users table:

.. code-block:: php

	$GLOBALS['TCA']['fe_users']['ctrl']['external'] = array(
		0 => array(
			'connector' => 'csv',
			'parameters' => array(
				'filename' => $extensionPath . 'res/employees.txt',
				'delimiter' => ';',
				'text_qualifier' => '',
				'skip_rows' => 1,
				'encoding' => 'utf8'
			),
			'data' => 'array',
			'referenceUid' => 'tx_externalimporttut_code',
			'additional_fields' => 'last_name,first_name',
			'priority' => 50,
			'disabledOperations' => '',
			'enforcePid' => TRUE,
			'description' => 'Import of full employee list'
		),
		1 => array(
			'connector' => 'csv',
			'parameters' => array(
				'filename' => $extensionPath . 'res/holidays.txt',
				'delimiter' => ',',
				'text_qualifier' => '',
				'skip_rows' => 0,
				'encoding' => 'utf8'
			),
			'data' => 'array',
			'referenceUid' => 'tx_externalimporttut_code',
			'priority' => 60,
			'disabledOperations' => 'insert,delete',
			'description' => 'Import of holidays balance'
		)
	);

The first thing to note is that there are 2 external configurations in
this case. As was described in the description of the scenario, the
fe\_users users table will be synchronised with the employees list and
with a second file containing the balance of holidays. Two things are
worth of notice in the first configuration:

#. the use of the "additional\_fields" property: two fields from the
   external data ("last\_name" and "first\_name") will be used during the
   import for assembling the user's full name and its password. So we
   need to keep those two fields for calculations, but they won't be
   stored at the end of the process.

#. The "enforcePid" property is set to true so that not all fe\_users
   records will be affected be the import process. If some fe\_users are
   stored in a different page than the one where the imported records are
   stored, those records will not be considered for updates or deletion.
   This makes it possible to have several sources of fe\_users without
   interference with one another.

In the second configuration, we make use of the "disabledOperations"
property. Indeed the holidays balance file will contain only
information about the number of holidays still available for each
employee. It does not contain complete information so it cannot be
used as a reference for creating new users. Hence the "insert"
operations is disabled. Since it is not a reference anyway, it does
not make sense to allow this particular synchronisation to delete
users. So the "delete" operation is also disabled.

Finally we set the external configuration for each column that will
receive external data.

.. code-block:: php
   :emphasize-lines: 1-30,49-75

	$GLOBALS['TCA']['fe_users']['columns']['name']['external'] = array(
		0 => array(
			'field' => 'last_name',
			'userFunc' => array(
				'class' => 'EXT:externalimport_tut/class.tx_externalimporttut_transformations.php:tx_externalimporttut_transformations',
				'method' => 'assembleName'
			)
		)
	);
	$GLOBALS['TCA']['fe_users']['columns']['username']['external'] = array(
		0 => array(
			'field' => 'last_name',
			'userFunc' => array(
				'class' => 'EXT:externalimport_tut/class.tx_externalimporttut_transformations.php:tx_externalimporttut_transformations',
				'method' => 'assembleUserName',
				'params' => array(
					'encoding' => 'utf8'
				)
			)
		)
	);
	$GLOBALS['TCA']['fe_users']['columns']['starttime']['external'] = array(
		0 => array(
			'field' => 'start_date',
			'userFunc' => array(
				'class' => 'EXT:external_import/samples/class.tx_externalimport_transformations.php:tx_externalimport_transformations',
				'method' => 'parseDate'
			)
		)
	);
	$GLOBALS['TCA']['fe_users']['columns']['tx_externalimporttut_code']['external'] = array(
		0 => array(
			'field' => 'employee_number'
		),
		1 => array(
			'field' => 0
		)
	);
	$GLOBALS['TCA']['fe_users']['columns']['email']['external'] = array(
		0 => array(
			'field' => 'mail'
		)
	);
	$GLOBALS['TCA']['fe_users']['columns']['telephone']['external'] = array(
		0 => array(
			'field' => 'phone'
		)
	);
	$GLOBALS['TCA']['fe_users']['columns']['company']['external'] = array(
		0 => array(
			'value' => 'The Empire'
		)
	);
	$GLOBALS['TCA']['fe_users']['columns']['title']['external'] = array(
		0 => array(
			'field' => 'rank',
			'mapping' => array(
				'valueMap' => array(
					'1' => 'Captain',
					'2' => 'Senior',
					'3' => 'Junior'
				)
			),
			'excludedOperations' => 'update'
		)
	);
	$GLOBALS['TCA']['fe_users']['columns']['tx_externalimporttut_department']['external'] = array(
		0 => array(
			'field' => 'department',
			'mapping' => array(
				'table' => 'tx_externalimporttut_departments',
				'reference_field' => 'code'
			)
		)
	);
	$GLOBALS['TCA']['fe_users']['columns']['tx_externalimporttut_holidays']['external'] = array(
		1 => array(
			'field' => 1
		)
	);

Several columns have more interesting configurations than the
departments table described before. They have been highlighted.
The first three fields will use a user function. The user
functions are defined using a "class" property and a "method"
property. Additional parameters can be passed to the function using
the "parameters" property. So what happens for these three fields?

#. For the "name" field, a method called :code:`assembleName()` will be
   called, from a class defined in this tutorial extension. Let's look at
   what this method does:

   .. code-block:: php

		public function assembleName($record, $index, $params)
		{
			return $record['last_name'] . ' ' . $record['first_name'];
		}

   The method receives the record being handled, so that all fields
   (mapped fields and additional fields) from the external data are
   available for calculations. The :code:`$index` argument contains the
   key of the field that is to be affected by the transformation. The
   third argument is an array containing additional parameters. In this
   case it is not used.

   To obtain the user's full name we just concatenate the values from the
   "last\_name" and "first\_name" external fields. This value is returned
   as the method's result.

#. For the "username" field a similar method is called, but which takes
   extra care to return a viable user name, i.e. converting any character
   that is not strict ASCII and stripping other inappropriate character.
   Note that this is just an example. A real-world implementation of such
   a method would also check that the generated user name is unique.

#. The "starttime" field is mapped to the external "start\_date". However
   that date is stored in a "yyyy-mm-dd" format, which is not convenient
   for storing in the "starttime" field. We convert to a timestamp using
   a sample user function provided by the external\_import extension
   itself. This method can perform several transformations, but it
   returns a simple timestamp when called without parameters, as is the
   case here.

#. The "company" field is actually not filled with values coming from the
   external source, but with a fixed value. This is achieved by using the
   "value" property instead of the "field" property. In this example, the
   "company" field for every fe\_users record will contain the value "The
   Empire".

#. The same goes for the "title" field, but a bit more sophisticated. In
   this case the values from the external source are matched to other
   values using a simple array. For example, if the external data is "1",
   the title will be "Captain". This way we can avoid creating a separate
   table for titles, assuming there are only a few and they don't change
   often.Furthermore we decided that this field should not be updated
   (using the "excludedOperations" property). This means that this field
   will be written when a new record is created, but will be left
   untouched during further updates. That way the field can be safely
   modified from within TYPO3 and changes will not be overwritten.

#. Last but not least, the "tx\_externalimporttut\_department" will need
   to relate to the department the employee works in. Now we don't want
   to use the primary key of the external data for departments as a
   foreign key in the fe\_users table. We want the uid from the
   departments as they were inserted into the TYPO3 database. This is the
   task of the "mapping" property. The first sub-property – "table" – is
   used to point to the table where the records are stored inside the
   TYPO3 database. The second sub-property – "reference\_field" –
   indicates in which field from that table the external primary key for
   departments has been stored.What will happen during import is that the
   mapping function will build a hash table relating the external primary
   keys from the departments table ("code" column) to the internal
   primary keys ("uid" column). This hash table is then used to find out
   the foreign keys for the fe\_users.

One more operation happens during the import process, but is not
visible in the TCA. In the ext\_localconf.php file, we make use of the
"insertPreProcess" hook:

.. code-block:: php

	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['external_import']['insertPreProcess'][] = 'EXT:externalimport_tut/class.tx_externalimporttut_hooks.php:tx_externalimporttut_hooks';

This makes it possible to add an automatically generated password to
the data to be stored, but only in the case when it is a new user
(insert operation). To be really clean we could also make use of the
"updatePreProcess" hook to remove the username field from the records
to be updated, as we don't really want to change the username
automatically. This is left as an exercise for the reader. You may
also want to make sure that new users belong to some default
fe\_group.

All the external configuration shown above also included information
for importing the holidays balance. There are a couple of things worth
noticing:

#. The file "holidays.txt" does not contain a header row. Thus it is not
   possible to use field names for mapping the external data. Instead we
   have to rely on column numbers. So "tx\_externalimporttut\_code" is
   matched to field 0 and " tx\_externalimporttut\_holidays" is matched
   to field 1.

#. Strictly speaking it is not necessary to store the employee number
   again in the "tx\_externalimporttut\_code" column, so you might think
   that this mapping could be dropped. It is however necessary to keep
   it, because this is how existing records will be detected (by matching
   the value imported into the "tx\_externalimporttut\_code" column to
   the external primary keys already stored in the database).

If you now run the employees and then the holidays synchronisations,
you should end up with a situation that can be represented like this
(sorry, it's a bit small but hopefully still readable):

.. figure:: ../../Images/EmployeesImportedWithHolidays.png
	:alt: The imported employees

	Imported employees with their holidays into the database

Most importantly we can see that the
"tx\_externalimporttut\_department" column contains foreign keys that
correspond to the internal (TYPO3) primary keys of the departments
table. If you open a fe\_user record in the TYPO3 BE, you will see
that it cleanly relates to a department.

.. figure:: ../../Images/FeUserRecord.png
	:alt: The imported FE user record

	Viewing the imported FE user data in the TYPO3 backend

And since the data manipulation operations rely on DataHandler the
reference index has been kept up to date, as you can see by looking at
the information of any department in the backend:

.. figure:: ../../Images/ListOfReferences.png
	:alt: The information view with references

	Viewing the details of an imported department in the BE, with correct number of references
