<?php
//write details of an item to the BG AWS database 


//connect


//MERGE (ok! - ON DUPLICATE KEY UPDATE in MYSQL)
//needs MySQL 4.1
INSERT INTO table
VALUES(blah,blah1,blah2)
ON DUPLICATE KEY UPDATE hits=hits+1; // substitute for variable columns 



//disconnect if necessary


?>