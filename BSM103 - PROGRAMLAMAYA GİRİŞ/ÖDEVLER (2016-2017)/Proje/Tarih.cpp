#include "Tarih.h"
#include <iostream> 
#include <string>
#include <fstream>
#include <cstdlib>
#include <time.h>

using namespace std;

string gun, ay, yil, tarih;

Tarih::Tarih() {
	mGun = gunUret();
	mAy = ayUret();
	mYil = yilUret();
	mTarih = tarihUret();
}

string Tarih::gunGetir() {
	srand(time(NULL));
	mGun = rand() % 30;
	return mGun;
}

string Tarih::ayGetir() {
	srand(time(NULL));
	mAy = rand() % 12;
	return mAy;
}

string Tarih::yilGetir() {
	srand(time(NULL));
	mYil = 1900 + rand() % 10;
	return mYil;
}

string Tarih::tarihGetir() {
	return mTarih;
}

string Tarih::gunUret() {
	for (int i = 0; i < 1; i++) {
		gun += '1' + rand() % 30;
	}
	return gun;
}

string Tarih::ayUret() {
	for (int i = 0; i < 2; i++) {
		ay += '1' + rand() % 12;
	}
	return ay;
}

string Tarih::yilUret() {
	for (int i = 0; i < 1; i++) {
		yil += 1900 + (rand() % 10);
	}
	return yil;
}

string Tarih::tarihUret() {
	return tarih;
}

void Tarih::gunAta(std::string gun) {
	mGun = gun;
}

void Tarih::ayAta(std::string ay) {
	mAy = ay;
}

void Tarih::yilAta(std::string yil) {
	mYil = yil;
}

void Tarih::tarihAta(std::string tarih) {
	mTarih = tarih;
}