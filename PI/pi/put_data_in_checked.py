path = "/home/user/Desktop/d.txt"
# with open()

with open(path,"r+") as readFile : 
    a = readFile.readline()
date,time = a.split()

with open("/home/user/a.txt","r+") as outFile : 
    f = outFile.read()

with open("/home/user/data.txt","a+") as writeFile : 
    writeFile.write(date)
    writeFile.write("_")
    writeFile.write(time)
    writeFile.write(".jpg")
    writeFile.write("")
    writeFile.write(f)
    writeFile.write("\n")
