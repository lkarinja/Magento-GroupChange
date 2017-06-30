# Magento-GroupChange
This module changes the Group of a Customer to a Membership Group
if the Customer orders a Membership Item.
It also changes the Group of a Customer to a Non-Member Group
after their membership has gone past its valid date.

Group IDs and Item SKU can be edited in the .php files in \Observer\

To uninstall, the following SQL commands need to be run:

 DELETE FROM setup_module WHERE module = "PlymDesign_GroupChange"

 DELETE FROM eav_attribute WHERE attribute_code = "membership_expiration_date"

 ALTER TABLE customer_entity DROP membership_expiration_date

Reindex may also be required

Resources Consulted:

https://magento.stackexchange.com/questions/59827/change-customer-group-upon-buying-a-specific-product

https://magento.stackexchange.com/questions/154606/magento-2-best-way-to-change-customer-group-event-call-if-needed

https://stackoverflow.com/questions/27056468/magento-how-to-trigger-event-change-user-group-after-purchasing-a-specific-p/27057781#27057781

https://magento.stackexchange.com/questions/16120/programmatically-assign-customer-group-for-selected-category-product-order

http://devdocs.magento.com/guides/v2.0/extension-dev-guide/events-and-observers.html

https://cyrillschumacher.com/magento-2.2-list-of-all-dispatched-events/

https://github.com/magento/magento2/blob/develop/app/code/Magento/Checkout/Controller/Onepage/Success.php#L25

https://magento.stackexchange.com/questions/154838/magento-2-how-to-get-order-data-in-observer-on-success-page

https://magento.stackexchange.com/questions/144164/how-to-get-customer-details-in-checkout-onepage-controller-success-action-observ/144171#144171

https://magento.stackexchange.com/questions/96237/retrieve-items-on-order-magento-2

https://magento.stackexchange.com/questions/126820/magento-2-how-to-add-a-custom-column-in-customer-grid

https://magento.stackexchange.com/questions/174970/how-to-get-new-customer-id-using-customer-save-before-event-in-observer-in-magen

https://magento.stackexchange.com/questions/128830/magento-2-get-customer-id-from-session-in-a-block-class

https://stackoverflow.com/questions/36877138/how-can-i-inject-customer-session-model-in-an-observer-in-magento-2

https://magento.stackexchange.com/questions/126820/magento-2-how-to-add-a-custom-column-in-customer-grid

https://magento.stackexchange.com/questions/145155/magento-2-add-custom-attributes-to-customer-grid

https://magento.stackexchange.com/questions/134754/magento-2-how-to-add-a-new-column-to-orders-grid

https://magento.stackexchange.com/questions/126534/add-custom-column-to-customer-admin-grid

https://magento.stackexchange.com/questions/113764/magento-2-custom-grid-column-sort-order

https://magento.stackexchange.com/questions/68860/magento2-installschema-add-new-column-to-existing-table

https://magento.stackexchange.com/questions/169408/add-column-upgrade-schema-magento-2

http://inchoo.net/magento-2/setup-scripts-magento-2/

https://magento.stackexchange.com/questions/130155/create-date-and-time-attribute-for-product-in-magento-2

https://magento.stackexchange.com/questions/174840/magento-2-create-date-with-time-attribute-for-product/176606#176606

https://magento.stackexchange.com/questions/102197/magento2-installschema-php-does-not-create-the-table-specified

https://magento.stackexchange.com/questions/137911/magento2-not-executing-installschema-php-or-upgradeschema-php

https://magento.stackexchange.com/questions/120335/magento-2-installschema-not-being-executed

https://magento.stackexchange.com/questions/127414/problem-in-creating-a-table-via-custom-module-updateschema-php

https://magento.stackexchange.com/questions/86085/magento2-how-to-database-schema-upgrade

https://magento.stackexchange.com/questions/102197/magento2-installschema-php-does-not-create-the-table-specified

https://magento.stackexchange.com/questions/125194/magento-2-1-how-to-add-a-customer-custom-attribute-in-the-customer-address-edit/125367

https://stackoverflow.com/questions/3913620/get-all-table-names-of-a-particular-database-by-sql-query

http://www.extensions.sashas.org/blog/magento-2-make-customer-attribute.html

http://blog.chapagain.com.np/magento-2-run-custom-sql-query/

https://webkul.com/blog/magento2-write-custom-mysql-query/

https://stackoverflow.com/questions/9612166/how-do-i-pass-parameters-into-a-php-script-through-a-webpage

https://magento.stackexchange.com/questions/160131/what-are-the-source-items-in-ui-component-files

https://magento.stackexchange.com/questions/120606/how-to-use-renderer-in-column-ui-component-grid-in-magento-2

https://stackoverflow.com/questions/26293085/find-all-table-names-with-column-name

https://magento.stackexchange.com/questions/116199/magento-2-how-to-add-new-column-to-table-customer-grid-flat

https://magento.stackexchange.com/questions/155943/magento-2-1-not-add-table-into-database

http://inchoo.net/magento-2/setup-scripts-magento-2/

https://mage2.pro/t/topic/564

https://magento.stackexchange.com/questions/95931/add-attribute-to-registration-form-in-magento-2

https://stackoverflow.com/questions/12908334/new-line-in-php-output-in-a-text-file

http://www.herveguetin.com/fighting-the-attention-something-went-wrong-box/

https://magento.stackexchange.com/questions/90510/magento-2-reindexing-one-or-more-indexers-are-invalid-make-sure-your-magento

https://magento.stackexchange.com/questions/133052/magento-2-class-does-not-exist-error-backend

https://stackoverflow.com/questions/3913620/get-all-table-names-of-a-particular-database-by-sql-query

https://magento.stackexchange.com/questions/145155/magento-2-add-custom-attributes-to-customer-grid

https://magento.stackexchange.com/questions/92935/create-magento-2-upgrade-script-to-add-update-new-field-into-custom-module-table

https://askubuntu.com/questions/223691/how-do-i-create-a-script-file-for-terminal-commands

https://stackoverflow.com/questions/2268104/bash-script-variable-declaration-command-not-found

https://stackoverflow.com/questions/4651437/how-to-set-a-variable-to-the-output-from-a-command-in-bash

https://stackoverflow.com/questions/18062778/how-to-hide-command-output-in-bash

https://askubuntu.com/questions/29370/how-to-check-if-a-command-succeeded

https://stackoverflow.com/questions/14318451/how-to-use-bitwise-operators-in-if-statements

https://stackoverflow.com/questions/918886/how-do-i-split-a-string-on-a-delimiter-in-bash

https://www.cyberciti.biz/faq/unix-linux-bash-script-check-if-variable-is-empty/

https://stackoverflow.com/questions/13408493/bash-an-and-operator-for-if-statment

https://stackoverflow.com/questions/8467424/echo-newline-in-bash-prints-literal-n

https://stackoverflow.com/questions/5435589/bash-problem-running-command-with-quotes

https://magento.stackexchange.com/questions/106034/magento-2-how-to-query-data-in-observer/156061

https://magento.stackexchange.com/questions/147681/lock-wait-timeout-exceeded

https://stackoverflow.com/questions/4103480/how-to-resolve-argument-1-passed-to-my-function-must-be-an-instance-of-string

https://magento.stackexchange.com/questions/143947/updating-customer-group-from-observer-on-customer-register-success-event

https://magento.stackexchange.com/questions/89623/magento-2-get-current-store-date-time

https://magento.stackexchange.com/questions/138180/magento-2-how-to-get-current-date-date-time-with-format-in-phtml-file/138186

https://www.epochconverter.com/

https://www.epochconverter.com/programming/php#current

https://stackoverflow.com/questions/10841960/php-class-datetime-not-found

https://magento.stackexchange.com/questions/162087/how-to-create-customer-custom-attribute-in-magento-2-0

https://magento.stackexchange.com/questions/171355/magento-2-set-value-of-yes-no-custom-attribute-programmatically

https://magento.stackexchange.com/questions/147696/magento2-how-to-use-setcustomattribute-properly

https://magento.stackexchange.com/questions/108982/magento-2-set-custom-attribute-value-on-cart-page

https://github.com/magento/magento2/issues/1393

http://webkul.com/blog/add-value-customer-custom-attribute/

https://stackoverflow.com/questions/3913620/get-all-table-names-of-a-particular-database-by-sql-query

https://magento.stackexchange.com/questions/130155/create-date-and-time-attribute-for-product-in-magento-2

https://github.com/magento/magento2/issues/4053

http://www.extensions.sashas.org/blog/magento-2-1-3-how-to-make-customer-attribute-update.html

http://www.extensions.sashas.org/blog/magento-2-make-customer-attribute.html

https://magento.stackexchange.com/questions/121053/how-do-you-add-a-custom-attribute-to-the-customer-grid-in-adminhtml-magento2

https://magento.stackexchange.com/questions/113201/magento2-custom-customer-attribute-save-data

https://magento.stackexchange.com/questions/114650/magento2-can-not-save-value-of-custom-column-in-table-customer-entity

https://magento.stackexchange.com/questions/125194/magento-2-1-how-to-add-a-customer-custom-attribute-in-the-customer-address-edit

https://magento.stackexchange.com/questions/95545/magento-2-fail-to-save-the-value-of-a-newly-added-yes-no-customer-attribute

https://magento.stackexchange.com/questions/162214/how-to-show-custom-customer-attribute-in-customer-grid-dynamically-using-backend

https://magento.stackexchange.com/questions/121053/how-do-you-add-a-custom-attribute-to-the-customer-grid-in-adminhtml-magento2

https://secure.php.net/manual/en/datetime.format.php

https://stackoverflow.com/questions/10142658/php-find-string-with-regex

http://www.rexegg.com/regex-quickstart.html

https://stackoverflow.com/questions/444657/how-do-i-set-a-column-value-to-null-in-sql-server-management-studio

https://community.magento.com/t5/Admin-Configuration-Questions/Magento-2-Not-saving-changes-at-the-backend/td-p/24305

https://magento.stackexchange.com/questions/117098/magento-2-to-use-or-not-to-use-the-objectmanager-directly

https://magento.stackexchange.com/questions/89623/magento-2-get-current-store-date-time

https://cyrillschumacher.com/magento2-list-of-all-dispatched-events/

https://magento.stackexchange.com/questions/111137/magento-2-how-to-get-all-items-in-cart

http://devdocs.magento.com/guides/v2.1/extension-dev-guide/build/di-xml-file.html

https://magento.stackexchange.com/questions/128830/magento-2-get-customer-id-from-session-in-a-block-class

https://magento.stackexchange.com/questions/174856/get-quote-item-id-after-product-added-to-cart-in-observer

https://magento.stackexchange.com/questions/83138/how-to-use-messagemanager-to-show-an-error-after-redirect

https://www.envisionecommerce.com/how-to-reindexing-programmatically-in-magento-2/
