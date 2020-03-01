from picamera import PiCamera
from time import sleep
import subprocess
import datetime

def captureImage():

  camera = PiCamera()
  camera.start_preview()
  print("Capturing image")
  sleep(5)
  camera.capture('/home/pi/Desktop/image.jpg')
  print("Image capture done")
  camera.stop_preview()

captureImage()

subprocess.run(["scp", "/home/pi/Desktop/image.jpg", "user@192.168.43.108:/home/user"])

dt = datetime.datetime.now().strftime('%d-%m-%Y %H:%M:%S')
dateStr,timeStr = dt.split()

path_to_pic = "/home/user/Checked/"+dateStr+"_"+timeStr+".jpg"
with open("/home/pi/Desktop/d.txt","w+") as dataFile : 
  dataFile.write(dateStr+" " +timeStr)

subprocess.run(["scp", "/home/pi/Desktop/image.jpg", "user@192.168.43.108:/home/user/Checked/"+dateStr+"_"+timeStr+".jpg"])
subprocess.run(["scp", "/home/pi/Desktop/d.txt", "user@192.168.43.108:/home/user/Desktop"])
