#ifndef DIALOGCONNECT_H
#define DIALOGCONNECT_H

#include <QDialog>

namespace Ui {
class DialogConnect;
}

class DialogConnect : public QDialog
{
    Q_OBJECT

public:
    explicit DialogConnect(QWidget *parent = 0);
    ~DialogConnect();
    QString nom;
    QString prenom;

private slots:
    void on_pushButtonConnexion_clicked();

    void on_pushButtonClose_clicked();

    void on_lineEditIdentifiant_textChanged(const QString &arg1);

    void on_lineEditPassword_textChanged(const QString &arg1);

private:
    Ui::DialogConnect *ui;
};

#endif // DIALOGCONNECT_H
