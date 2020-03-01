import RPi.GPIO as GPIO
import time

servoPIN = 17
GPIO.cleanup()
GPIO.setmode(GPIO.BCM)
GPIO.setup(servoPIN, GPIO.OUT)


def SetAngle(angle):
    duty = angle / 18 + 2
    GPIO.output(servoPIN, True)
    pwm.ChangeDutyCycle(duty)
    sleep(1)
    GPIO.output(servoPIN, False)
    pwm.ChangeDutyCycle(0)
    
p = GPIO.pwm(servoPIN, 50) # GPIO 17 for PWM with 50Hz
p.start(2.5) # Initialization
try:
    SetAngle(90)
    
except KeyboardInterrupt:
  p.stop()
  GPIO.cleanup()

