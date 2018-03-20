#-------------------------------------------------
#
# Project created by QtCreator 2017-11-17T10:24:19
#
#-------------------------------------------------

QT       += core gui sql

greaterThan(QT_MAJOR_VERSION, 4): QT += widgets

TARGET = backOfficeNW
TEMPLATE = app


SOURCES += main.cpp\
        mainwindow.cpp \
    dialogconnect.cpp

HEADERS  += mainwindow.h \
    dialogconnect.h

FORMS    += mainwindow.ui \
    dialogconnect.ui
