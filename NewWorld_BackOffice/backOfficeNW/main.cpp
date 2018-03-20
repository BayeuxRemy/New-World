#include "mainwindow.h"
#include "dialogconnect.h"
#include <QDebug>
#include <QApplication>
#include <QSqlDatabase>  // nécessaire pour utiliser un QSqlDatabase

int main(int argc, char *argv[])
{
    QApplication a(argc, argv);
    DialogConnect connect;

    //initialisation de la base de données
     QSqlDatabase maBase;
     maBase=QSqlDatabase::addDatabase("QMYSQL");
     maBase.setHostName("localhost");
     maBase.setUserName("root");
     maBase.setPassword("");
     maBase.setDatabaseName("newWorld");

     maBase.open();
     //qDebug() << "maBase.open()";

     if (connect.exec()==QDialog::Accepted)
     {
         qDebug() << "connect.exec()";
         MainWindow w (&connect);
         w.show();
         return a.exec();
     }
}
