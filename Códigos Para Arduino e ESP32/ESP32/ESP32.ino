/**************************************************
   AUTHOR: ERIVELTO CLÉNIO DA COSTA E SILVA
   FOR:DIASSONAMA
   SISTEMA DE CONTROLE DE PLANTAÇÃO
   CREATED AT: 04-03-2023
 *************************************************/

////////////////// Labraries Used  ////////////////
#include <WiFi.h>                             /////
#include <PubSubClient.h>                     /////
#include <ESPmDNS.h>                          /////
///////////////////////////////////////////////////

////////////////  PIN CONFIGURATIONS //////////////
#define LED 2                                /////
#define RXD2 16         //RX da serial do ESP32////
#define TXD2 17         //TX da serial do ESP32////
///////////////////////////////////////////////////

/////////////  NETWORK CONFIGURATIONS /////////////
#define SSID "Yonice"                         /////
#define PASSWORD "ste053288##"                /////
#define ENDERECO_PC  "192.168.100.232"        /////
#define PORTA_PC 80                           /////
///////////////////////////////////////////////////

/////////////// MQTT BROKER CONNECTIONS ///////////
#define MQTT_BROKER "broker.hivemq.com"       /////
#define MQTT_PORT 1883                        /////
///////////////////////////////////////////////////

/////////////////////////////////////// MQTT CONFIGURATIONS ///////////////////////////////
#define MQTT_DEVICE_ID  "diassonama-plantacao"
const char *TOPICO_MQTT_NIVEL_CHUVA =   "diassonama_plantacao_nivelChuva";
const char *TOPICO_MQTT_SENSOR_CHUVA  = "diassonama_plantacao_sensorChuva";
const char *TOPICO_MQTT_NIVEL_RESERVATORIO =  "diassonama_plantacao_nivelReservatorio";
const char *TOPICO_MQTT_SENSOR_RESERVATORIO =   "diassonama_plantacao_sensorReservatorio";
const char *TOPICO_MQTT_NIVEL_SOLO =  "diassonama_plantacao_nivelSolo";
const char *TOPICO_MQTT_SENSOR_SOLO =  "diassonama_plantacao_sensorSolo";
const char *TOPICO_MQTT_BOMBA_PUB  = "diassonama_plantacao_bombaAgua_pub";
const char *TOPICO_MQTT_BOMBA_SUB  = "diassonama_plantacao_bombaAgua_sub";
///////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////// VARIABLES /////////////////////////
const byte TAM = 8 ;                                           /////
const int tempoBackup = 10000;                                 /////
unsigned long int tempoDelay = 0;                              /////
unsigned long int tempoDelayBD = 0;                            /////
String dadosSeparados[9];
const char* LISTA_TOPICOS_PUB[] = {"D",                        /////
                                   TOPICO_MQTT_NIVEL_CHUVA,         /////
                                   TOPICO_MQTT_SENSOR_CHUVA,        /////
                                   TOPICO_MQTT_NIVEL_RESERVATORIO,  /////
                                   TOPICO_MQTT_SENSOR_RESERVATORIO, /////
                                   TOPICO_MQTT_NIVEL_SOLO,          /////
                                   TOPICO_MQTT_SENSOR_SOLO,         /////
                                   TOPICO_MQTT_BOMBA_PUB,           /////
                                  };                                                       /////
////////////////////////////////////////////////////////////////////

/////////////  OBJECTS CONFIGURATIONS /////////////
WiFiClient wifiClient;                        /////
HardwareSerial lora(2);                       /////
PubSubClient MQTT(wifiClient);                /////
///////////////////////////////////////////////////

/////////////  FUNCTIONS PROTOTIPES   /////////////
void initConfig();                            /////
void setupWIFI();                             /////
void setupMQTT();                             /////
void publishInfo(String texto);               /////
void sendLocalServer(String dados);           /////
String comun();
///////////////////////////////////////////////////

//////////////////////////////////////////////////
void setup()
{
  initConfig();
  setupWIFI();
  setupMQTT();
}

//////////////////////////////////////////////////
void loop()
{
  if (millis() - tempoDelay > 1800)
  {
    tempoDelay = millis();
    lora.print('D');
    String dadosRecebidos = comun();
    if (dadosRecebidos != "")
    {
      sendLocalServer(dadosRecebidos);
      publishInfo(dadosRecebidos);
      digitalWrite(LED, !digitalRead(LED));
    }
  }
  setupWIFI();
  setupMQTT();
  MQTT.loop();
  delay(5);
}

void initConfig()
{
  pinMode(LED, OUTPUT);
  digitalWrite(LED, LOW);
  Serial.begin(115200); delay(500);
  lora.begin(9600, SERIAL_8N1, RXD2, TXD2); delay(500);
  Serial.println("CONFIGURAÇÕES INICIAS SETADAS!");
}

void setupWIFI() {
  if (WiFi.status() == WL_CONNECTED) return;
  Serial.println();
  Serial.print("CONECTANDO A WIFI:");
  Serial.println(SSID);
  Serial.print("PROCURANDO");
  WiFi.mode(WIFI_STA);
  WiFi.begin(SSID, PASSWORD);
  for (int i = 0; WiFi.status() != WL_CONNECTED; i++) {
    digitalWrite(LED, !digitalRead(LED));
    delay(150); Serial.print(".");
    if (i == 100)
      ESP.restart();
  }
  Serial.print("\nCONECTADO AO WIFI NO IP:");
  Serial.println(WiFi.localIP());
}

void setupMQTT() {
  MQTT.setServer(MQTT_BROKER, MQTT_PORT);
  MQTT.setCallback(mqttCallback);

  while (!MQTT.connected()) {
    Serial.print("- MQTT SETUP: TENTADO SE CONECTAR AO BROKER MQTT: ");
    Serial.println(MQTT_BROKER);
    if (MQTT.connect(MQTT_DEVICE_ID)) {
      Serial.println("- MQTT SETUP: CONECTADO COM SUCESSO!");
      MQTT.subscribe(TOPICO_MQTT_BOMBA_SUB);
    }
    else
    {
      Serial.println("- MQTT SETUP: FALHA AO SE CONECTAR, TENTANDO NOVAMENTE EM 2s");
      delay(1000);
    }
  }
}

void sendLocalServer(String dados)
{
  Serial.print("CONECTANDO AO SERVIDOR LOCAL:");
  Serial.println(ENDERECO_PC);
  // Use WiFiClient class to create TCP connections
  WiFiClient client;
  if (!client.connect(ENDERECO_PC, PORTA_PC)) {
    Serial.println("FALHA AO SE CONECTAR AO SERVIDOR LOCAL");
  }
  else {
    client.print(String("GET http://") + ENDERECO_PC +
                 String("/Diassonama/paginas/p.php?") +
                 String("&nivelChuva=") + dadosSeparados[1] +
                 String("&sensorChuva=") + dadosSeparados[2] +
                 String("&nivelSolo=") + dadosSeparados[3] +
                 String("&sensorSolo=") + dadosSeparados[4] +
                 String("&nivelReservatorio=") + dadosSeparados[5] +
                 String("&sensorReservatorio=") + dadosSeparados[6] +
                 String("&estadoBomba=") + dadosSeparados[7] +
                 String("&salvar=") + ((possoGuardar()) ? "1" : "0") +
                 " HTTP/1.1\r\n" +
                 "Host: " + ENDERECO_PC + "\r\n" + "Connection: close\r\n\r\n");

    unsigned long timeout = millis();
    while (client.available() == 0) {
      if (millis() - timeout > 1000) {
        Serial.println(">>> Client Timeout !");
        client.stop();
        return;
      }
    }

    // Read all the lines of the reply from server and print them to Serial
    while (client.available()) {
      String line = client.readStringUntil('\r');
      Serial.print(line);
    }
    Serial.println();
    Serial.println("DADOS ENVIADOS AO SERVER LOCAL\nFECHANDO A CONEXÃO");
  }
}


void mqttCallback(char* topic, byte* payload, unsigned int length)
{
  String msg = "";
  Serial.print("- MQTT TOPICO DO CALLBACK: ");
  Serial.println(topic);

  //obtem a string do payload recebido
  for (int i = 0; i < length; i++)
  {
    char c = (char)payload[i];
    msg += c;
  }
  Serial.println("Mensagem Recebida:" + String(msg));

  if (msg.equals("BOMBA1"))
  {
    digitalWrite(LED, HIGH);
    lora.print('L');
    Serial.println("ENVIADO PARA A PLANTACAO: BOMBA1");
  }
  else if (msg.equals("BOMBA0"))
  {
    digitalWrite(LED, LOW);
    lora.print('l');
    Serial.println("ENVIADO PARA A PLANTACAO: BOMBA0");
  }
}


void publishInfo(String texto )
{
  byte k = 0;
  int cont = 0;
  char *res = NULL;
  int j = 0;

  for (int i = 0; texto[i] != '\0'; i++)cont++;
  char str[cont];
  for (int i = 0; i < cont; i++) str[i] = texto[i];
  Serial.println("--------------------------------------------------");
  res = strtok(str, "*");

  while (res != NULL)
  {
    Serial.print("PUBLICANDO(");  Serial.print(LISTA_TOPICOS_PUB[k]);
    Serial.print("):");           Serial.println(res);
    dadosSeparados[j++] = String(res);
    MQTT.publish(LISTA_TOPICOS_PUB[k++], res); // publish in topic
    res = strtok(NULL, "*");
  }
  Serial.println("--------------------------------------------------\n");
}

/////////////////////////////////////////////////////////////////////////////
String comun()
{
  String texto = "";
  delay(10);
  if (lora.available() > 0)
  {
    while (lora.available() > 0)
    {
      char rx = lora.read();
      texto += rx;
    }
    //dadosLocal = texto;
    //dadosRecebidos = texto;
    Serial.println("Dados Rec Serial:" + texto);
    return texto;
  }
  return texto;
}

//////////////////////////////////////////////////////////////////////////////
boolean possoGuardar()
{
  if (millis() - tempoDelayBD > tempoBackup)
  {
    tempoDelayBD = millis();
    return true;
  }
  return false;
}
