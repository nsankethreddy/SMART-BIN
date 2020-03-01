import RPi.GPIO as GPIO

from time import sleep

GPIO.setmode(GPIO.BCM)
GPIO.setup(17, GPIO.IN)

sensor = GPIO.input(17)

while 1:

  if(sensor == 1):
      print("1")
      sleep(0.1)
  elif(sensor == 0):
      print("0")
      sleep(0.1)