INSERT INTO Rayons (idRayon,libelleRayon,descRayon)
VALUES
(0,'Legumes','dans nos potagers'),
(1,'Fruits','dans nos vergers'),
(2,'Viande','Tous type de viande animal'),
(3,'Poisson','tous les produits de la mer et de nos rivierers'),
(4,'Produit laitier','lait yaourt et ses derivée'),
(5,'Bio','produit issue de l\'agriculture biologique');

INSERT INTO Produits(validProduit,idProduit,nomProduit,imgProduit,idRayons)
VALUES
(0,001,'Tomates','',0),
(0,002,'Carottes','',0),
(0,003,'Courgette','',0),
(1,101,'Peche','',1),
(0,102,'Kaki','',1),
(1,103,'Poire','',1),
(0,201,'Steack','',2),
(0,202,'Pied','',2),
(1,301,'Saumon','',3),
(0,302,'Thon','',3),
(0,401,'Lait','',4),
(0,501,'Haricots','',5)
;