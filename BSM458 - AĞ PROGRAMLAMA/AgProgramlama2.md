# Sanallaştırma ile Ağ ortamının hazirlanması
vmware, virtual box ... gibi sanallaştırma platformları kullanılarak uygulamalarımızı test edeceğimiz sanal makinalar oluşturulur.

Sanal makinaların haberleşebilmesi için ağ arayüzleri tanımlanmalıdır. Ağ arayüzleri üç farklı şekilde tanımlanabilir:

1. NAT (vmnet8) 
2. HostOnly (vmnet1, vboxnet0)
3. Bridged

---

# ifconfig - Ağ arayüzlerinin ayarlarını görme/değiştirme

ifconfig -- tüm ağ arayüzlerini görüntüle

ifconfig eth0 192.168.2.11 -- eth0 arayüzüne belirtilen IP adresini ata

sudo ifconfig eth0 down

sudo ifconfig eth0 up

sudo dhclient eth0     -- eth0 arayüzü için DHCP den yeni IP isteniyor

---
# ping - Hedef sistemin erişilebilirliğinin denetimi

ping 192.168.2.56   // belirtilen cihaza echo isteği gönderilir ve gelen yanıta göre gecikme (RTT) yazdırılır. 

ping 192.168.2.56 -c 3  --sadece 3 paket gönder

ping 192.168.2.56 -f --dos saldırısı

1. web sunucuya misafir makinadan bağlantı yapılması
2. tcpdump ile bu bağlantıya ait akışın görüntülenmesi
3. Dos saldırısının görüntülemesi
4. NetCat ile oluşturulan istemci ile sunucu haberleşmesinin görüntülenmesi
---

# tcpdump - ağ arayüzündeki akışın görüntülenmesi 

sudo tcpdump -i vboxnet0

sudo tcpdump -i vboxnet0 port 80
         
sudo tcpdump -i eth0 dst 173.194.116.162
         
sudo tcpdump  '(icmp or udp)' -i vboxnet0 -- sadece icmp ve udp paketlerini gösterir

sudo tcpdump -nnXSs 0 'port 80' -i vboxnet0  -- başlık ile birlikte verinin (payload) de yakalanması 

---
# netcat - soket programlarının/bağlantılarının testi

nc time.nist.gov 13 //National Institute for Standards and Technology (NIST) de bulunan zaman sunucuya istek gönderiliyor

nc -l 8001 -- sunucu (192.168.56.103) --  -u udp soketiçin kullanılır.
         
nc 192.168.56.103 8001 --istemci


nc -l -p 8000 -- windows sunucu için -p de kullanmak gerekir.
         
nc 172.16.0.138 8000
         
         
nc -l 8001 > Hedef.txt -- dosya transferi

nc 192.168.1.1 8001 <Kaynak.txt


nc -l 12345 > deneme1.txt

nc 127.0.0.1 12345 < a.txt
 

printf "GET / HTTP/1.0\r\n\r\n" | nc 192.168.56.103 80 -- web sunucudan index.html dosyası istenir

printf "GET /index1.html HTTP/1.0\r\n\r\n" | nc 192.168.56.103 80 -- web sunucudan index1.html dosyası istenir

nc -zv localhost 20-30 --port tarama
nc -zv localhost 20-80

---
# ssh - sistemlerin uzaktan yönetimi

sudo service ssh start  --Openssh sunucu servisi başlatılıyor.

ssh wsan@102.168.1.12  -- secure shell

ssh -X wsan@102.168.1.12 -- istemciye ait grafik arayüzünün kullanılabilmesi


---
# nmap - port tarama

nmap ile http, ssh ve nc portlarının taranması

nmap xyz.com.tr

nmap 192.168.96.1
         

nmap 192.168.96.1 -F --fast scan...  işletim sistemi v.s. taranmaz... sadece port açık/kapalı

nmap 192.168.96.1 -p 22 -- belirli portu tarama

-sT -- sadece TCP

-sU -- sadece UDP

-sV -- portlardaki uygulamaların uyarlama bilgiside listelensin

nmap 192.168.96.0/24 --Ağdaki tüm bilgisayarları tarar.

---
# traceroute - hedef sisteme hangi yollardan gidildiğinin bulunması

traceroute google.com

---
# netstat - ağ bağlantılarını, ağ arayüzlerine ait istatistikleri ve yönlendirme tablosunu, listeleme

cat /etc/services

netstat

netstat -n --adreslerin IP değerini gösterir-daha hızlı

netstat -nt -- tcp bağlantıları görüntüle (|grep ESTA)
  
netstat -nu -- udp bağlantıları görüntüle

netstat -i -- istatistikleri incelemek için (ping -f ile yapılan istek sayısı gözlenebilir...) 

1. web sunucuyla olan bağlantının (tarayıcıdan) görüntülenmesi ve misafir makinadan nc ile bağlantının görüntülenmesi
netstat -nt |grep :80  -- Ubuntu makinada bu ifadeyi çalıştır
