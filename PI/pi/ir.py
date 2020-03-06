import RPi.GPIO as GPIO
import time
import subprocess

sensor = 16
buzzer = 18

GPIO.setmode(GPIO.BOARD)
GPIO.setup(sensor,GPIO.IN)
GPIO.setup(buzzer,GPIO.OUT)

GPIO.output(buzzer,False)
print("IR Sensor Ready.....")
print( " ")

try: 
   while True:
      if GPIO.input(sensor):
          #GPIO.output(buzzer,True)
          print("Yet to sense object...")
          while GPIO.input(sensor):
              time.sleep(0.2)
      else:
          #GPIO.output(buzzer,False)
          
          print("Object Detected")
          subprocess.run(["./script.sh"])

except KeyboardInterrupt:
    GPIO.cleanup()
