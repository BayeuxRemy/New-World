#include "mainwindow.h"
#include "ui_mainwindow.h"
#include <QSqlQuery>
#include <QDebug>
#include <QMessageBox>


MainWindow::MainWindow(DialogConnect *lEmploye, QWidget *parent) :
    QMainWindow(parent),
    ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    ui->labelPrenomEmploye->setText(lEmploye->prenom);
    ui->labelNomEmploye->setText(lEmploye->nom);

    //charge la tableWidget des Rayons
    this->chargeTableWidgetRayons();
    //charge la tableWidget des Produits
    this->chargeTableWidgetProduits();
    //charge le comboBox des Rayons dans le MENU PRODUIT
    this->chargeComboBoxRayonDuProduit();
    //charge la tableWidget des Produits pas validés
    this->chargeTableWidgetProduitsPasValide();
    //charge de la tableWidget des Varietes
    this->chargeTableWidgetVarietes();
    //charge la tableWidget des Varietes pas validées
    this->chargeTableWidgetVarietesPasValide();
    //charge comboBox des Produits dans le MENU VARIETE
    this->chargeComboBoxProduitDeLaVariete();
}

MainWindow::~MainWindow()
{
    delete ui;
}

//************* MENU RAYONS **********//

void MainWindow::chargeTableWidgetRayons()
{
    //remise a zero du contenu de la tableWidget
    this->ligneSelectionnee = -1;
    ui->tableWidgetRayons->reset();
    //préparation et exécution de la requête
    QString txtReq="SELECT idRayon, libelleRayon, descRayon FROM Rayons;";
    QSqlQuery maRequete(txtReq);
    //si la requete s'exécute bien
    if (maRequete.exec())
    {
        //fixer le nombre de colonnes du tableau
        ui->tableWidgetRayons->setColumnCount(3);
        //donnée un nom d'entête en haut de chaque colonne
        ui->tableWidgetRayons->setHorizontalHeaderItem(0,new QTableWidgetItem("id"));
        ui->tableWidgetRayons->setHorizontalHeaderItem(1,new QTableWidgetItem("Nom"));
        ui->tableWidgetRayons->setHorizontalHeaderItem(2,new QTableWidgetItem("Description"));

        //afficher les entêtes de colonne
        ui->tableWidgetRayons->horizontalHeader()->show();
        //cacher la colonne 0, id
        ui->tableWidgetRayons->hideColumn(0);
        //parcours des enregistrements, un par un, tant qu'il y en a
        while (maRequete.next())
        {
            //ajouter une ligne au tableau
            ui->tableWidgetRayons->setRowCount(ui->tableWidgetRayons->rowCount()+1);
            //écrire la valeur récupérée au bon endroit dans le tableau
            ui->tableWidgetRayons->setItem(ui->tableWidgetRayons->rowCount()-1,0,new QTableWidgetItem(maRequete.value("idRayon").toString()));
            ui->tableWidgetRayons->setItem(ui->tableWidgetRayons->rowCount()-1,1,new QTableWidgetItem(maRequete.value("libelleRayon").toString()));
            ui->tableWidgetRayons->setItem(ui->tableWidgetRayons->rowCount()-1,2,new QTableWidgetItem(maRequete.value("descRayon").toString()));
       }
    }
}

void MainWindow::on_tableWidgetRayons_clicked(const QModelIndex &index)
{
    ui->lineEditNomRayon->setText(ui->tableWidgetRayons->item(index.row(),1)->text());
    ui->lineEditDescRayon->setText(ui->tableWidgetRayons->item(index.row(),2)->text());
    this->ligneSelectionnee = index.row();

    //charge des listWidget des produits du Rayon
    chargeListeDesProduits();
}

void MainWindow::chargeListeDesProduits()
{
    ui->listWidgetProduitsValidDuRayon->clear();
    ui->listWidgetProduitsPasValidDuRayon->clear();
    //préparation et exécution de la requête
        QString txtReq1="SELECT idProduit, nomProduit, validProduit FROM Produits WHERE idRayons ='"+ui->tableWidgetRayons->item(this->ligneSelectionnee,0)->text()+"' AND validProduit ORDER BY nomProduit";
        QSqlQuery maRequete(txtReq1);
        //parcours des enregistrements, un par un, tant qu'il y en a
        while (maRequete.next())
        {
            ui->listWidgetProduitsValidDuRayon->addItem(maRequete.value("nomProduit").toString());
        }

        QString txtReq2="SELECT idProduit, nomProduit, validProduit FROM Produits WHERE idRayons ='"+ui->tableWidgetRayons->item(this->ligneSelectionnee,0)->text()+"' AND not validProduit ORDER BY nomProduit";
        QSqlQuery maRequete2(txtReq2);
        while (maRequete2.next())
        {
            ui->listWidgetProduitsPasValidDuRayon->addItem(maRequete2.value("nomProduit").toString());
        }

}

void MainWindow::on_pushButtonAjouterRayon_clicked()
{
    int newId;
    //préparation et exécution de la requête
    QString reqId = "SELECT ifnull(max(idRayon),0)+1 from Rayons;";

    QSqlQuery maRequete(reqId);
    //qDebug() << reqId;
    if (maRequete.first())
    {
            newId=maRequete.value(0).toInt();
    }
    QString txtReq = "INSERT INTO Rayons(idRayon, libelleRayon, descRayon) VALUES (?,'"+ui->lineEditNomRayon->text()+"','"+ui->lineEditDescRayon->text()+"');";
    QSqlQuery ajoutRequete(txtReq);
    ajoutRequete.addBindValue(newId);
    //qDebug() << txtReq;
    ajoutRequete.exec();
    //récupération de la saisie de l'utilisateur
    ui->tableWidgetRayons->setRowCount(0);
    chargeTableWidgetRayons();
    on_pushButtonClearRayon_clicked();

}

void MainWindow::on_pushButtonClearRayon_clicked()
{
    this->ligneSelectionnee = -1;
    ui->lineEditNomRayon->clear();
    ui->lineEditDescRayon->clear();
    ui->tableWidgetRayons->setRowCount(0);
    chargeTableWidgetRayons();
}

void MainWindow::on_pushButtonSupprimerRayon_clicked()
{
    //préparation de la requête
    QString txtReq = "DELETE FROM Rayons WHERE idRayon= ?";
    QSqlQuery suppRequete(txtReq);
    suppRequete.addBindValue(ui->tableWidgetRayons->item(this->ligneSelectionnee,0)->text()); //récupère l'id de la ligne selectionné et l'ajoute a la requête a la place du "?"

    suppRequete.exec();

    ui->tableWidgetRayons->setRowCount(0);
    chargeTableWidgetRayons();
    chargeComboBoxRayonDuProduit();
    on_pushButtonClearRayon_clicked();

}

void MainWindow::on_pushButtonModifierRayon_clicked()
{
    //préparation de la requête
    QString txtReq = "UPDATE Rayons SET libelleRayon ='"+ui->lineEditNomRayon->text()+"', descRayon ='"+ui->lineEditDescRayon->text()+"' WHERE idRayon= ? ;";
    QSqlQuery modifRequete(txtReq);
    modifRequete.addBindValue(ui->tableWidgetRayons->item(this->ligneSelectionnee,0)->text()); //récupère l'id de la ligne selectionné et l'ajoute a la requête a la place du "?"
    //qDebug() << txtReq;
    if(modifRequete.exec()) //si la requête s'exécute bien
    {
        ui->tableWidgetRayons->setRowCount(0);
        chargeTableWidgetRayons();
        on_pushButtonClearRayon_clicked();
    }
}

//*******************  MENU PRODUITS/VARIETES ******************

//   ******** Produit *************

void MainWindow::chargeTableWidgetProduits()
{
    //remise a zero du contenu de la tableWidget
    this->ligneSelectionnee = -1;
    ui->tableWidgetProduits->reset();
    //préparation et exécution de la requête
    QString txtReq="SELECT idProduit, nomProduit, libelleRayon, imgProduit, validProduit FROM Produits INNER JOIN Rayons on Produits.idRayons = Rayons.idRayon WHERE validProduit ORDER BY libelleRayon, nomProduit";
    QSqlQuery maRequete(txtReq);
        //fixer le nombre de colonnes du tableau
        ui->tableWidgetProduits->setColumnCount(4);
        //donnée un nom d'entête en haut de chaque colonne
        ui->tableWidgetProduits->setHorizontalHeaderItem(0,new QTableWidgetItem("id"));
        ui->tableWidgetProduits->setHorizontalHeaderItem(1,new QTableWidgetItem("Nom"));
        ui->tableWidgetProduits->setHorizontalHeaderItem(2,new QTableWidgetItem("Rayon"));
        ui->tableWidgetProduits->setHorizontalHeaderItem(3,new QTableWidgetItem("Image"));

        //afficher les entêtes de colonne
        ui->tableWidgetProduits->horizontalHeader()->show();
        //cacher la colonne 0(id) et 3(lien de l'image)
        ui->tableWidgetProduits->hideColumn(0);
        ui->tableWidgetProduits->hideColumn(3);

        //parcours des enregistrements, un par un, tant qu'il y en a
        while (maRequete.next())
        {
            //ajouter une ligne au tableau
            ui->tableWidgetProduits->setRowCount(ui->tableWidgetProduits->rowCount()+1);
            //écrire la valeur récupérée au bon endroit dans le tableau
            ui->tableWidgetProduits->setItem(ui->tableWidgetProduits->rowCount()-1,0,new QTableWidgetItem(maRequete.value("idProduit").toString()));
            ui->tableWidgetProduits->setItem(ui->tableWidgetProduits->rowCount()-1,1,new QTableWidgetItem(maRequete.value("nomProduit").toString()));
            ui->tableWidgetProduits->setItem(ui->tableWidgetProduits->rowCount()-1,2,new QTableWidgetItem(maRequete.value("libelleRayon").toString()));
            ui->tableWidgetProduits->setItem(ui->tableWidgetProduits->rowCount()-1,3,new QTableWidgetItem(maRequete.value("imgProduit").toString()));
       }
}
void MainWindow::chargeTableWidgetProduitsPasValide()
{
    //remise a zero du contenu de la tableWidget
    this->ligneSelectionnee = -1;
    ui->tableWidgetProduitsPasValide->reset();
    //préparation et exécution de la requête
    QString txtReq="SELECT idProduit, nomProduit, libelleRayon, imgProduit, validProduit FROM Produits INNER JOIN Rayons on Produits.idRayons = Rayons.idRayon WHERE not validProduit ORDER BY libelleRayon, nomProduit";
    QSqlQuery maRequete(txtReq);

        //fixer le nombre de colonnes du tableau
        ui->tableWidgetProduitsPasValide->setColumnCount(5);
        //donnée un nom d'entête en haut de chaque colonne
        ui->tableWidgetProduitsPasValide->setHorizontalHeaderItem(0,new QTableWidgetItem("id"));
        ui->tableWidgetProduitsPasValide->setHorizontalHeaderItem(1,new QTableWidgetItem("Nom"));
        ui->tableWidgetProduitsPasValide->setHorizontalHeaderItem(2,new QTableWidgetItem("Rayon"));
        ui->tableWidgetProduitsPasValide->setHorizontalHeaderItem(3,new QTableWidgetItem("Image"));
        ui->tableWidgetProduitsPasValide->setHorizontalHeaderItem(4,new QTableWidgetItem("Validation"));

        //afficher les entêtes de colonne
        ui->tableWidgetProduitsPasValide->horizontalHeader()->show();
        //cacher la colonne 0(id) et 3(lien de l'image)
        ui->tableWidgetProduitsPasValide->hideColumn(0);
        ui->tableWidgetProduitsPasValide->hideColumn(3);

        //parcours des enregistrements, un par un, tant qu'il y en a
        while (maRequete.next())
        {
            //On créer le checkBox pour la validité des produits
            QCheckBox * checkProduit = new QCheckBox("Accepter",ui->tableWidgetProduitsPasValide);
            checkProduit->setProperty("noProduit",maRequete.value("idProduit").toString());
            connect(checkProduit,SIGNAL(stateChanged(int)),this,SLOT(validerProduit()));

            //ajouter une ligne au tableau
            ui->tableWidgetProduitsPasValide->setRowCount(ui->tableWidgetProduitsPasValide->rowCount()+1);
            //écrire la valeur récupérée au bon endroit dans le tableau
            ui->tableWidgetProduitsPasValide->setItem(ui->tableWidgetProduitsPasValide->rowCount()-1,0,new QTableWidgetItem(maRequete.value("idProduit").toString()));
            ui->tableWidgetProduitsPasValide->setItem(ui->tableWidgetProduitsPasValide->rowCount()-1,1,new QTableWidgetItem(maRequete.value("nomProduit").toString()));
            ui->tableWidgetProduitsPasValide->setItem(ui->tableWidgetProduitsPasValide->rowCount()-1,2,new QTableWidgetItem(maRequete.value("libelleRayon").toString()));
            ui->tableWidgetProduitsPasValide->setItem(ui->tableWidgetProduitsPasValide->rowCount()-1,3,new QTableWidgetItem(maRequete.value("imgProduit").toString()));
            ui->tableWidgetProduitsPasValide->setCellWidget(ui->tableWidgetProduitsPasValide->rowCount()-1,4,checkProduit);
        }
}

void MainWindow::validerProduit()
{
    //préparation de la requête
    QString idProduit= sender()->property("noProduit").toString();
    QString txtReq = "UPDATE Produits SET validProduit = 1 WHERE idProduit= "+idProduit+" ;";
    QSqlQuery modifRequete(txtReq);
    on_pushButtonClearProduit_clicked();
}

void MainWindow::chargeComboBoxRayonDuProduit()
{
    //remise à zéro de la combo
    ui->comboBoxRayonDuProduit->clear();
    //préparation de la requête
    QString txtReq = "SELECT libelleRayon FROM Rayons ORDER BY libelleRayon";
    QSqlQuery maRequete(txtReq);
        //parcours des enregistrements, un par un, tant qu'il y en a
        while(maRequete.next())
        {
            //ajouter l'option renvoyée par la requete au combo
            ui->comboBoxRayonDuProduit->addItem(maRequete.value(0).toString());
        }
}

void MainWindow::on_tableWidgetProduits_clicked(const QModelIndex &index)
{
    ui->lineEditNomProduit->setText(ui->tableWidgetProduits->item(index.row(),1)->text());
    ui->comboBoxRayonDuProduit->setCurrentText(ui->tableWidgetProduits->item(index.row(),2)->text());
    ui->lineEditLienImageProduit->setText(ui->tableWidgetProduits->item(index.row(),3)->text());
    this->ligneSelectionnee = index.row();
    this->valid = true;
}

void MainWindow::on_tableWidgetProduitsPasValide_clicked(const QModelIndex &index)
{
    ui->lineEditNomProduit->setText(ui->tableWidgetProduitsPasValide->item(index.row(),1)->text());
    ui->comboBoxRayonDuProduit->setCurrentText(ui->tableWidgetProduitsPasValide->item(index.row(),2)->text());
    ui->lineEditLienImageProduit->setText(ui->tableWidgetProduitsPasValide->item(index.row(),3)->text());
    this->ligneSelectionnee = index.row();
    this->valid = false;
}

void MainWindow::on_pushButtonAjouterProduit_clicked()
{
    int newId;
    //préparation et exécution de la requête de l'id
    QString reqId = "SELECT ifnull(max(idProduit),0)+1 from Produits;";
    QSqlQuery maRequete1(reqId);
    //qDebug() << reqId;
    if (maRequete1.first())
    {
            newId=maRequete1.value(0).toInt();
    }

    int idRayons;
    //préparation et exécution de la requête qui récupère l'id du Rayon
    QString reqIdRayon = "SELECT idRayon FROM Rayons WHERE libelleRayon ='"+ui->comboBoxRayonDuProduit->currentText()+"';";
    QSqlQuery maRequete2(reqIdRayon);
    if (maRequete2.first())
    {
        idRayons=maRequete2.value(0).toInt();
    }

    QString txtReq = "INSERT INTO Produits(idProduit, nomProduit, idRayons, imgProduit, validProduit) VALUES (?,'"+ui->lineEditNomProduit->text()+"',?,'"+ui->lineEditLienImageProduit->text()+"', 1);";
    QSqlQuery ajoutRequete(txtReq);
    ajoutRequete.addBindValue(newId);
    ajoutRequete.addBindValue(idRayons);
    qDebug() << txtReq;

    if(ajoutRequete.exec()) //si la requête s'exécute bien
    {
        //on recharge la table
        ui->tableWidgetProduits->setRowCount(0);
        chargeTableWidgetProduits();
        //et on clear les lineEdit
        on_pushButtonClearProduit_clicked();
    }
}

void MainWindow::on_pushButtonModifierProduit_clicked()
{
    int idRayons;
    //préparation et exécution de la requête qui récupère l'id du Rayon
    QString reqIdRayon = "SELECT idRayon FROM Rayons WHERE libelleRayon ='"+ui->comboBoxRayonDuProduit->currentText()+"';";
    QSqlQuery maRequete2(reqIdRayon);
    if (maRequete2.first())
    {
        idRayons=maRequete2.value(0).toInt();
    }
    if(valid)
    {
        //préparation de la requête
        QString txtReq = "UPDATE Produits SET nomProduit ='"+ui->lineEditNomProduit->text()+"', idRayons = ? , imgProduit ='"+ui->lineEditLienImageProduit->text()+"' WHERE idProduit= ? ;";
        QSqlQuery modifRequete(txtReq);
        modifRequete.addBindValue(idRayons);
        modifRequete.addBindValue(ui->tableWidgetProduits->item(this->ligneSelectionnee,0)->text()); //récupère l'id de la ligne selectionné et l'ajoute a la requête a la place du "?"
        //qDebug() << txtReq;
        if(modifRequete.exec()) //si la requête s'exécute bien
        {
            ui->tableWidgetProduits->setRowCount(0);
            on_pushButtonClearProduit_clicked();
        }
    }
    else
    {
        //préparation de la requête
        QString txtReq = "UPDATE Produits SET nomProduit ='"+ui->lineEditNomProduit->text()+"', idRayons = ? , imgProduit ='"+ui->lineEditLienImageProduit->text()+"' WHERE idProduit= ? ;";
        QSqlQuery modifRequete(txtReq);
        modifRequete.addBindValue(idRayons);
        modifRequete.addBindValue(ui->tableWidgetProduitsPasValide->item(this->ligneSelectionnee,0)->text()); //récupère l'id de la ligne selectionné et l'ajoute a la requête a la place du "?"
        //qDebug() << txtReq;
        if(modifRequete.exec()) //si la requête s'exécute bien
        {
            ui->tableWidgetProduitsPasValide->setRowCount(0);
            on_pushButtonClearProduit_clicked();
        }
    }
}

void MainWindow::on_pushButtonSupprimerProduit_clicked()
{
    //préparation de la requête
    QString txtReq = "DELETE FROM Produits WHERE idProduit= ?";
    QSqlQuery suppRequete(txtReq);
    suppRequete.addBindValue(ui->tableWidgetProduits->item(this->ligneSelectionnee,0)->text()); //récupère l'id de la ligne selectionné et l'ajoute a la requête a la place du "?"

    if(suppRequete.exec()) //si la requête s'exécute bien
    {
        ui->tableWidgetProduits->setRowCount(0);
        on_pushButtonClearProduit_clicked();
    }
}

void MainWindow::on_pushButtonClearProduit_clicked()
{
    this->valid = -1;
    this->ligneSelectionnee = -1;
    ui->lineEditNomProduit->clear();
    ui->lineEditLienImageProduit->clear();
    ui->comboBoxRayonDuProduit->currentText().clear();
    ui->tableWidgetProduits->setRowCount(0);
    ui->tableWidgetProduitsPasValide->setRowCount(0);
    chargeTableWidgetProduits();
    chargeTableWidgetProduitsPasValide();
}

//   ******** Variété *************

void MainWindow::chargeTableWidgetVarietes()
{
    //remise a zero du contenu de la tableWidget
    this->ligneSelectionnee = -1;
    ui->tableWidgetVarietes->reset();
    //préparation et exécution de la requête
    QString txtReq="SELECT idVariete, libelleVariete, descriptionPdt, imgPdt, validPdt, nomProduit, idRayons FROM Varietes INNER JOIN Produits on Varietes.idProduit = Produits.idProduit WHERE validPdt ORDER BY libelleVariete, nomProduit";
    QSqlQuery maRequete(txtReq);

        //fixer le nombre de colonnes du tableau
        ui->tableWidgetVarietes->setColumnCount(6);
        //donnée un nom d'entête en haut de chaque colonne
        ui->tableWidgetVarietes->setHorizontalHeaderItem(0,new QTableWidgetItem("id"));
        ui->tableWidgetVarietes->setHorizontalHeaderItem(1,new QTableWidgetItem("Nom"));
        ui->tableWidgetVarietes->setHorizontalHeaderItem(2,new QTableWidgetItem("Produit"));
        ui->tableWidgetVarietes->setHorizontalHeaderItem(3,new QTableWidgetItem("Image"));
        ui->tableWidgetVarietes->setHorizontalHeaderItem(4,new QTableWidgetItem("Rayon"));
        ui->tableWidgetVarietes->setHorizontalHeaderItem(5,new QTableWidgetItem("Description"));
        //afficher les entêtes de colonne
        ui->tableWidgetVarietes->horizontalHeader()->show();
        //cacher la colonne 0(id) et 3(lien de l'image)
        ui->tableWidgetVarietes->hideColumn(0);
        ui->tableWidgetVarietes->hideColumn(3);
        ui->tableWidgetVarietes->hideColumn(4);

        //parcours des enregistrements, un par un, tant qu'il y en a
        while (maRequete.next())
        {
            //ajouter une ligne au tableau
            ui->tableWidgetVarietes->setRowCount(ui->tableWidgetVarietes->rowCount()+1);
            //écrire la valeur récupérée au bon endroit dans le tableau
            ui->tableWidgetVarietes->setItem(ui->tableWidgetVarietes->rowCount()-1,0,new QTableWidgetItem(maRequete.value("idVariete").toString()));
            ui->tableWidgetVarietes->setItem(ui->tableWidgetVarietes->rowCount()-1,1,new QTableWidgetItem(maRequete.value("libelleVariete").toString()));
            ui->tableWidgetVarietes->setItem(ui->tableWidgetVarietes->rowCount()-1,2,new QTableWidgetItem(maRequete.value("nomProduit").toString()));
            ui->tableWidgetVarietes->setItem(ui->tableWidgetVarietes->rowCount()-1,3,new QTableWidgetItem(maRequete.value("imgPdt").toString()));
            ui->tableWidgetVarietes->setItem(ui->tableWidgetVarietes->rowCount()-1,4,new QTableWidgetItem(maRequete.value("idRayons").toString()));
            ui->tableWidgetVarietes->setItem(ui->tableWidgetVarietes->rowCount()-1,5,new QTableWidgetItem(maRequete.value("descriptionPdt").toString()));
       }
}
void MainWindow::chargeTableWidgetVarietesPasValide()
{
    //remise a zero du contenu de la tableWidget
    this->ligneSelectionnee = -1;
    ui->tableWidgetVarietesPasValide->reset();
    //préparation et exécution de la requête
    QString txtReq="SELECT idVariete, libelleVariete, descriptionPdt, imgPdt, validPdt, nomProduit, idRayons FROM Varietes INNER JOIN Produits on Varietes.idProduit = Produits.idProduit WHERE not validPdt ORDER BY nomProduit, libelleVariete";
    QSqlQuery maRequete(txtReq);
    //si la requete s'exécute bien

        //fixer le nombre de colonnes du tableau
        ui->tableWidgetVarietesPasValide->setColumnCount(7);
        //donnée un nom d'entête en haut de chaque colonne
        ui->tableWidgetVarietesPasValide->setHorizontalHeaderItem(0,new QTableWidgetItem("id"));
        ui->tableWidgetVarietesPasValide->setHorizontalHeaderItem(1,new QTableWidgetItem("Nom"));
        ui->tableWidgetVarietesPasValide->setHorizontalHeaderItem(2,new QTableWidgetItem("Produit"));
        ui->tableWidgetVarietesPasValide->setHorizontalHeaderItem(3,new QTableWidgetItem("Image"));
        ui->tableWidgetVarietesPasValide->setHorizontalHeaderItem(4,new QTableWidgetItem("Rayon"));
        ui->tableWidgetVarietesPasValide->setHorizontalHeaderItem(5,new QTableWidgetItem("Validation"));
        ui->tableWidgetVarietesPasValide->setHorizontalHeaderItem(6,new QTableWidgetItem("Description"));
        //afficher les entêtes de colonne
        ui->tableWidgetVarietesPasValide->horizontalHeader()->show();
        //cacher la colonne 0(id) et 3(lien de l'image)
        ui->tableWidgetVarietesPasValide->hideColumn(0);
        ui->tableWidgetVarietesPasValide->hideColumn(3);
        ui->tableWidgetVarietesPasValide->hideColumn(4);
        ui->tableWidgetProduitsPasValide->hideColumn(6);

        //parcours des enregistrements, un par un, tant qu'il y en a
        while (maRequete.next())
        {
            //On créer le checkBox pour la validité des produits
            QCheckBox * checkVariete = new QCheckBox("Accepter",ui->tableWidgetVarietesPasValide);
            checkVariete->setProperty("noVariete",maRequete.value("idVariete").toString());
            connect(checkVariete,SIGNAL(stateChanged(int)),this,SLOT(validerVariete()));

            //ajouter une ligne au tableau
            ui->tableWidgetVarietesPasValide->setRowCount(ui->tableWidgetVarietesPasValide->rowCount()+1);
            //écrire la valeur récupérée au bon endroit dans le tableau
            ui->tableWidgetVarietesPasValide->setItem(ui->tableWidgetVarietesPasValide->rowCount()-1,0,new QTableWidgetItem(maRequete.value("idVariete").toString()));
            ui->tableWidgetVarietesPasValide->setItem(ui->tableWidgetVarietesPasValide->rowCount()-1,1,new QTableWidgetItem(maRequete.value("libelleVariete").toString()));
            ui->tableWidgetVarietesPasValide->setItem(ui->tableWidgetVarietesPasValide->rowCount()-1,2,new QTableWidgetItem(maRequete.value("nomProduit").toString()));
            ui->tableWidgetVarietesPasValide->setItem(ui->tableWidgetVarietesPasValide->rowCount()-1,3,new QTableWidgetItem(maRequete.value("imgPdt").toString()));
            ui->tableWidgetVarietesPasValide->setItem(ui->tableWidgetVarietesPasValide->rowCount()-1,4,new QTableWidgetItem(maRequete.value("idRayons").toString()));
            ui->tableWidgetVarietesPasValide->setCellWidget(ui->tableWidgetVarietesPasValide->rowCount()-1,5,checkVariete);
            ui->tableWidgetVarietesPasValide->setItem(ui->tableWidgetVarietesPasValide->rowCount()-1,6,new QTableWidgetItem(maRequete.value("descriptionPdt").toString()));

      }
}
void MainWindow::validerVariete()
{
    //qDebug() << "void MainWindow::validerVariete()";
    //préparation de la requête
    QString idVariete= sender()->property("noVariete").toString();
    QString txtReq = "UPDATE Varietes SET validPdt = 1 WHERE idVariete="+idVariete+" ;";
    //qDebug() << txtReq;
    QSqlQuery modifRequete(txtReq);
    on_pushButtonClearVariete_clicked();
    //qDebug() << "Variete valider";
}

void MainWindow::chargeComboBoxProduitDeLaVariete()
{
    //remise à zéro de la combo
    ui->comboBoxProduitDeLaVariete->clear();
    //préparation de la requête
    QString txtReq = "SELECT nomProduit, idRayons FROM Produits ORDER BY nomProduit;";
    QSqlQuery maRequete(txtReq);
    while(maRequete.next())
    {
        //ajouter l'option renvoyée par la requete au combo
        ui->comboBoxProduitDeLaVariete->addItem(maRequete.value(0).toString());
    }
}

void MainWindow::on_pushButtonAjouterVariete_clicked()
{
    int newId;
    //préparation et exécution de la requête de l'id
    QString reqId = "SELECT ifnull(max(idVariete),0)+1 from Varietes;";
    QSqlQuery maRequete1(reqId);
    //qDebug() << reqId;
    if (maRequete1.first())
    {
            newId=maRequete1.value(0).toInt();
    }

    int idProduit;
    //préparation et exécution de la requête qui récupère l'id du Rayon
    QString reqIdProduit = "SELECT idProduit FROM Produit WHERE nomProduit ='"+ui->comboBoxProduitDeLaVariete->currentText()+"';";
    QSqlQuery maRequete2(reqIdProduit);
    if (maRequete2.first())
    {
        idProduit=maRequete2.value(0).toInt();
    }

    QString txtReq = "INSERT INTO Varietes(idVariete, libelleVariete, descriptionPdt, imgPdt, idProduit, validPdt) VALUES (?,'"+ui->lineEditLibelleVariete->text()+"','"+ui->lineEditDescVariete->text()+"','"+ui->lineEditLienImageVariete->text()+"',?, 1);";
    QSqlQuery ajoutRequete(txtReq);
    ajoutRequete.addBindValue(newId);
    ajoutRequete.addBindValue(idProduit);
    qDebug() << txtReq;

    if(ajoutRequete.exec()) //si la requête s'exécute bien
    {
        //on recharge la table
        ui->tableWidgetVarietes->setRowCount(0);
        chargeTableWidgetVarietes();
        //et on clear les lineEdit
        on_pushButtonClearVariete_clicked();
    }
}

void MainWindow::on_tableWidgetVarietes_clicked(const QModelIndex &index)
{
    //qDebug() << "void MainWindow::on_tableWidgetVarietes_clicked(const QModelIndex &index)" ;
    ui->lineEditLibelleVariete->setText(ui->tableWidgetVarietes->item(index.row(),1)->text());
    //qDebug() <<"libelle ok";
    ui->lineEditDescVariete->setText(ui->tableWidgetVarietes->item(index.row(),5)->text());
    //qDebug() <<"desc ok";
    ui->lineEditLienImageVariete->setText(ui->tableWidgetVarietes->item(index.row(),3)->text());
    //qDebug() <<"image ok";
    ui->comboBoxProduitDeLaVariete->setCurrentText(ui->tableWidgetVarietes->item(index.row(),2)->text());
    //qDebug() <<"produit ok";
    this->ligneSelectionnee = index.row();
    this->valid = true;
}

void MainWindow::on_tableWidgetVarietesPasValide_clicked(const QModelIndex &index)
{
    ui->lineEditLibelleVariete->setText(ui->tableWidgetVarietesPasValide->item(index.row(),1)->text());
    ui->lineEditDescVariete->setText(ui->tableWidgetVarietesPasValide->item(index.row(),6)->text());
    ui->lineEditLienImageVariete->setText(ui->tableWidgetVarietesPasValide->item(index.row(),3)->text());
    ui->comboBoxProduitDeLaVariete->setCurrentText(ui->tableWidgetVarietesPasValide->item(index.row(),2)->text());
    this->ligneSelectionnee = index.row();
    this->valid = false;
}
void MainWindow::on_pushButtonClearVariete_clicked()
{
    this->valid = -1;
    this->ligneSelectionnee = -1;
    ui->lineEditLibelleVariete->clear();
    ui->lineEditDescVariete->clear();
    ui->lineEditLienImageVariete->clear();
    ui->comboBoxProduitDeLaVariete->currentText().clear();
    ui->tableWidgetVarietes->setRowCount(0);
    ui->tableWidgetVarietesPasValide->setRowCount(0);
    chargeTableWidgetVarietes();
    chargeTableWidgetVarietesPasValide();
}
/******* CLEAR CHANGEMENT DE PAGE *******/

void MainWindow::on_tabWidget_currentChanged(int index)
{
    on_pushButtonClearProduit_clicked();
    on_pushButtonClearRayon_clicked();
    on_pushButtonClearVariete_clicked();
}
void MainWindow::on_toolBoxProdVar_currentChanged(int index)
{
    on_pushButtonClearProduit_clicked();
    on_pushButtonClearRayon_clicked();
    on_pushButtonClearVariete_clicked();
}






