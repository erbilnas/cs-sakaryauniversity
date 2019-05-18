tcpdump ile istemci sunucu arasındaki trafiği görüntüle. Sıkıştırılmadan iletildiği için mesaj görüntülenecektir.

sudo tcpdump -nnXSs 0 'port 8080' -i lo0