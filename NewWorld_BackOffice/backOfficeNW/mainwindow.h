#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QCheckBox>
#include <QMainWindow>
#include "dialogconnect.h"

namespace Ui {
class MainWindow;
}

class MainWindow : public QMainWindow
{
    Q_OBJECT

public:
    explicit MainWindow(DialogConnect *lEmploye, QWidget *parent = 0);
    ~MainWindow();

private slots:

    /*** MENU RAYON ***/

    void on_tableWidgetRayons_clicked(const QModelIndex &index);

    void on_pushButtonAjouterRayon_clicked();

    void on_pushButtonClearRayon_clicked();

    void on_pushButtonSupprimerRayon_clicked();

    void on_pushButtonModifierRayon_clicked();

   /*** MENU PRODUIT ***/

    void on_tableWidgetProduits_clicked(const QModelIndex &index);

    void on_pushButtonAjouterProduit_clicked();

    void on_pushButtonModifierProduit_clicked();

    void on_pushButtonSupprimerProduit_clicked();

    void on_pushButtonClearProduit_clicked();

    void on_tabWidget_currentChanged(int index);

    void validerProduit();

    void on_tableWidgetProduitsPasValide_clicked(const QModelIndex &index);

    void on_toolBoxProdVar_currentChanged(int index);

    /*** MENU VARIETE ***/

    void validerVariete();

    void on_pushButtonClearVariete_clicked();

    void on_pushButtonAjouterVariete_clicked();

    void on_tableWidgetVarietes_clicked(const QModelIndex &index);

    void on_tableWidgetVarietesPasValide_clicked(const QModelIndex &index);

private:
    Ui::MainWindow *ui;

    QCheckBox * checkProduit;
    QCheckBox * checkVariete;

    int ligneSelectionnee;
    bool valid;

    /*** MENU RAYON **/
    void chargeTableWidgetRayons();
    void chargeListeDesProduits();

    /*** MENU PRODUIT ***/
    void chargeTableWidgetProduits();
    void chargeComboBoxRayonDuProduit();
    void chargeTableWidgetProduitsPasValide();

    /*** MENU VARIETE ***/
    void chargeTableWidgetVarietes();
    void chargeTableWidgetVarietesPasValide();
    void chargeComboBoxProduitDeLaVariete();
};

#endif // MAINWINDOW_H
