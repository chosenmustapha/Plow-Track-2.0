/* PLOWTRACKS TRACKING DEVICE 
 *  BUFFALO STATE COLLEGE
 *  SENIOR DESIGN PROJECT
 *  CODE WRITTEN BY RICHARD ADDISAH, KEVIN DAO, MUSTAPHA BARRIE AND ERIC BIRINDAYVYI
 *  THIS PEICE OF CODE COLLECTS LATITUDINAL AND LONGITUDINAL GPS COORDINATES AND THEN SENDS THE LOCATION DATA TO A CELL PHONE VIA SMS.
 */
#include <stdio.h>
#include <string.h>
#include "stdlib.h" 
#include <LiquidCrystal.h> // This library is used for the LCD device
#include <String.h> // this library is used to manipulate strings
#include <Adafruit_GPS.h> //this library is uded for the adafruit gps device. Make sure you have installed the library form the adafruit site above
#include <SoftwareSerial.h> //Load the Software Serial Library. this serial is used to communicate between GPS and arduino
#define mySerialh Serial1 // this selects hardware serial two. 
 
Adafruit_GPS GPS(&mySerialh); //Create GPS object

SoftwareSerial mySerials(10, 11); // these pins connenct GSM to arduino
LiquidCrystal lcd(50, 51, 5, 4, 3, 2); // these pins connect lcd to arduino

 
 
float latitude;  // latitudes are stored in this variable
float longitude;  // longitudes are stored in this variable
int lcdloader = 16;
char url[200];
char lati[15];
char longi[15];



char c;       //Used to read the characters spewing from the GPS module

void setup()  
{
  
  lcd.begin(16, 2);   // turn on lcd
  pinMode[9,OUTPUT];
  Serial.begin(19200);  //Turn on the Serial Monitor
  GPS.begin(9600);  // turn on GPS
  mySerials.begin(19200); // turn on software serial for GSM
  powerUp();
  delay(10000);
  mySerialh.begin(9600); // turn on hardware serial for GPS
  GPS.sendCommand("$PGCMD,33,0*6D"); // Turn Off GPS Antenna Update
  GPS.sendCommand(PMTK_SET_NMEA_OUTPUT_RMCGGA); //Tell GPS we want only $GPRMC and $GPGGA NMEA sentences
  GPS.sendCommand(PMTK_SET_NMEA_UPDATE_1HZ);   // 1 Hz update rate
  delay(500);  //Pause
   
}

void powerUp()
{
 pinMode(9, OUTPUT); 
 digitalWrite(9,LOW);
 delay(1000);
 digitalWrite(9,HIGH);
 delay(2000);
 digitalWrite(9,LOW);
 delay(3000);
}

void loop()      // run over and over again
{
readGPS();  //This is a function we define below which reads two NMEA sentences from GPS


 

 if (GPS.fix) // checks to see if GPS has connected to satelite and is recieving useful data
 {
    lcd.setCursor(0,0);
      lcd.print("GPS Conected");
      lcd.cursor();
      delay(500);
      lcd.noCursor();
      delay(500);
  
      
     // lcd.print("Conected"); 
     // delay(200);

  
// Serial.println("Connected");
//  Serial.print("Fix: "); Serial.print((int)GPS.fix);
 // Serial.print(" quality: "); Serial.println((int)GPS.fixquality);
//  Serial.print("Satellites: "); Serial.println((int)GPS.satellites);

  
//  Serial.print("Location (in degrees, works with Google Maps): ");
   //   Serial.print(GPS.latitudeDegrees, 4);
 ///     Serial.print(", "); 
   //   Serial.println(GPS.longitudeDegrees, 4);
   
 latitude= GPS.latitudeDegrees; // store the current latitude into the variable called latitude
 longitude = GPS.longitudeDegrees; // store the current longitude into a variable called latitude
 //Serial.print(" Latitude =  "); Serial.println(latitude,4);
 
// Serial.print(" Longitude =  ");Serial.println(longitude,4);
// Serial.print(" "); 

dtostrf(latitude,8,6,lati);
dtostrf(longitude,8,6,longi);

strcpy(url, "AT+HTTPPARA=\"URL\",\"plowtrackscom.000webhostapp.com/dat_logger.php?latitude=");
strcat(url,lati);
strcat(url, "&longitude=");
strcat(url,longi);
strcat(url, "\" ");
 


 if (mySerials.available())
   Serial.write(mySerials.read());

   
 mySerials.println("AT+CSQ");
 delay(100);
// ShowSerialData();// this code is to show the data from gprs shield, in order to easily see the process of how the gprs shield submit a http request, and the following is for this purpose too.
 mySerials.println("AT+CGATT?");
 delay(100);
// ShowSerialData();
 mySerials.println("AT+SAPBR=3,1,\"CONTYPE\",\"GPRS\"");//setting the SAPBR, the connection type is using gprs
 delay(1000);
// ShowSerialData();
 mySerials.println("AT+SAPBR=3,1,\"APN\",\"wholesale\"");//setting the APN, the second need you fill in your local apn server
 delay(3000);
// ShowSerialData();
 mySerials.println("AT+SAPBR=1,1");//setting the SAPBR, for detail you can refer to the AT command mamual
 delay(1000);
 //ShowSerialData();
 mySerials.println("AT+HTTPINIT"); //init the HTTP request
 delay(2000); 
// ShowSerialData();
  
 
 mySerials.println(url);// you want to access
 
 
 delay(2000);
 //ShowSerialData();
 mySerials.println("AT+HTTPACTION=0");//submit the request 
 delay(3000);//the delay is very important, the delay time is base on the return from the website, if the return datas are very large, the time required longer.
 //ShowSerialData();
 mySerials.println("AT+HTTPREAD");// read the data from the website you access
 delay(300);
 //ShowSerialData();
 mySerials.println("");
 delay(100);

}

  
  else{

   lcd.setCursor(0,0);
      lcd.print(" ***LOADING***  ");
      lcd.cursor();
      delay(500);
      lcd.noCursor();
      delay(500);
  
      lcd.setCursor(2,1);
     
      delay(200);
     for( int count=0;count<lcdloader;count++){
     lcd.setCursor(count,1);
     lcd.print(">");
      delay(400);
     }
      int count=0;
       for( int count=0;count<lcdloader;count++){
      lcd.setCursor(count,1);
      lcd.print(" ");
      delay(400);
  }  
  delay(800);
  } 
  
}



void clearGPS() {  //Since between GPS reads, we still have data streaming in, we need to clear the old data by reading a few sentences, and discarding these
while(!GPS.newNMEAreceived()) {
  c=GPS.read();
  }
GPS.parse(GPS.lastNMEA());
while(!GPS.newNMEAreceived()) {
  c=GPS.read();
  }
GPS.parse(GPS.lastNMEA());

}

void readGPS(){  //This function will read and remember two NMEA sentences from GPS
  clearGPS();    //Serial port probably has old or corrupt data, so begin by clearing it all out
  while(!GPS.newNMEAreceived()) { //Keep reading characters in this loop until a good NMEA sentence is received
  c=GPS.read(); //read a character from the GPS
  }
GPS.parse(GPS.lastNMEA());  //Once you get a good NMEA, parse it

while(!GPS.newNMEAreceived()) {  //Go out and get the second NMEA sentence, should be different type than the first one read above.
  c=GPS.read();
  }
GPS.parse(GPS.lastNMEA());
}
void ShowSerialData()
{
 while(mySerials.available()!=0)
   Serial.write(mySerials.read());
}

