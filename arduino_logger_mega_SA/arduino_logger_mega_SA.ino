/*-----------------------------------------------------------------------------------------------------------
    WEATHER LOGGER
      Code by:
           Ingrid Navarro
      Contributions by:
          Renato González, Daniela Zacarías
    DESCRIPTION:
          Arduino Mega logger
    LIBRARIES:
      DHT11 - humidity and temperature sensor library.
          - http://playground.arduino.cc/Main/DHT11Lib
      SFE_BMP180.h -
          -
      TinyGPS - GPS library
          - https://github.com/mikalhart/TinyGPS
      Wire  - I2C for barometric and acelerometer libraries
          -
    Modules
      -GPRS SIM800L
      -GPSS6MV1
      -
      -
      -
      -
  ------------------------------------------------------------------------------------------------------------*/
#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <DHT_U.h>
#include <SoftwareSerial.h>
#include <SFE_BMP180.h>
#include "Wire.h"
#include <TinyGPS.h>
#include "I2Cdev.h"
#include "MPU6050_6Axis_MotionApps20.h"

MPU6050 mpu;   //Aclerómeter definition

DHT_Unified dht(8, DHT11);  //--Temperature sensor definition (pin and type).
#define DEFAULT_TIMEOUT 5   //GPRS waitForResponse timeout
#define OUTPUT_READABLE_YAWPITCHROLL  //MPU Constant

//MPU Variables
bool blinkState = false;
float Xaxis;
float Yaxis;
float Zaxis;
bool XLock = false;
bool ZLock = false;
// MPU control/status vars
bool dmpReady = false;  // set true if DMP init was successful
uint8_t mpuIntStatus;   // holds actual interrupt status byte from MPU
uint8_t devStatus;      // return status after each device operation (0 = success, !0 = error)
uint16_t packetSize;    // expected DMP packet size (default is 42 bytes)
uint16_t fifoCount;     // count of all bytes currently in FIFO
uint8_t fifoBuffer[64]; // FIFO storage buffer
// orientation/motion vars
Quaternion q;           // [w, x, y, z]         quaternion container
VectorInt16 aa;         // [x, y, z]            accel sensor measurements
VectorInt16 aaReal;     // [x, y, z]            gravity-free accel sensor measurements
VectorInt16 aaWorld;    // [x, y, z]            world-frame accel sensor measurements
VectorFloat gravity;    // [x, y, z]            gravity vector
float euler[3];         // [psi, theta, phi]    Euler angle container
float ypr[3];           // [yaw, pitch, roll]   yaw/pitch/roll container and gravity vector

//--UV sensor variables.
int outUV = A0;             //--Sensor output based on the reference.
int ref_3V3 = A1;           //--3.3 V.
int refLevel = 0;           //--Reference Level.
int uvLevel = 0;            //--UV Level.
float outputVoltage = 0;    //--Output Voltage.

//--BM180 variables
SFE_BMP180 pressure;        //--BMP180 object.
double baseline;            //--Baseline pressure.

//GPS variables
float lat,lng;
int year;
byte month, day,hour,minute,second,hundreths;

TinyGPS gps;  //GPS

//--
unsigned long periodTime;
uint32_t delayms;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                          GPRS Cmd Functions                                              //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * This functions are used to send the sensors data throught the GPRS via HTTP Conection.
 */
//This function is used to send the cmd from Arduino MEGA to the GPRS Module
void sendCmd(String cmd) {
  const char *comando = cmd.c_str(); //Concatenate the String to write it to the Serial 1
  Serial1.write(comando);
}

//This function wait for response of the cmd send to the GPRS Module
int waitForResp(const char *resp, unsigned int timeout){
  int len = strlen(resp);
  int sum = 0;
  unsigned long timerStart, timerEnd;
  timerStart = millis();
  while(1){
    if(Serial1.available()){
      char c = Serial1.read();
      sum = (c==resp[sum]) ? sum+1 : 0;
      if(sum == len)break;
    }
    timerEnd = millis();
    if(timerEnd - timerStart > 1000 * timeout){
      return -1;
    }
  }
  while(Serial1.available()){
    Serial1.read();
  }
  return 0;
}

//Function to send cmd and wait for response in the GPRS Module
int sendCmdAndWaitForResp(String cmd, const char *resp, unsigned timeout) {
  sendCmd(cmd);
  return waitForResp(resp, timeout);
}

//GPRS Cmds to inicialize the GPRS Module. The format for GPRS is AT Comands
void gprsInit() {
  //Cmd = AT  to test conection with GPRS Module
  if(0 != sendCmdAndWaitForResp("AT\r\n","OK",DEFAULT_TIMEOUT)){
    Serial.println("ERROR at AT");
  } else {
    Serial.println("AT Enviado Correctamente");
  }
  delay(500);
  //Set conection type to GPRS. Wait for OK response.
  if(0 != sendCmdAndWaitForResp("AT+SAPBR=3,1,\"Contype\",\"GPRS\"\r\n","OK",DEFAULT_TIMEOUT)){
    Serial.println("ERROR al enviar SAPBR CONTYPE");
  }else {
    Serial.println("SAPBR Enviado Correctamente");
  }
  //Set the APN. Network:internet.movistar.mx; Wait for OK response.
  if(0 != sendCmdAndWaitForResp("AT+SAPBR=3,1,\"APN\",\"internet.movistar.mx\"\r\n","OK",DEFAULT_TIMEOUT)){
    Serial.println("ERROR al enviar SAPBR APN");
  }else {
    Serial.println("SAPBR Enviado Correctamente");
  }
  delay(500);
  //Set user of APN. User: movistar; Wait for OK response.
  if(0 != sendCmdAndWaitForResp("AT+SAPBR=3,1,\"USER\",\"movistar\"\r\n","OK",DEFAULT_TIMEOUT)){
    Serial.println("ERROR al enviar SAPBR USER");
  }else {
    Serial.println("SAPBR Enviado Correctamente");
  }
  delay(500);
  //Set password of APN. PWD: movistar; Wait for OK response.
  if(0 != sendCmdAndWaitForResp("AT+SAPBR=3,1,\"PWD\",\"movistar\"\r\n","OK",DEFAULT_TIMEOUT)){
    Serial.println("ERROR al enviar SAPBR PWD");
  }else {
    Serial.println("SAPBR Enviado Correctamente");
  }
  delay(500);
  //Enable GPRS. Wait for OK response.
  if(0 != sendCmdAndWaitForResp("AT+SAPBR=1,1\r\n","OK",DEFAULT_TIMEOUT)){
    Serial.println("ERROR al enviar SAPBR");
  }else {
    Serial.println("SAPBR Enviado Correctamente");
  }
  delay(500);
  //Get IP address to check if connection is correct. Wait for OK response.
  if(0 != sendCmdAndWaitForResp("AT+SAPBR=2,1\r\n","OK",DEFAULT_TIMEOUT)){
    Serial.println("ERROR al enviar SAPBR");
    return;
  }else {
    Serial.println("SAPBR Enviado Correctamente");
  }
  delay(500);
  //Enable HTTP. Wait for OK response.
  if(0 != sendCmdAndWaitForResp("AT+HTTPINIT\r\n","OK",DEFAULT_TIMEOUT)){
    Serial.println("ERROR al enviar HTTPINIT");
  }else {
    Serial.println("HTTPINIT Enviado Correctamente");
  }
  delay(500);
  //Set HTTP profile identifier. Wait for OK response.
  if(0 != sendCmdAndWaitForResp("AT+HTTPPARA=\"CID\",1\r\n","OK",DEFAULT_TIMEOUT)){
    Serial.println("ERROR al enviar HTTPPARA CID");
  }else {
    Serial.println("HTTPARA CID Enviado Correctamente");
  }
  delay(500);
  //HTTP type of content
  if(0 != sendCmdAndWaitForResp("AT+HTTPPARA=\"CONTENT\",\"application/x-www-form-urlencoded\"\r\n","OK",DEFAULT_TIMEOUT)){
    Serial.println("ERROR al enviar HTTPPARA CONTENT");
  }else {
    Serial.println("HTTPARA CONTENT Enviado Correctamente");
  }
  delay(500);
  //URL of the HTTP Server: weathermonitor.tarkdigital.com
  if(0 != sendCmdAndWaitForResp("AT+HTTPPARA=\"URL\",\"weathermonitor.tarkdigital.com\"\r\n","OK",DEFAULT_TIMEOUT)){
    Serial.println("ERROR al enviar HTTPPARA URL");
  }else {
    Serial.println("HTTPARA URL Enviado Correctamente");
  }
  Serial.println("Conection Completed, start sending data from GPS"); //Inicialization completed.
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                 MPU Data Acquisition and Transformation                                  //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//MPU Inicialization
void mpuInit(){
  devStatus = mpu.dmpInitialize();  // make sure it worked (returns 0 if so)
  if (devStatus == 0) {
      // turn on the DMP, now that it's ready
      Serial.println(F("Enabling DMP..."));
      mpu.setDMPEnabled(true);

      // enable Arduino interrupt detection
      Serial.println(F("Enabling interrupt detection (Arduino external interrupt 0)..."));
      attachInterrupt(0, dmpDataReady, RISING);
      mpuIntStatus = mpu.getIntStatus();

      // set our DMP Ready flag so the main loop() function knows it's okay to use it
      Serial.println(F("DMP ready! Waiting for first interrupt..."));
      dmpReady = true;

      // get expected DMP packet size for later comparison
      packetSize = mpu.dmpGetFIFOPacketSize();
  } else {
      // ERROR!
      // 1 = initial memory load failed
      // 2 = DMP configuration updates failed
      // (if it's going to break, usually the code will be 1)
      Serial.print(F("DMP Initialization failed (code "));
      Serial.print(devStatus);
      Serial.println(F(")"));
  }
}
//INTERRUPT DETECTION ROUTINE
volatile bool mpuInterrupt = false;     // indicates whether MPU interrupt pin has gone high
void dmpDataReady() {
    mpuInterrupt = true;
}
/*
   This function reads MPU sensor to get the aceleration forces and degrees.
*/
String readMpuVariables() {
  // if programming failed, don't try to do anything
  if (!dmpReady) return;
  // wait for MPU interrupt or extra packet(s) available
  // reset interrupt flag and get INT_STATUS byte
  mpuInterrupt = false;
  mpuIntStatus = mpu.getIntStatus();

  // get current FIFO count
  fifoCount = mpu.getFIFOCount();

  // check for overflow (this should never happen unless our code is too inefficient)
  if ((mpuIntStatus & 0x10) || fifoCount == 1024) {
      // reset so we can continue cleanly
      mpu.resetFIFO();
      //Serial.println("FIFO overflow!");
  } else if (mpuIntStatus & 0x01) {
      // wait for correct available data length, should be a VERY short wait
      while (fifoCount < packetSize) fifoCount = mpu.getFIFOCount();

      // read a packet from FIFO
      mpu.getFIFOBytes(fifoBuffer, packetSize);

      // track FIFO count here in case there is > 1 packet available
      // (this lets us immediately read more without waiting for an interrupt)
      fifoCount -= packetSize;

      #ifdef OUTPUT_READABLE_YAWPITCHROLL
          // display Euler angles in degrees
          mpu.dmpGetQuaternion(&q, fifoBuffer);
          mpu.dmpGetGravity(&gravity, &q);
          mpu.dmpGetYawPitchRoll(ypr, &q, &gravity);
          Xaxis = ypr[0] * 180/M_PI;
          Yaxis = ypr[1] * 180/M_PI;
          Zaxis = ypr[2] * 180/M_PI;
      #endif
  }
  return ("&x=" + (String)Xaxis +
          "&y=" + (String)Yaxis +
          "&z=" + (String)Zaxis);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                 Sensor Data Acquisition and transformation                               //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
   This function reads DHT11 sensor to get temperature, humidity and heat index.
   Then, reads ML8511 sensor to get the amount of incident light (uv).
   Then, it reads the internal temperature of the IMU.
   Finally, it reads BMP180 sensor to get barometric pressure and altitude.
*/
String readWeatherVariables() {
  String weatherString = "";

  //--DHT11 sensor readings.
  sensors_event_t dht11;
  dht.temperature().getEvent(&dht11);                           //--Temperature.
  if (isnan(dht11.temperature)) { weatherString += "&temp=0"; }       //--Failed to read temperature.
  else { weatherString += "&temp=" + (String) dht11.temperature; }       //--Log temperature reading.
  //weatherString += ",";                                         //--Add comma to separate values.

  dht.humidity().getEvent(&dht11);                              //--Humidity.
  if (isnan(dht11.relative_humidity)) { weatherString += "&hum=0"; } //--Failed to read humidity.
  else { weatherString += "&hum=" + (String) dht11.relative_humidity; }   //--Log humidity reading.
  //weatherString += ",";                                         //--Add comma to separate values.

  if (isnan(dht11.temperature)) {  weatherString += "&hi=0"; }    //-- Heat index.
  else {
    int t = dht11.temperature;
    int h = dht11.temperature;
    float heatIndex = (-42.379) + (2.04901523 * t) + (10.14333127 * h) - (0.22475541 * t * h) - (6.83783 *
                      pow(10, -3) * pow(t, 2)) - (5.481717 * pow(10, -2) * pow(h, 2)) + (1.22874 * pow(10, -3) * pow(t, 2) * h)
                      + (8.5282 * pow(10, -4) * t * pow(h, 2)) - (1.99 * pow(10, -6) * pow(t, 2) * pow(h, 2));
    weatherString += "&hi=" + (String) heatIndex;
  }

  //--UV ML8511 sensor reading.
  weatherString += "&uv=" + readUV();

  //--BMP180 sensor reading.
  weatherString += readBMP180();

  return weatherString;
}
/*
   This function reads the input voltage being detected by the sensor due to light intensity, the it is compared
   with a 3.3V reference to compute the UV intensity.
*/
String readUV() {
  String uv = "";
  int uvLevel = averageRead(outUV);                         //-- Read input.
  int refLevel = averageRead(ref_3V3);                      //-- Read reference.
  float outV = 3.3 / refLevel * uvLevel;                    //-- Use 3.3V pin as a reference to get an accurate output.
  float uvIntensity = mapFloat(outV, 0.99, 2.8, 0.0, 15.0); //-- Map voltage to get the intensity.
  if (uvLevel == 2 || uvLevel == 1 || uvLevel == 9) { uv += "-50"; }
  else { uv += uvIntensity; }
  return uv;
}

//--Gets an accurate reading by doing an average of 8 consecutive readings.
int averageRead(int pin) {
  byte numberOfReadings = 8;
  unsigned int runningValue = 0;
  for (int x = 0; x < numberOfReadings; x++) { runningValue += analogRead(pin); }
  runningValue /= numberOfReadings;
  return (runningValue);
}

//--Maps the floating value received.
float mapFloat(float x, float inMin, float inMax, float outMin, float outMax) {
  return (x - inMin) * (outMax - outMin) / (inMax - inMin) + outMin;
}
/*
   This function reads the values of the BMP180 sensor to get the values of pressure and altitude.
*/
String readBMP180 () {
  String press_alt = "";
  double P, A; //variables

  P = getPressure();                 //--get new Pressure
  A = pressure.altitude(P, baseline); //--get altitute

  press_alt += "&pre=" + (String) P + "&alt=" + (String) A;
  // To test pressure in serial monitor uncomment this:
  /*  Serial.print("Pressure: ");
      Serial.print(P,2);
      Serial.print(" mb, "); */
  // To test altitude in serial monitor:
  /* Serial.print("Altitude: ");
     Serial.print(A);
     Serial.println(" meters."); */
  return press_alt;
}
//--Gets the pressure from the sensor.
double getPressure() {                   //--To obtain Temperature, Pressure and Altitude
  char status;
  double T, P;
  status = pressure.startTemperature();
  if (status != 0) {
    delay(status);
    status = pressure.getTemperature(T); //--Measurement stored in T.
    if (status != 0) {
      status = pressure.startPressure(3); //--Start pressure measurement; oversampling setting from 0 to 3.
      if (status != 0) {
        delay(status);
        status = pressure.getPressure(P, T); //--Measurement stored in P.
        if (status != 0) {
          return (P);                    //--return the value of the new pressure.
        }
      }
    }
  }
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                           Sensor Configuration                                           //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
   Initializating DHT11 humidity and temperature sensor.
   Getting sensor details and and setting up delay for the sampling frequency.
*/
void initDHT11() {
  dht.begin();                           //--Initializating DHT sensor.
  sensor_t dht11;
  dht.temperature().getSensor(&dht11);   //--Getting temperature details.
  dht.humidity().getSensor(&dht11);      //--Getting humidity details.
  delayms = dht11.min_delay / 1000;      //--Setting up the delay of sensor readings.
}
/*
   Initialize UV sensor.
*/
void initUV() {
  pinMode(outUV, INPUT);
  pinMode(ref_3V3, INPUT);
}
/*
   Initialize BMP180 sensor.
*/
void initBMP180() {
  pressure.begin();
  baseline = getPressure();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                           Initial Configuration                                          //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//-- Initial configurations.
void setup() {
  Serial.begin(9600);       //--Baud rate of PC Serial
  Serial1.begin(9600);      //GPRS Serial
  Serial2.begin(9600);      //GPS Serial
  initDHT11();              //--Initialize DHT11 temperature & humidity sensor.
  initUV();                 //--Initialize UV sensor.
  initBMP180();             //--Initialize BMP180 Barometric sensor.
  periodTime = 1000 / 25;
  delay(2000);
  Serial.println("Setup Completed, starting TCP Conection");
  //Initialization of GPRS and TCP conection to server
  gprsInit();
  //MPU Inicialization
  mpu.initialize();
  mpuInit();
}

//-- Main program.
void loop() {
  String weatherString = readWeatherVariables(); //--Read weather variables from sensors.
  String mpuString = readMpuVariables();  //Read MPU variables
  //Wait for GPS to be available and get lat,lng and time data
  while(Serial2.available()){
    String slat, slng;
    if(gps.encode(Serial2.read())){ //Encode data from GPS Module
      gps.f_get_position(&lat,&lng);  //Get lat and lng form GPS
      slat = String(lat == TinyGPS::GPS_INVALID_F_ANGLE ? 0.0 : lat, 6);  //Transform data to NMA format
      slng = String(lng == TinyGPS::GPS_INVALID_F_ANGLE ? 0.0 : lng, 6);  //Transform data to NMA format
      //Get time of Satellite and adjust to central time
      gps.crack_datetime(&year,&month,&day,&hour,&minute,&second,&hundreths);
      if (hour < 6){
        day = day - 1;
        hour = hour + 18;
      } else {
        hour = hour - 6;
      }
      //Save data received form GPS in to a string variable. Format of http data: "key1=value1&key2=value2..."
      String gpsString =
              "datelog=" + String(year) + "-"+ String(month) + "-"+ String(day) + " "
              + String(hour) + ":"+ String(minute) + ":" + String(second) +
              "&lat=" + slat + "&lng=" + slng ;
      //Concatenate data of GPS, weather and accelerometer. Char(26) = CNTRL + Z is used identifya the end of string in GPRS module.
      String data = gpsString + mpuString + weatherString + char(26);
      int longString = data.length() - 1; //Get length of the data string
      //Concatenate the AT Cmnd to tell GPRS the lencht of the data in bytes and and the timeout, default = 10000ms
      String bufferCmd = "AT+HTTPDATA=" + (String)longString + ",10000\r\n";
      //send Cmd and wait for DOWNLOAD
      if(0 != sendCmdAndWaitForResp(bufferCmd,"DOWNLOAD",DEFAULT_TIMEOUT)){
        Serial.println("ERROR al enviar HTTPDATA NO SE RECIBIO DOWNLOAD");
      } else {
         //Save sensors data into GPRS Module. Wait for OK
         Serial.println("SE RECIBIO DOWNLOAD, guardando datos");
         Serial.println(data);
         if(0 != sendCmdAndWaitForResp(data,"OK",DEFAULT_TIMEOUT)){
         Serial.println("ERROR al guardar los Datos");
         } else {
          Serial.println("Se guardo el dato correctamente");
         }
      }
      delay(500);
      //Send data to server. type of conection is TCP and the HTTP conection is POST
      if(0 != sendCmdAndWaitForResp("AT+HTTPACTION=1\r\n","OK",DEFAULT_TIMEOUT)){
        Serial.println("ERROR al enviar HTTPACTION TCP");
      } else {
        Serial.println("Se enviaron los datos correctamente");
      }
      delay(5000);
    }
  }
}


