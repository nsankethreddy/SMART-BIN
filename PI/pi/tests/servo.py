import RPi.GPIO as GPIO
import time

servoPIN = 17
GPIO.setmode(GPIO.BCM)
GPIO.setup(servoPIN, GPIO.OUT)

p = GPIO.PWM(servoPIN, 50) # GPIO 17 for PWM with 50Hz
p.start(7.5) # Initialization

def setAngle(angle):
    #2.5 to position to right side
    #12.5 to position to right side
    p.ChangeDutyCycle(angle)
    print("Sleeping")
    time.sleep(5)
    
try:
  setAngle(7.5) # initialize servo
  setAngle(2.5) # drop to left
  setAngle(12.5) # drop to right
  #setAngle(2.5)
  setAngle(7.5) # reset servo to initial position
  p.stop()
  GPIO.cleanup()
except KeyboardInterrupt:
  p.stop()
  GPIO.cleanup()

