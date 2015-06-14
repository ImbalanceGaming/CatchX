Lokaal opzetten:

1. Draai een lokale server.
Zelf gebruik ik een WAMP server.
De server moet MySql hebben.

2. Zet de repository op in de www folder.

3. Edit js/constants.js en laat baseUrl verwijzen naar de folder waar de repository staat.

4. Maak een catchx database aan. Je kunt hiervoor de catchx.sql importeren.

5. Pas de database connectie gegevens aan. De file hiervoor kun je vinden onder api\application\config\database.php


Kort overzicht van de code:

CatchX bestaat uit 3 delen:

1. Het frontend gedeelde, dit is de rootmap met alle files behalve de mappen "api" en "play".
Het frontend gedeelde is verantwoordelijk voor de interface voor het maken en joinen van games.
Frontend is opgebouwd uit m.b.v. AngularJs

2. De game gedeelte, deze is te vinden in de "play" map. Hier vind de meeste frontend game logica plaats.
Game is gebouwd in html,css en javascript.

3. De backend, deze is te vinden in de "api" map. De api bevat de connectie naar de database en host alle games.
Backend maakt gebruik van het php codeigniter framework.