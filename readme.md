Trabalho: SCMP : SISTEMA DE CONTROLE E MONITORAMENTO DE PLANTAÇÃO
* Objectivo: Fazer um sistema capza de controlar o nível de água em um reservatório, checar o nível de humidade do solo, a presença/ausência de chuva, bem como o seu nível de intensidade caso exista, e a ativação automática de uma bomba eléctrica caso o solo esteja seco e haja água no reservatório.
* Deve também permitir a visualização dos dados remotamente fazendo o enviou dos dados colhidos na plantação por meio de transmissores Lora E32 e recepção para posterior  persistência dos dados por meio de um servidor web (no caso XAMPP) e banco de dados MySql.

* Autor:Erivelto Clénio da Costa e Silva (Otlevire)
* Para: Diassonama
* Monografia Universidade Católica de Angola
* Data última Atualização:02/03/2023
* Actuadore: Bomba
* Input:
*
*Principais Componentes usados:
*** 1-ARDUINO UNO (1)
*** 2-ESP32 (1)
*** 3-LORA E32 (2)
*** 4-SENSOR DE CHUVA (1)
*** 5-ULTRASSONCO (1)
*** 6-LCD COM I2C (1)
*** 7-TRANSISTORES BC548 (6) COM RESISTORES (6)

* SGBD escolhido: MySql
* Nome do Banco de Dados Criado: plantacao
* Quantidade de tabelas: 2


Abaixo segue o Esquema Eléctrico do Projecto:

![Esquema elétrico](https://github.com/Otlevire/SCMP-Diassonama/assets/125351173/ee6ef813-97c8-4f4d-af32-ea55a405bb4c)

Abaixo imagens das páginas do projecto:

Login:

![pagina Login](https://github.com/Otlevire/SCMP-Diassonama/assets/125351173/594d00cf-e752-4266-af37-bf125f12e1c4)

Dashboard Principal de Visualização dos Dados:

![DashboardPrincipal](https://github.com/Otlevire/SCMP-Diassonama/assets/125351173/5b4cbb63-4cf2-4920-86d7-a76679f8da5e)

Continuação...

![DashboardPrincipal2](https://github.com/Otlevire/SCMP-Diassonama/assets/125351173/99fa3151-e98a-40db-a0eb-e5d7cd3c125d)

Cadastro:

![Cadastro](https://github.com/Otlevire/SCMP-Diassonama/assets/125351173/f2859677-7e1b-49c5-bbee-0409ae8dbaef)

Consulta de Dados no Banco e Visualização dos dados:

![Consulta a Bd](https://github.com/Otlevire/SCMP-Diassonama/assets/125351173/a4b3e966-fadc-40c2-b78d-aad5fc47a441)

Referência utilizada para interface: https://www.youtube.com/watch?v=CkVrmLLHmuI SCMP-Diassonama

