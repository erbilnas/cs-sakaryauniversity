/*
 *  ------ [ACC_1] Waspmote Accelerometer Reading acceleration --------
 *
 *  Explanation: This example shows how to get the acceleration on the
 *  different axis using the most basic functions related with Waspmote 
 *  accelerometer
 *
 *  Copyright (C) 2013 Libelium Comunicaciones Distribuidas S.L. 
 *  http://www.libelium.com 
 *  
 *  This program is free software: you can redistribute it and/or modify 
 *  it under the terms of the GNU General Public License as published by 
 *  the Free Software Foundation, either version 3 of the License, or 
 *  (at your option) any later version. 
 *  
 *  This program is distributed in the hope that it will be useful, 
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of 
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
 *  GNU General Public License for more details. 
 *  
 *  You should have received a copy of the GNU General Public License 
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>. 
 *  
 *  Version:           0.2
 *  Design:            David Gascón 
 *  Implementation:    Marcos Yarza
 */
#include <WaspSensorGas_v20.h>
#include <WaspXBeeZB.h>
#include <WaspFrame.h>
// Define BROADCAST MAC address
//////////////////////////////////////////
char RX_ADDRESS_C[] = "000000000000000000";
//////////////////////////////////////////

// Define the Waspmote ID
char WASPMOTE_ID[] = "node_01";

char FrameMessageBuffer[200]="";
// PAN ID to set in order to search a new coordinator
uint8_t  PANID[8]={ 0x00,0x00,0x00,0x00,0x00,0x00,0x00,0x00};


// define variable
uint8_t error;

void setup()
{
  
  
  
  //RTC.ON();
  ACC.ON();
  USB.ON(); // starts using the serial port
  //USB.println(F("ACC_01 example"));
  USB.println(F("Sending BROADCAST packets example"));
  
  // store Waspmote identifier in EEPROM memory
  
  frame.setID( WASPMOTE_ID );
  
  //////////////////////////
  // 1. init XBee
  //////////////////////////
  xbeeZB.ON();  
  
  pinMode(DIGITAL8 ,OUTPUT);
  pinMode(DIGITAL7 ,OUTPUT);
  pinMode(DIGITAL6 ,OUTPUT);
  pinMode(DIGITAL5 ,OUTPUT);
  pinMode(DIGITAL4 ,OUTPUT);
  pinMode(DIGITAL3 ,OUTPUT);
  pinMode(DIGITAL2 ,OUTPUT);
  pinMode(DIGITAL1 ,OUTPUT);
  delay(3000);
  

  /////////////////////////////////////
  // 1. Dissociation process
  /////////////////////////////////////
  
  // 1.1. set PANID: 0x0000000000000000 
  xbeeZB.setPAN(PANID);
  
  // 1.2. check AT command flag
  if( xbeeZB.error_AT == 0 ) 
  {
    USB.println(F("PANID set OK"));
  }
  else 
  {
    USB.println(F("Error while setting PANID")); 
  }

  // 1.3. set all possible channels to scan 
  // channels from 0x0B to 0x18 (0x19 and 0x1A are excluded)
  /* Range:[0x0 to 0x3FFF]
  * Channels are scpedified as a bitmap where depending on 
  * the bit a channel is selected --> Bit (Channel): 
  *  0 (0x0B)  4 (0x0F)  8 (0x13)   12 (0x17)
  *  1 (0x0C)  5 (0x10)  9 (0x14)   13 (0x18)
  *  2 (0x0D)  6 (0x11)  10 (0x15)  
  *  3 (0x0E)  7 (0x12)	 11 (0x16)    */
  xbeeZB.setScanningChannels(0x3F, 0xFF);

  // 1.4. check AT command flag  
  if( xbeeZB.error_AT == 0 )
  {
    USB.println(F("scanning channels set OK"));
  }
  else 
  {
    USB.println(F("Error while setting scanning channels")); 
  }
  
  // 1.5. set channel verification JV=1 in order to make the 
  // XBee module to scan new coordinator
  xbeeZB.setChannelVerification(1);
  
  // 1.6. check AT command flag    
  if( xbeeZB.error_AT == 0 )
  {
    USB.println(F("verification channel set OK"));
  }
  else 
  {
    USB.println(F("Error while setting verification channel")); 
  }

  // 1.7. write values to XBee memory
  xbeeZB.writeValues();

  // 1.8 reboot XBee module
  xbeeZB.OFF();
  delay(3000); 
  xbeeZB.ON();

  delay(3000);
  
  //////////////////////////
  // 2. check XBee's network parameters
  //////////////////////////
  ConnetAndCheckNetworkParams();
  
  
}

void loop()
{

  //----------Check Register-----------------------
  // should always answer 0x32, it is used to check
  // the proper functionality of the accelerometer
  //byte check = ACC.check();

  //----------X Value-----------------------
  int x_acc = ACC.getX();

  //----------Y Value-----------------------
  int y_acc = ACC.getY();

  //----------Z Value-----------------------
  int z_acc = ACC.getZ();

  //-------------------------------

  //USB.print(F("\n------------------------------\nCheck: 0x")); 
  //USB.println(check, HEX);
  //USB.println(F("\n \t0X\t0Y\t0Z")); 
  //USB.print(F(" ACC\t")); 
  USB.print(x_acc, DEC);
  USB.print(F(":")); 
  USB.print(y_acc, DEC);
  USB.print(F(":")); 
  USB.print(z_acc, DEC);
  USB.println(F(":")); 
  RTC.ON();
  int temp = RTC.getTemperature();
  RTC.OFF();  
  snprintf( FrameMessageBuffer, sizeof(FrameMessageBuffer),  "name:%s,temp:%d,BAT:%d,ACC:%d;%d;%d", WASPMOTE_ID, temp, (int)PWR.getBatteryLevel(),ACC.getX(), ACC.getY(), ACC.getZ());	
  
  USB.println(FrameMessageBuffer); 
  error = xbeeZB.send( RX_ADDRESS_C, FrameMessageBuffer); 
  if( error == 0 )
  {
  	#if DEBUG
    USB.println(F("send ok to C"));
    #endif
    Utils.blinkGreenLED();
  }
  else 
  {
  	#if DEBUG
    USB.println(F("send error to C")); 
    #endif
    Utils.blinkRedLED();
  }
  //delay(2000);
  reciveCommand();

 
  
}


void reciveCommand()
{
  error = xbeeZB.receivePacketTimeout( 1000 );
  
  // check answer  
  if( error == 0 ) 
  {
    // Show data stored in '_payload' buffer indicated by '_length'
    USB.print(F("Data: "));  
    USB.println( xbeeZB._payload, xbeeZB._length);
    
      byte socketNo;
      switch(xbeeZB._payload[0])
      {
        case 0x08:
        socketNo=DIGITAL8;
        break;
        case 0x07:
        socketNo=DIGITAL7;
        break;
        case 0x06:
        socketNo=DIGITAL6;
        break;
		case 0x05:
        socketNo=DIGITAL5;
        break;
		case 0x04:
        socketNo=DIGITAL4;
        break;
		case 0x03:
        socketNo=DIGITAL3;
        break;
		case 0x02:
        socketNo=DIGITAL2;
        break;
		case 0x01:
        socketNo=DIGITAL1;
        break;        
      }
      USB.println( socketNo);
      if(xbeeZB._payload[1]==1)
      {
       digitalWrite(socketNo, HIGH);
        // wait for arg/1000 seconds
      }
      else
      {
      digitalWrite(socketNo, LOW);
      }
    // Show data stored in '_payload' buffer indicated by '_length'
    USB.print(F("Length: "));  
    USB.println( xbeeZB._length,DEC);
    
    // Show data stored in '_payload' buffer indicated by '_length'
    USB.print(F("Source MAC Address: "));  
    USB.printHex( xbeeZB._srcMAC[0] );
    USB.printHex( xbeeZB._srcMAC[1] );
    USB.printHex( xbeeZB._srcMAC[2] );
    USB.printHex( xbeeZB._srcMAC[3] );
    USB.printHex( xbeeZB._srcMAC[4] );
    USB.printHex( xbeeZB._srcMAC[5] );
    USB.printHex( xbeeZB._srcMAC[6] );
    USB.printHex( xbeeZB._srcMAC[7] );
    USB.println();    
    USB.println(F("--------------------------------"));
  }
  else
  {
    // Print error message:
    /*
     * '7' : Buffer full. Not enough memory space
     * '6' : Error escaping character within payload bytes
     * '5' : Error escaping character in checksum byte
     * '4' : Checksum is not correct	  
     * '3' : Checksum byte is not available	
     * '2' : Frame Type is not valid
     * '1' : Timeout when receiving answer   
    */
    USB.print(F("Error receiving a packet:"));
    USB.println(error,DEC);     
    USB.println(F("--------------------------------"));
  }
}

/*******************************************
 *  Connect a cordinator
 *  checkNetworkParams - Check operating
 *  network parameters in the XBee module
 *  
 *******************************************/
void ConnetAndCheckNetworkParams()
{
  // 1. get operating 64-b PAN ID
  xbeeZB.getOperating64PAN();

  // 2. wait for association indication
  xbeeZB.getAssociationIndication();

  USB.println(F("Wait for association"));
  while( xbeeZB.associationIndication != 0 )
  {   
    delay(2000);
    
    printAssociationState();

    // get operating 64-b PAN ID
    xbeeZB.getOperating64PAN();

    USB.print(F("operating 64-b PAN ID: "));
    USB.printHex(xbeeZB.operating64PAN[0]);
    USB.printHex(xbeeZB.operating64PAN[1]);
    USB.printHex(xbeeZB.operating64PAN[2]);
    USB.printHex(xbeeZB.operating64PAN[3]);
    USB.printHex(xbeeZB.operating64PAN[4]);
    USB.printHex(xbeeZB.operating64PAN[5]);
    USB.printHex(xbeeZB.operating64PAN[6]);
    USB.printHex(xbeeZB.operating64PAN[7]);
    USB.println();     

    xbeeZB.getAssociationIndication();
  }

  USB.println(F("\nJoined a network!"));

  // 2.2. When XBee is associated print all network 
  // parameters unset channel verification JV=0
  xbeeZB.setChannelVerification(0);
  xbeeZB.writeValues();
  // 3. get network parameters 
  xbeeZB.getOperating16PAN();
  xbeeZB.getOperating64PAN();
  xbeeZB.getChannel();

  USB.print(F("operating 16-b PAN ID: "));
  USB.printHex(xbeeZB.operating16PAN[0]);
  USB.printHex(xbeeZB.operating16PAN[1]);
  USB.println();

  USB.print(F("operating 64-b PAN ID: "));
  USB.printHex(xbeeZB.operating64PAN[0]);
  USB.printHex(xbeeZB.operating64PAN[1]);
  USB.printHex(xbeeZB.operating64PAN[2]);
  USB.printHex(xbeeZB.operating64PAN[3]);
  USB.printHex(xbeeZB.operating64PAN[4]);
  USB.printHex(xbeeZB.operating64PAN[5]);
  USB.printHex(xbeeZB.operating64PAN[6]);
  USB.printHex(xbeeZB.operating64PAN[7]);
  USB.println();

  USB.print(F("channel: "));
  USB.printHex(xbeeZB.channel);
  USB.println();
  
  xbeeZB.getOwnNetAddress(); 
  USB.print(F("OwnNetAddress: "));
  USB.printHex(xbeeZB.sourceNA[0]);
  USB.printHex(xbeeZB.sourceNA[1]);
  USB.println();
  
  xbeeZB.getOwnMacLow(); // Get 32 lower bits of MAC Address
  xbeeZB.getOwnMacHigh(); // Get 32 upper bits of MAC Address
  USB.print(F("OwnNetAddress: "));
  USB.printHex(xbeeZB.sourceMacHigh[0]);
  USB.printHex(xbeeZB.sourceMacHigh[1]);
  USB.printHex(xbeeZB.sourceMacHigh[2]);
  USB.printHex(xbeeZB.sourceMacHigh[3]);
  USB.printHex(xbeeZB.sourceMacLow[0]);
  USB.printHex(xbeeZB.sourceMacLow[1]);
  USB.printHex(xbeeZB.sourceMacLow[2]);
  USB.printHex(xbeeZB.sourceMacLow[3]);
  USB.println();


}

/*******************************************
 *
 *  printAssociationState - Print the state 
 *  of the association flag
 *
 *******************************************/
void printAssociationState()
{
  switch(xbeeZB.associationIndication)
  {
  case 0x00  :  
    USB.println(F("Successfully formed or joined a network"));
    break;
  case 0x21  :  
    USB.println(F("Scan found no PANs"));
    break;    
  case 0x22  :  
    USB.println(F("Scan found no valid PANs based on current SC and ID settings"));
    break;    
  case 0x23  :  
    USB.println(F("Valid Coordinator or Routers found, but they are not allowing joining (NJ expired)"));
    break;    
  case 0x24  :  
    USB.println(F("No joinable beacons were found"));
    break;    
  case 0x25  :  
    USB.println(F("Unexpected state, node should not be attempting to join at this time"));
    break;
  case 0x27  :  
    USB.println(F("Node Joining attempt failed"));
    break;
  case 0x2A  :  
    USB.println(F("Coordinator Start attempt failed"));
    break;
  case 0x2B  :  
    USB.println(F("Checking for an existing coordinator"));
    break;
  case 0x2C  :  
    USB.println(F("Attempt to leave the network failed"));
    break;
  case 0xAB  :  
    USB.println(F("Attempted to join a device that did not respond."));
    break;
  case 0xAC  :  
    USB.println(F("Secure join error: network security key received unsecured"));
    break;
  case 0xAD  :  
    USB.println(F("Secure join error: network security key not received"));
    break;
  case 0xAF  :  
    USB.println(F("Secure join error: joining device does not have the right preconfigured link key"));
    break;
  case 0xFF  :  
    USB.println(F("Scanning for a ZigBee network (routers and end devices)"));
    break;
  default    :  
    USB.println(F("Unkown associationIndication"));
    break;  
  }
}
