import time
import RPi.GPIO as GPIO
import os
import socket
import ssl
import random
import string
import json
from time import sleep
from random import uniform


from AWSIoTPythonSDK.MQTTLib import AWSIoTMQTTClient

myMQTTClient = AWSIoTMQTTClient("RishabClientID") #random key, if another connection using the same key is opened the previous one is auto closed by AWS IOT
myMQTTClient.configureEndpoint("agzd9e6yq57lg-ats.iot.us-east-1.amazonaws.com", 8883)

myMQTTClient.configureCredentials("/home/fyp/AWSIoT/root-CA.pem", "/home/fyp/AWSIoT/private.pem.key", "/home/fyp/AWSIoT/certificate.pem.crt")

myMQTTClient.configureOfflinePublishQueueing(-1) # Infinite offline Publish queueing
myMQTTClient.configureDrainingFrequency(2) # Draining: 2 Hz
myMQTTClient.configureConnectDisconnectTimeout(10) # 10 sec
myMQTTClient.configureMQTTOperationTimeout(5) # 5 sec
print ('Initiating Realtime Data Transfer From Raspberry Pi...')
myMQTTClient.connect()
print("Publishing Message from RPI")
TRIG=21
ECHO=20
TRIG1= 23
ECHO1= 24
TRIG2 = 19
ECHO2 = 13
GPIO.setmode(GPIO.BCM)
while True:
    print("Car detection in progress")
    GPIO.setwarnings(False)
    GPIO.setup(TRIG,GPIO.OUT)
    GPIO.setup(ECHO,GPIO.IN)
    GPIO.setup(TRIG1,GPIO.OUT)
    GPIO.setup(ECHO1,GPIO.IN)
    GPIO.setup(TRIG2,GPIO.OUT)
    GPIO.setup(ECHO2,GPIO.IN)
    GPIO.output(TRIG, False)
    GPIO.output(TRIG1, False)
    GPIO.output(TRIG2, False)
    print("waiting for sensor to settle")
    time.sleep(0.2)
    GPIO.output(TRIG,True)
    time.sleep(0.00001)
    GPIO.output(TRIG,False)
    while GPIO.input(ECHO)==0:
        pulse_start=time.time()
    while GPIO.input(ECHO)==1:
        pulse_end=time.time()
    pulse_duration=pulse_end-pulse_start
    distance=pulse_duration*17150
    distance=round(distance,2)
    if distance < 10:
        slotno = 1
        status="occupiedd"
        paylodmsg0="{"
        paylodmsg1 = "\"status\": \""
        paylodmsg2 = "\", \"slotno\":"
        paylodmsg4="}"
        paylodmsg = "{} {} {} {} {} {}".format(paylodmsg0, paylodmsg1, status, paylodmsg2, slotno, paylodmsg4)
        paylodmsg = json.dumps(paylodmsg) 
        paylodmsg_json = json.loads(paylodmsg)
        myMQTTClient.publish(
        topic = "home/parking",
        QoS = 1,
        payload = paylodmsg_json)
        print("vehicle found at distance of:",distance,"cm from sensor")
    else:
        slotno = 1
        status="available"
        paylodmsg0="{"
        paylodmsg1 = "\"status\": \""
        paylodmsg2 = "\", \"slotno\":"
        paylodmsg4="}"
        paylodmsg = "{} {} {} {} {} {}".format(paylodmsg0, paylodmsg1, status, paylodmsg2, slotno, paylodmsg4)
        paylodmsg = json.dumps(paylodmsg) 
        paylodmsg_json = json.loads(paylodmsg)
        myMQTTClient.publish(
        topic = "home/parking",
        QoS = 1,
        payload = paylodmsg_json)
        print("no vehicle found")
    time.sleep(2)
    GPIO.output(TRIG1, True)
    time.sleep(0.00001)
    GPIO.output(TRIG1, False)
    print ("Reading Sensor 2")
    while GPIO.input(ECHO1)==0:
      pulse_start = time.time()
    while GPIO.input(ECHO1)==1:
      pulse_end = time.time()   
    pulse_duration =pulse_end - pulse_start
    distance1 = pulse_duration * 17150
    distance1 = round( distance1,2)
    if distance1 < 10:
        slotno = 2
        status="occupiedd"
        paylodmsg0="{"
        paylodmsg1 = "\"status\": \""
        paylodmsg2 = "\", \"slotno\":"
        paylodmsg4="}"
        paylodmsg = "{} {} {} {} {} {}".format(paylodmsg0, paylodmsg1, status, paylodmsg2, slotno, paylodmsg4)
        paylodmsg = json.dumps(paylodmsg) 
        paylodmsg_json = json.loads(paylodmsg)
        myMQTTClient.publish(
        topic = "home/parking",
        QoS = 1,
        payload = paylodmsg_json)
        print("vehicle found at second slot with distance of:",distance1,"cm from sensor")
    else:
        slotno = 2
        status="available"
        paylodmsg0="{"
        paylodmsg1 = "\"status\": \""
        paylodmsg2 = "\", \"slotno\":"
        paylodmsg4="}"
        paylodmsg = "{} {} {} {} {} {}".format(paylodmsg0, paylodmsg1, status, paylodmsg2, slotno, paylodmsg4)
        paylodmsg = json.dumps(paylodmsg) 
        paylodmsg_json = json.loads(paylodmsg)
        myMQTTClient.publish(
        topic = "home/parking",
        QoS = 1,
        payload = paylodmsg_json)
        print("no vehicle found")
    time.sleep(2)
    GPIO.output(TRIG2, True)
    time.sleep(0.00001)
    GPIO.output(TRIG2, False)
    print ("Reading Sensor 3")
    while GPIO.input(ECHO2)==0:
      pulse_start = time.time()
    while GPIO.input(ECHO2)==1:
      pulse_end = time.time()   
    pulse_duration =pulse_end - pulse_start
    distance3 = pulse_duration * 17150
    distance3 = round( distance3,2)
    if distance3 < 10:
        slotno = 3
        status="occupied"
        paylodmsg0="{"
        paylodmsg1 = "\"status\": \""
        paylodmsg2 = "\", \"slotno\":"
        paylodmsg4="}"
        paylodmsg = "{} {} {} {} {} {}".format(paylodmsg0, paylodmsg1, status, paylodmsg2, slotno, paylodmsg4)
        paylodmsg = json.dumps(paylodmsg) 
        paylodmsg_json = json.loads(paylodmsg)
        myMQTTClient.publish(
        topic = "home/parking",
        QoS = 1,
        payload = paylodmsg_json)
        print("vehicle found at third slot with distance of:",distance3,"cm from sensor")
    else:
        slotno = 3
        status="availabl"
        paylodmsg0="{"
        paylodmsg1 = "\"status\": \""
        paylodmsg2 = "\", \"slotno\":"
        paylodmsg4="}"
        paylodmsg = "{} {} {} {} {} {}".format(paylodmsg0, paylodmsg1, status, paylodmsg2, slotno, paylodmsg4)
        paylodmsg = json.dumps(paylodmsg) 
        paylodmsg_json = json.loads(paylodmsg)
        myMQTTClient.publish(
        topic = "home/parking",
        QoS = 1,
        payload = paylodmsg_json)
        print("no vehicle found")


myMQTTClient.publish(
    topic = "home/helloworld",
    QoS = 1,
payload = "{Message:Message By RPI}")
