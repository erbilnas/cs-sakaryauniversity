/********************************************************************************************************************
** SAKARYA ÜNİVERSİTESİ
** BİLGİSAYAR VE BİLİŞİM BİLİMLERİ FAKÜLTESİ
** BİLGİSAYAR MÜHENDİSLİĞİ BÖLÜMÜ
** PROGRAMLAMAYA GİRİŞ DERSİ
** 2016-2017 GÜZ DÖNEMİ
**
** ÖDEV NUMARASI..........: 02
** ÖĞRENCİ ADI............: ERBİL NAS
** ÖĞRENCİ NUMARASI.......: B151210053
** DERSİN ALINDIĞI GRUP...: D GRUBU
**
** ÖDEVİN KONUSU..........: BİR ÇİZGİ ÜZERİNDE HAREKET EDEBİLEN İŞARET (BASİT ANİMASYON)
********************************************************************************************************************/

#include <iostream>
#include <iomanip>
#include <locale>
#include <string>
#include <Windows.h>

using namespace std;

enum COLORS /*Colors enumeration*/
{
	BLACK = 0,
	BLUE = 1,
	GREEN = 2,
	CYAN = 3,
	RED = 4,
	MAGENTA = 5,
	BROWN = 6,
	LIGHTGRAY = 7,
	DARKGRAY = 8,
	LIGHTBLUE = 9,
	LIGHTGREEN = 10,
	LIGHTCYAN = 11,
	LIGHTRED = 12,
	LIGHTMAGENTA = 13,
	YELLOW = 14,
	WHITE = 15,
};

void showColor(int textColor) /*This function help us to get colored text*/
{
	int background = 0;
	int lastColor;

	lastColor = (16 * background) + textColor;

	SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), lastColor);
}

void showChar(char chr, COLORS color) /*This function write colored text to screen*/
{
	showColor(color);
	cout << chr;
	showColor(WHITE);
}

int main()
{	
	char symbol; /*Definitions*/
	int length, speed;
	int index = 0;

	cout << "Enter the character......:"; cin >> symbol;
	cout << "Length of the array......:"; cin >> length;
	cout << "Speed of animation (must be between 1-10!)..:"; cin >> speed;
	
	char* array = new char[length]; /*Created a new array which type of char*/

	for (int i = 0; i <= length; i++) { /*A for loop for adding your symbol to each area of array*/
		array[i] = symbol;
	}

	while (true) {
		for (int i = 0; i < length; i++) { /*Animation started to the left side*/
			system("cls");

			for (int j = 0; j < length; j++) { /*A for loop started from 0 until it's equal to length value*/
				if (index == j) /*If index value equal to j value, show colored '>' on the screen*/
				{
					array[index] = '>';
					showChar(array[index], WHITE);
					array[j] = symbol;
				}

				else /*Else show the symbol which selected by user*/
				{
					showChar(array[j], GREEN);
				}
			}

			++index;

			/*A switch-case build for choosing speed of animation*/
			switch (speed)
			{
			case 1: Sleep(500);
				break;
			case 2: Sleep(450);
				break;
			case 3: Sleep(400);
				break;
			case 4: Sleep(350);
				break;
			case 5: Sleep(300);
				break;
			case 6: Sleep(250);
				break;
			case 7: Sleep(200);
				break;
			case 8: Sleep(150);
				break;
			case 9: Sleep(100);
				break;
			case 10: Sleep(50);
				break;
			default: cout << "Please, enter a valid number. Number of speed must be between 1 and 10!" << endl; /*Throw an error message if user isn't entered correct value of speed*/
				break;
			}
		}

		for (int a = 0; a < length; a++) { /*Animation started to the right side*/
			system("cls");

			for (int b = 0; b < length; b++) { /*A for loop started from 0 until it's equal to length value*/
				if (index == b+1) /*If index value equal to b+1 value, show colored '<' on the screen*/
				{
					array[index] = '<';
					showChar(array[index], WHITE);
					array[b+1] = symbol;
				}

				else /*Else show the symbol which selected by user*/
				{
					showChar(array[b], GREEN);
				}
			}

			index--;

			/*A switch-case build for choosing speed of animation*/
			switch (speed)
			{
			case 1: Sleep(500);
				break;
			case 2: Sleep(450);
				break;
			case 3: Sleep(400);
				break;
			case 4: Sleep(350);
				break;
			case 5: Sleep(300);
				break;
			case 6: Sleep(250);
				break;
			case 7: Sleep(200);
				break;
			case 8: Sleep(150);
				break;
			case 9: Sleep(100);
				break;
			case 10: Sleep(50);
				break;
			default: cout << "Please, enter a valid number. Number of speed must be between 1 and 10!" << endl; /*Throw an error message if user isn't entered correct value of speed*/
				break;
			}
		}
	}

	return 0;
}