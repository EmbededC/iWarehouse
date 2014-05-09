INITIAL CONFIGURATION (As an administration)
=====================
1)I need to set a warehouse name and create a admin user with name and password
2)I need to create a in buffer location, an out buffer location and some rack locations
3)I need to create some products
4)Optionally I need to create presentations
5)Optionally I need to create product or presentation alias. Optionally the application can suggest an alias.

RECEIVING PROCESS (As an operator)
=====================
1)When I recive stock from outside the warehouse (provider or customer or manufacturer) I need to create stock into the in buffer and set the provider. Optionally I can create a container and create the stock into the container.

PUTAWAY PROCESS (As an operator)
=====================
0)In the future we need to know in which locations we can put the stock.
1)I need to locate the stock/container into a location.

PICKING PROCESS (As an operator)
=====================
0)In the future we need to know which stock we need to pick.
1)I need to pick products from several locations and put into one or more containers.
2)I need to put the stock/containers to the out buffer to wait truck loading.

TRUCK LOADING (as an operator)
=====================
0)In the future we need to know the loading order of the stock, check that we load into the correct truck.
1)I need to load the stock containers into the truck and set the account.

TRACKING (as a quality user)
=====================
0)In the future we need to get the backwardtraceability and forwardtraceability of each stock

STOCKQUERIES (as a warehouse manager)
=====================
0)
1)I need to know who had created, modified, deleted and moved stock
2)I need to know who had created, modified, deleted and moved containers
3)I need to know who had created, modified and deleted locations
4)I need to know the product quantity into the warehouse
5)I need to know all the warehouse movements of a product
