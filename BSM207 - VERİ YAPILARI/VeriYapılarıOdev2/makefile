all:derle calistir

derle:
	g++ -I ./include -o ./lib/Dugum.o -c ./src/Dugum.cpp
	g++ -I ./include -o ./lib/Sayi.o -c ./src/Sayi.cpp
	g++ -I ./include -o ./lib/BagilListe.o -c ./src/BagilListe.cpp
	g++ -I ./include -o ./lib/Islem.o -c ./src/Islem.cpp
	g++ -I ./include -o ./lib/Test.o -c ./src/Test.cpp
	g++ -I ./include ./src/Dugum.cpp ./src/Sayi.cpp ./src/BagilListe.cpp ./src/Islem.cpp ./src/Test.cpp -o ./bin/Test
calistir:
	./bin/Test