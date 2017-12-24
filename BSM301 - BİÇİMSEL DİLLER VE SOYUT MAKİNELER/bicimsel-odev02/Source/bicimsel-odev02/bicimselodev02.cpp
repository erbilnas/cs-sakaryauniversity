#include "stdafx.h"
#include <string>
#include <iostream>

using namespace std;


void control(const char *usr_inp, int len) {
	int INVALID_INPUT_FLAG = 0;
	int invalid_string = 0;
	int count_aa = 0;
	int count_bb = 0;
	char pre = ' ';

	for (int i = 0; i < len; i = i + 2) {
		switch (usr_inp[i]) {
		case 'a':
			if (pre == 'a') {
				count_aa++;
				pre = usr_inp[i + 1];
			}
			else {
				i = i - 1;
				pre = 'a';
			}

			break;
		case 'b':
			if (pre == 'b') {
				count_bb++;
				pre = usr_inp[i + 1];
			}
			else {
				i = i - 1;
				pre = 'b';
			}

			break;
		default:
			INVALID_INPUT_FLAG = 1;
			break;
		}
	}


	if ((count_aa + count_bb - 1) != 0)
		invalid_string = 1;

	if (INVALID_INPUT_FLAG == 1)
		cout << "Lutfen {a,b} alfabesi üzerinde tanimlanmis bir katar giriniz." << endl << endl;
	else if (invalid_string == 1)
		cout << "Girdiginiz katari dil kabul etmiyor." << endl << endl;
	else
		cout << "Dil kabul ediyor." << endl << endl;

}


int main()
{
	string user_input;
	cout << "Lutfen karakter katarini giriniz: ";
	cin >> user_input;

	control(user_input.c_str(), user_input.length());

	system("pause");

    return 0;
}

