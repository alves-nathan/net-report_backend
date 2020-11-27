#!/bin/bash
var=$(date +"%FORMAT_STRING")
now=$(date +"%m_%d_%Y_%H_%M")
cd /home/pi/internet-report/data/
/home/pi/executar_teste_velocidade.sh > net_report_$now.txt
