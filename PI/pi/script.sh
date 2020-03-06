#! /bin/bash
python3 ~/tests/cam.py
VAR=$(date +%F-%H-%M-%S)
# scp user@192.168.43.108:
ssh user@192.168.43.108 << EOF
  cp /home/user/image.jpg /home/user/Checked/"${VAR}.jpg"
  cd /home/user/onLoad/Waste-classification/
  python3 main.py |& tail -c3 | head -c1 > ~/a.txt
EOF

scp user@192.168.43.108:~/a.txt .
VAR_DATA=$(cat ~/a.txt)
echo "${VAR}:${VAR_DATA}:G01" >> data.txt
scp data.txt user@192.168.43.108:
python3 ~/tests/servo2.py
python3 ~/tests/ul.py
