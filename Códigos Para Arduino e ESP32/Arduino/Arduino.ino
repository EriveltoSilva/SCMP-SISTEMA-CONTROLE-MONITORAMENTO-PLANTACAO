/*
 * Autor:Erivelto Clénio da Costa e Silva
 * Data última Atualização:02/03/2023
 * Actuadore: Bomba
 * Input:
 * Objectivo: Acionar um sino escolar em horarios programados
 *
 *Principais Componentes usados:
 *** 1-ARDUINO UNO (1)
 *** 2-LORA E32 (1)
 *** 3-SENSOR DE CHUVA (1)
 *** 4-ULTRASSONCO (1)
 *** 5-LCD COM I2C (1)
 *** 6-TRANSISTORES BC548 (6) COM RESISTORES (6)
 ***  
*/ 
///////////// Inclusão de Bibliotecas /////////////
#include <SoftwareSerial.h>                   /////
///////////////////////////////////////////////////

////////// Definição de Pinos e Objectos //////////
#define BOMBA 13                              /////
#define SENSOR_SOLO_1 3                       /////
#define SENSOR_SOLO_2 2                       /////
#define SENSOR_SOLO_3 11                      /////
#define SENSOR_SOLO_4 10                      /////
#define SENSOR_RESERVATORIO_VAZIO 4           /////
#define SENSOR_RESERVATORIO_BAIXO 5           /////
#define SENSOR_RESERVATORIO_MEDIO 6           /////
#define SENSOR_RESERVATORIO_ALTO 7            /////
#define SENSOR_RESERVATORIO_CHEIO 12          /////
#define SENSOR_CHUVA A0                       /////
#define VAZIO "---"                           /////
///////////////////////////////////////////////////

///////////////////// Variaveis ///////////////////
char modo = 'A';                              /////
String sensorChuva = VAZIO;                   /////
String sensorSolo = VAZIO;                    /////
String sensorReservatorio = VAZIO;            /////
String nivelSolo = VAZIO;                     /////
String nivelChuva = VAZIO;                    /////
String nivelReservatorio = VAZIO;             /////
String estadoBomba = VAZIO;                   /////
unsigned long timer = 0;                      /////
unsigned long tempoRecepcao = 0;              /////
///////////////////////////////////////////////////

///////////////////////////////////////////////////
SoftwareSerial lora(8, 9); // RX, TX          /////
///////////////////////////////////////////////////


//////////////////////////////////////////////////////////
void receberDados();                                 /////
void enviarDados();                                  /////
void ligarBomba();                                   /////
void lerSensores();                                  /////
void desligarBomba();                                /////
//////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////
void setup() {
  // put your setup code here, to run once:
  pinMode(BOMBA, OUTPUT);
  desligarBomba();
  pinMode(SENSOR_SOLO_1, INPUT_PULLUP);
  pinMode(SENSOR_SOLO_2, INPUT_PULLUP);
  pinMode(SENSOR_SOLO_3, INPUT_PULLUP);
  pinMode(SENSOR_SOLO_4, INPUT_PULLUP);
  pinMode(SENSOR_RESERVATORIO_BAIXO, INPUT_PULLUP);
  pinMode(SENSOR_RESERVATORIO_MEDIO, INPUT_PULLUP);
  pinMode(SENSOR_RESERVATORIO_ALTO, INPUT_PULLUP);  
  pinMode(SENSOR_RESERVATORIO_CHEIO, INPUT_PULLUP);  
  pinMode(SENSOR_CHUVA, INPUT);
  
  Serial.begin(9600);
  delay(1000);
  lora.begin(9600);
  Serial.println("SISTEMA INICIADO COM SUCESSO!");
}

//////////////////////////////////////////////////////////
void loop() {
  // put your main code here, to run repeatedly:
  receberDados(); 
  if(millis()-timer>60000) modo = 'A';
  if(millis()-tempoRecepcao>2000){
      tempoRecepcao = millis();
      lerSensores();
  }
}

//////////////////////////////////////////////////////////
void lerSensores(){
    byte valorChuva = map(analogRead(SENSOR_CHUVA), 0,1023, 100, 0);

    if(valorChuva>75)
    {
      nivelChuva = "INTENSA";
      sensorChuva=">75%";
    }
    else if(valorChuva>50){
       nivelChuva = "MODERADA";
       sensorChuva="~50%";
    }
    else if(valorChuva>25){
      nivelChuva = "FRACA";
      sensorChuva="25%";
    } 
    else if(valorChuva >10){
        nivelChuva = "SERENO";
        sensorChuva="10%";
    }
    else
    {
      nivelChuva = "SEM_CHUVA";
      sensorChuva="0%"; 
    }

    if(!digitalRead(SENSOR_RESERVATORIO_CHEIO))
    {
      nivelReservatorio = "CHEIO";
      sensorReservatorio = "100%";
    } 
    else if(!digitalRead(SENSOR_RESERVATORIO_ALTO)) 
    {
      nivelReservatorio = "ALTO";
      sensorReservatorio = ">75%";
    } 
    else if(!digitalRead(SENSOR_RESERVATORIO_MEDIO)) 
    {
      nivelReservatorio = "MEDIO";
      sensorReservatorio = "~50%";
    }
    else if(!digitalRead(SENSOR_RESERVATORIO_BAIXO))
    {
      nivelReservatorio = "BAIXO";
      sensorReservatorio = "<30%";
    }
    else
    {
      nivelReservatorio = "VAZIO";
      sensorReservatorio = "~0%";
    }


    if(!digitalRead(SENSOR_SOLO_4)) 
    {
        nivelSolo = "ALAGADO";
        sensorSolo = "~100%";
        if(modo=='A' && isBombaLigada())
          desligarBomba();
    }
    else if(!digitalRead(SENSOR_SOLO_3)) 
    {
        nivelSolo = "MOLHADO";
        sensorSolo = ">95%";
        if(modo=='A' && isBombaLigada())
          desligarBomba();
    }
    else if(!digitalRead(SENSOR_SOLO_2))
    {
        nivelSolo = "HUMIDO";
        sensorSolo = ">55%";
    } 
    else if(!digitalRead(SENSOR_SOLO_1))
    {
        nivelSolo = "PINGADO";
        sensorSolo = "<30%";
        if(modo=='A' && !digitalRead(SENSOR_RESERVATORIO_BAIXO) )
          ligarBomba();
    } 
    else
    {
        nivelSolo = "SECO";
        sensorSolo = "0%";
        if(modo=='A' && !digitalRead(SENSOR_RESERVATORIO_BAIXO))
          ligarBomba();
    } 
    estadoBomba = (digitalRead(BOMBA))?"LIGADA":"DESLIGADA";
    Serial.println("=============== DADOS ENVIADOS ==========================");
    Serial.print("Modo Projecto:");   Serial.println((modo=='A')? "AUTOMATICO":"MANUAL");
    Serial.print("Niv.Chuva:");       Serial.println(nivelChuva);
    Serial.print("Sen.Chuva:");       Serial.println(sensorChuva);
    Serial.print("Niv.Solo:");        Serial.println(nivelSolo);
    Serial.print("Sen.Solo:");        Serial.println(sensorSolo);
    Serial.print("Niv.Reservatorio:");Serial.println(nivelReservatorio);
    Serial.print("Sen.Reservatorio:");Serial.println(sensorReservatorio);
    Serial.print("Estado Bomba:");    Serial.println(estadoBomba);
    Serial.println("=========================================================");
}

//////////////////////////////////////////////////////////
boolean isBombaLigada()
{
  return (digitalRead(BOMBA)==HIGH);  
}

//////////////////////////////////////////////////////////
void ligarBomba()
{
  digitalWrite(BOMBA, HIGH);  
}

//////////////////////////////////////////////////////////
void desligarBomba()
{
  digitalWrite(BOMBA, LOW);  
}

//////////////////////////////////////////////////////////
void receberDados(){
  if (lora.available()) 
  {
    while(lora.available())
    {
      char rx = lora.read();
      Serial.write(rx);
      switch(rx)
      {
          case 'D': enviarDados();break;
          case 'L': 
              modo='M';
              timer = millis();
              ligarBomba();break;
          case 'l': 
              modo='M';
              timer = millis();
              desligarBomba(); break;
      }
    }   
  }
  if (Serial.available()) 
  {
    while(Serial.available())
    {
      char rx = Serial.read();
      Serial.write(rx);
      switch(rx)
      {
          case 'D': enviarDados();break;
          case 'L': 
              modo='M';
              timer = millis();
              ligarBomba();break;
          case 'l': 
              modo='M';
              timer = millis();
              desligarBomba(); break;
      }
    }   
  }
}

//////////////////////////////////////////////////////////
void enviarDados(){
  
  lora.print("D");                 lora.print("*");
  lora.print(nivelChuva);          lora.print("*");
  lora.print(sensorChuva);         lora.print("*");

  lora.print(nivelSolo);           lora.print("*");
  lora.print(sensorSolo);          lora.print("*");
  
  lora.print(nivelReservatorio);   lora.print("*");
  lora.print(sensorReservatorio);  lora.print("*");
  lora.print(estadoBomba);         lora.print("*");
  lora.println();
}
