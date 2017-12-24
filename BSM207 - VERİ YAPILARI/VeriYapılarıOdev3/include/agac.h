#ifndef AGAC_H
#define AGAC_H

#include <iostream>
using namespace std;

class ikiliAgac {
public:
	ikiliAgac() {
		elemanlar = new int[100];
		for (int i = 0; i<100; i++) indexKapasite[i] = 0;
	}

	~ikiliAgac() {
		delete[] elemanlar;
	}

	void ekleme(const int& eleman) {
		int index = 0;
		while (true) {
			if (indexKapasite[index] == 0) {
				elemanlar[index] = eleman;
				indexKapasite[index] = 1;
				break;
			} else if (eleman < elemanlar[index]) index = 2 * index + 1;
			else if (eleman > elemanlar[index]) index = 2 * index + 2;
		}
	}

	void inorder(int index = 0) {
		if (indexKapasite[index] != 0) {
			inorder(2 * index + 1);
			cout << elemanlar[index] << " "; inorder(2 * index + 2);
		}
	}

	void preorder(int index = 0) {
		if (indexKapasite[index] != 0) {
			cout << elemanlar[index] << " ";
			preorder(2 * index + 1); preorder(2 * index + 2);
		}
	}

	void postorder(int index = 0) {
		if (indexKapasite[index] != 0) {
			postorder(2 * index + 1); postorder(2 * index + 2);
			cout << elemanlar[index] << " ";
		}
	}

private:
	int *elemanlar;
	int indexKapasite[100];
};
#endif