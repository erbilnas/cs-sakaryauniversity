hepsi: derle calistir

derle:
	gcc -I ./include/ -o ./lib/Random.o -c ./src/Random.c
	gcc -I ./include/ -o ./lib/RastgeleKarakter.o -c ./src/RastgeleKarakter.c
	gcc -I ./include/ -o ./bin/test ./lib/Random.o ./lib/RastgeleKarakter.o ./src/test.c

calistir:
	./bin/test
