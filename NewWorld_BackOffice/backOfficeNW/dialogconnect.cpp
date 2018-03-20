#include "dialogconnect.h"
#include "ui_dialogconnect.h"
#include <QSqlQuery> // necessaire pour les QrequeteSql
#include <QDebug>

DialogConnect::DialogConnect(QWidget *parent) :
    QDialog(parent),
    ui(new Ui::DialogConnect)
{
    ui->setupUi(this);

}

DialogConnect::~DialogConnect()
{
    delete ui;
}

void DialogConnect::on_pushButtonConnexion_clicked()
{
    qDebug() << "void DialogConnect::on_pushButtonConnexion_clicked()";

    //préparation de la requête
    QString txtReq="SELECT idEmploye, nom, prenom FROM Employe WHERE password='"+ui->lineEditPassword->text()+"' and  identifiant='"+ui->lineEditIdentifiant->text()+"';";
    QSqlQuery maRequete(txtReq);
     //qDebug() << txtReq;
    //si la requête s'éxécute bien
    if (maRequete.exec())
    {
        //qDebug() <<"if(maRequete.exec())";
        //si elle ne renvoie qu'une ligne
        if(maRequete.numRowsAffected()==1)
        {
            maRequete.first();
            //récupération du nom et prenom de l'employé
            this->nom=maRequete.value("nom").toString();
            this->prenom=maRequete.value("prenom").toString();
            //alors connexion
            qDebug()<<"Accept()";
            accept();
        }
        //sinon message d'erreur
        else
        {
            ui->labelIdentifiant->setStyleSheet("color:red;");
            ui->labelPassword->setStyleSheet("color:red;");
            ui->labelMessage->setText("Les informations saisies sont erronées");
            ui->labelMessage->setStyleSheet("color:red;");
        }
    }
    //sinon message d'erreur
    else
    {
        ui->labelMessage->setText("Erreur de connexion");
        ui->labelMessage->setStyleSheet("color:red;");
    }
}

void DialogConnect::on_pushButtonClose_clicked()
{
    reject();
}

void DialogConnect::on_lineEditIdentifiant_textChanged(const QString &arg1)
{
    ui->labelMessage->clear();
    ui->labelIdentifiant->setStyleSheet("color:black;");

    if (ui->lineEditIdentifiant->text().size()>0 or ui->lineEditPassword->text().size()>0)
    {
        ui->pushButtonConnexion->setEnabled(true);

    }
    if (ui->lineEditIdentifiant->text().size()==0 or ui->lineEditPassword->text().size()==0)
    {
        ui->pushButtonConnexion->setEnabled(false);
    }

}

void DialogConnect::on_lineEditPassword_textChanged(const QString &arg1)
{
    ui->labelMessage->clear();
    ui->labelPassword->setStyleSheet("color:black;");

    if (ui->lineEditIdentifiant->text().size()>0 or ui->lineEditPassword->text().size()>0)
    {
        ui->pushButtonConnexion->setEnabled(true);
    }
    if (ui->lineEditIdentifiant->text().size()==0 or ui->lineEditPassword->text().size()==0)
    {
        ui->pushButtonConnexion->setEnabled(false);
    }

}
