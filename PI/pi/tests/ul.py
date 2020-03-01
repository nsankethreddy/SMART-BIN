#!/usr/bin/python
import RPi.GPIO as GPIO
import time
from twilio.rest import Client
def sendSMS(msg):
    account_sid = "AC837856c18f1469554bb919bd638540dc"
    auth_token = "2bb74470d36e9ea1f51047ccbb4ddfeb"
    client = Client(account_sid, auth_token)
    client.api.account.messages.create(to="+917619411837",from_="+12058329946",body=msg)
    print("SMS sent !")


try:
      GPIO.setmode(GPIO.BOARD)

      PIN_TRIGGER = 13
      PIN_ECHO = 15

      GPIO.setup(PIN_TRIGGER, GPIO.OUT)
      GPIO.setup(PIN_ECHO, GPIO.IN)

      GPIO.output(PIN_TRIGGER, GPIO.LOW)

      print ("Waiting for sensor to settle")

      time.sleep(2)

      print( "Calculating distance")

      GPIO.output(PIN_TRIGGER, GPIO.HIGH)

      time.sleep(0.00001)

      GPIO.output(PIN_TRIGGER, GPIO.LOW)

      while GPIO.input(PIN_ECHO)==0:
            pulse_start_time = time.time()
      while GPIO.input(PIN_ECHO)==1:
            pulse_end_time = time.time()

      pulse_duration = pulse_end_time - pulse_start_time
      distance = round(pulse_duration * 17150, 2)
      print ("Distance:",distance,"cm")
      if(distance < 10):
          sendSMS("Trash is full. Plis run systemCls()")

finally:
      GPIO.cleanup()
