# magento2 Link Customers To Orders
Magneto 2 module to link customers to orders

This module has 2 observers.
1. Will check when order was placed as guest and link existing customer to it.
2. Will check when customer registers and link all orders to the customer.

# Installation
1. Create Wemessage folder in app/code
2. Copy contents of this repository to that directory
3. ````
   run bin/magento m:e Wemessage_LinkCustomers
   run bin/magento s:u
   run bin/magento s:s:d -f
   ````
