import matplotlib.pyplot as plt
import json


def YonetimKontrolData():
    print("YonetimKontrolData")
    labels = 'Yonetim', 'Kontrol', 'Data'
    sizes = [17315, 95864, 9604]
    explode = (0.1, 0.1, 0.1)  # only "explode" the 2nd slice (i.e. 'Hogs')

    fig1, ax1 = plt.subplots()
    ax1.pie(sizes, explode=explode, labels=labels, autopct='%1.1f%%',
            shadow=True, startangle=90)
    ax1.axis('equal')  # Equal aspect ratio ensures that pie is drawn as a circle.

    plt.title('Yonetim - Kontrol - Data')

    plt.show()


def Kontrol():
    print("Kontrol data")
    labels = 'RTS', 'CTS', 'ACK'
    sizes = [44684, 37372, 13286]
    explode = (0.1, 0.1, 0.1)  # only "explode" the 2nd slice (i.e. 'Hogs')

    fig1, ax1 = plt.subplots()
    ax1.pie(sizes, explode=explode, labels=labels, autopct='%1.1f%%',
            shadow=True, startangle=90)
    ax1.axis('equal')  # Equal aspect ratio ensures that pie is drawn as a circle.
    plt.title('RTS - CTS - ACK')

    plt.show()


def rssi():
    db = []
    time = []
    i = 0
    print("rssi")
    with open('rssi') as json_file:
        data = json.load(json_file)
        for p in data:
            #print(p["_source"]["layers"]["wlan_radio"]["wlan_radio.signal_dbm"])
            db.append(int(p["_source"]["layers"]["wlan_radio"]["wlan_radio.signal_dbm"]))
            time.append(i)
            i += 1

    plt.plot(time, db, color='g')
    plt.ylabel('dB')
    plt.title('RSSI - Sinyal Gucu')
    plt.show()


def dataRate():
    db = []
    time = []
    i = 0
    print("dataRate")
    with open('rssi') as json_file:
        data = json.load(json_file)
        for p in data:
            db.append(str(p["_source"]["layers"]["wlan_radio"]["wlan_radio.data_rate"]))
            time.append(i)
            i += 1

    plt.plot(time, db, color='g')
    plt.ylabel('Mb/s')
    plt.title('Data Rate')
    plt.show()


def fizikselPaketBuyukluk():
    db = []
    time = []
    i = 0
    print("fizikselPaketBuyukluk")
    with open('rssi') as json_file:
        data = json.load(json_file)
        for p in data:
            #print(p["_source"]["layers"]["wlan_radio"]["wlan_radio.signal_dbm"])
            db.append(str(p["_source"]["layers"]["frame"]["frame.cap_len"]))
            time.append(i)
            i += 1

    #plt.plot(time, db, color='g')
    #plt.ylabel('Byte')
    plt.title('fizikselPaketBuyukluk')

    num_bins = 10
    n, bins, patches = plt.hist(db, num_bins, facecolor='blue', alpha=0.5)
    plt.show()


def phyDataRate():
    db = []
    time = []
    i = 0
    print("phyDataRate")
    with open('rssi') as json_file:
        data = json.load(json_file)
        for p in data:
            #print(p["_source"]["layers"]["wlan_radio"]["wlan_radio.signal_dbm"])
            db.append(str(p["_source"]["layers"]["wlan_radio"]["wlan_radio.data_rate"]))
            time.append(i)
            i += 1

    plt.title('fizikselPaketBuyukluk')

    num_bins = 10
    n, bins, patches = plt.hist(db, num_bins, facecolor='blue', alpha=0.5)
    plt.show()



YonetimKontrolData()
Kontrol()
rssi()
dataRate()
phyDataRate()
fizikselPaketBuyukluk()
