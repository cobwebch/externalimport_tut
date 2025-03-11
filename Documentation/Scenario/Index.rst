.. include:: /Includes.rst.txt


.. _scenario:

The scenario
------------


.. _scenario-main:

Main scenario
^^^^^^^^^^^^^

The basic scenario of this tutorial is the following: we have flat
files exported from some other system, e.g. a company ERP. These
exports contains a list of employees, a list of departments, a list of
holidays balances for each employees and a list of teams along with
their members (employees). The goal is to import all this data into
TYPO3 tables all the while maintaining the relationships.

The departments and the teams will go into new tables. The employees
should go into the :code:`fe_users` table, so that each employee can then log
into the corporate intranet powered by TYPO3. One implication is that
user names and passwords must be created on the fly for each new
employee.

One particular constraint is the order in which the data is imported.
If we want to keep the relationship between employees and their
departments, we must make sure that the departments are imported
**before** the employees. On the other hand the relationship between
employees and their teams is found inside the teams file. So teams
must be imported **after** the employees.


.. _scenario-second:

Second scenario
^^^^^^^^^^^^^^^

In order to be more complete, this tutorial proposes a second
workflow: in this other case we want to import an RSS feed into the
:code:`tx_news_domain_model_news` table. This scenario demonstrates the
processing of an XML input.

