iWarehouse Use Cases
====================

INITIAL CONFIGURATION
---------------------
1) We need an user administrator as a database initial fixture
2) The first time an administrator loggins it must be warned that has to change 
   the password

INITIAL WAREHOUSE CONFIGURATION (As an administrator)
--------------------
1) I need to create a warehouse and set the warehouse name
2) I need to create a in buffer location, an out buffer location and some rack 
   locations
3) I need to create some products
4) Optionally I need to create presentations
5) Optionally I need to create product or presentation alias. Optionally the 
   application can suggest an alias
6) Optionally I need to set putaway rules to control when I put a product and in 
   which order I fill the warehouse
7) Set the warehouse parameters:
7-a)parameter that allows or not to putaway stock/containers ins diferent 
    locations taht the one proposed by the application.

RECEIVING PROCESS (As an operator)
--------------------
1) Create a reception
1-a) When I recive some product optionally I can create an order that informs 
     the stock I will receive and from which provider/client
1-b) When I have a reception order I can assign a door and a buffer to the 
     reception
2) Select an order
2-a) Select an order that exists
2-b) No select an order and recept to a new oder manually setting from which 
     provider/client
3) Select a buffer
3-a) If we have an order with buffer assigned we don't need to select the buffer
3-b) If we don't have order or the order desn't have buffer we need to assigna a 
     buffer
4) Stock creation
4-a) I read a label:
4-a-1) If the label is the buffer label we create the stock directly to the 
       buffer and without container
4-a-2) If the label is from an existent container we ask if we want to create 
       the stock into a existent container
4-a-3) If the label is from a non existent container we ask if we want create 
       the new container
4-b) For each product that I have to punt into this buffer/container:
4-b-1) I read a product label o I select a product
4-b-2) I set the quantity to recept
4-b-3) I set the logistic vars if the products requires
5) Reception ending. I close the reception


PUTAWAY PROCESS (As an operator)
--------------------
1) Choose the product to putaway:
1-a) If I read a container label the container is loaded into the equipment
1-b) If I read a buffer label I can show and choose which stock without 
     container or container I want to putaway and when I choose this 
     container/stock is loaded into the equipment
2) The solution must propose a location to putaway based on the putaway rules
3) Choose the location to putaway:
3-a) If the readed location is the proposed location the stock/container is 
     located in this
3-b) If the readed location is diferent from the proposed location and the 
     parameter (7-a) allows this we warn that the location is different than the 
     proposed and if the operator confirms we locate the container/stock into 
     this location

PICKING PROCESS (As an operator)
--------------------
0) In the future we need to know which stock we need to pick.
1) I need to pick products from several locations and put into one or more containers.
2) I need to put the stock/containers to the out buffer to wait truck loading.

TRUCK LOADING (as an operator)
--------------------
0) In the future we need to know the loading order of the stock, check that we load into the correct truck.
1) I need to load the stock containers into the truck and set the account.

TRACKING (as a quality user)
--------------------
0) In the future we need to get the backwardtraceability and forwardtraceability of each stock

STOCKQUERIES (as a warehouse manager)
--------------------
0)
1) I need to know who had created, modified, deleted and moved stock
2) I need to know who had created, modified, deleted and moved containers
3) I need to know who had created, modified and deleted locations
4) I need to know the product quantity into the warehouse
5) I need to know all the warehouse movements of a product
